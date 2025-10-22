<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YouTubeTagGeneratorController extends Controller
{
    public function index()
    {
        return view('others.youtube-tag-generator');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'language' => 'nullable|string|size:2',
            'country' => 'nullable|string|size:2',
            'max_results' => 'nullable|integer|min:5|max:50'
        ]);

        try {
            $response = Http::withHeaders([
                'X-API-Key' => '7f5292fe-e64c-4666-a336-d80159b958e5',
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://yt-tag.zotecsoft.work/youtube-tags', [
                'keyword' => $request->keyword,
                'language' => $request->language ?? 'en',
                'country' => $request->country ?? 'US',
                'max_results' => $request->max_results ?? 20
            ]);

            \Log::info('YouTube Tag API Response:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $apiData = $response->json();
                
                // Ensure we have tags array
                $tags = $apiData['tags'] ?? [];
                
                if (!is_array($tags)) {
                    $tags = [];
                }

                return response()->json([
                    'success' => true,
                    'tags' => $tags,
                    'keyword' => $apiData['keyword'] ?? $request->keyword
                ]);
            } else {
                $errorMessage = $response->json()['error'] ?? 'API request failed with status: ' . $response->status();
                return response()->json([
                    'success' => false,
                    'error' => $errorMessage
                ], $response->status());
            }
        } catch (\Exception $e) {
            \Log::error('YouTube Tag Generator Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Failed to connect to YouTube Tags API: ' . $e->getMessage()
            ], 500);
        }
    }
}