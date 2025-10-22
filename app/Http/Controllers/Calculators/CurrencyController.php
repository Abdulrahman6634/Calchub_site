<?php

namespace App\Http\Controllers\Calculators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use App\Models\CurrencyConversion;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    public function index()
    {
        $userCalculations = [];

        if (Auth::check()) {
            $userCalculations = Auth::user()->currencyConversions() // Changed to plural
                ->latest()
                ->take(5)
                ->get();
        }

        try {
            // 1️⃣ Fetch from Frankfurter API
            $response = Http::get('https://api.frankfurter.app/currencies');
            $apiCurrencies = $response->successful() ? $response->json() : [];

            // 2️⃣ Fetch from your DB
            $dbCurrencies = Country::select('currency', 'countryName as country', 'flag_emoji')
                ->whereNotNull('currency')
                ->distinct()
                ->orderBy('currency')
                ->get()
                ->keyBy('currency');

            // 3️⃣ Merge API + DB (ensuring full coverage)
            $currencies = collect($apiCurrencies)->map(function ($name, $code) use ($dbCurrencies) {
                $country = $dbCurrencies->has($code) ? $dbCurrencies[$code]->country : null;
                $flag = $dbCurrencies->has($code) ? $dbCurrencies[$code]->flag_emoji : '🏳️';
                return (object) [
                    'code' => $code,
                    'name' => $name,
                    'country' => $country,
                    'flag' => $flag,
                ];
            })->values();

        } catch (\Exception $e) {
            $currencies = collect();
        }

        return view('calculators.currency-convert', compact('currencies', 'userCalculations'));
    }

    public function convert(Request $request)
    {
        $request->validate([
            'from'   => 'required|string|size:3',
            'to'     => 'required|string|size:3|different:from',
            'amount' => 'required|numeric|min:0.01',
        ]);

        try {
            $from = strtoupper($request->from);
            $to   = strtoupper($request->to);
            $amount = (float) $request->amount;

            // Primary API: Frankfurter
            $response = Http::get('https://api.frankfurter.app/latest', [
                'from' => $from,
                'to'   => $to,
            ]);

            // If Frankfurter didn't return the rate, try exchangerate.host (fallback)
            $data = $response->successful() ? $response->json() : null;
            if (!isset($data['rates'][$to])) {
                // try exchangerate.host as a fallback (no API key required)
                $fallback = Http::get('https://api.exchangerate.host/latest', [
                    'base' => $from,
                    'symbols' => $to,
                ]);
                $data = $fallback->successful() ? $fallback->json() : $data;
            }

            if (!isset($data['rates'][$to])) {
                Log::error("Currency API missing rate", [
                    'from' => $from, 'to' => $to, 'frankfurter' => $response->body() ?? null,
                ]);
                return response()->json([
                    'success' => false,
                    'error' => 'Conversion rate not available for the selected currencies.'
                ], 400);
            }

            $rate = (float) $data['rates'][$to];
            $convertedRaw = $amount * $rate;
            $convertedFormatted = number_format($convertedRaw, 2);

            // Save to DB
            $conversion = CurrencyConversion::create([
                'user_id' => Auth::id(),
                'from_currency'     => $from,
                'to_currency'       => $to,
                'amount'            => $amount,
                'converted_amount'  => $convertedRaw,
                'rate'              => $rate,
            ]);

            return response()->json([
                'success' => true,
                'converted' => $convertedFormatted,
                'rate'      => number_format($rate, 6),
                'conversion_id' => $conversion->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Currency conversion error: '.$e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'error' => config('app.debug') ? 'Debug: '.$e->getMessage() : 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    public function history()
    {
        if (!Auth::check()) {
            return response()->json(['conversions' => []]);
        }

        $conversions = Auth::user()->currencyConversions() // Changed to plural
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($conversion) {
                return [
                    'id' => $conversion->id,
                    'from' => $conversion->from_currency,
                    'to' => $conversion->to_currency,
                    'amount' => $conversion->amount,
                    'converted' => $conversion->converted_amount,
                    'rate' => number_format($conversion->rate, 6),
                    'date' => $conversion->created_at->format('M j, Y g:i A'),
                ];
            });

        return response()->json(['conversions' => $conversions]);
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false], 401);
        }

        $conversion = Auth::user()->currencyConversions()->findOrFail($id); // Changed to plural
        $conversion->delete();

        return response()->json(['success' => true]);
    }
}