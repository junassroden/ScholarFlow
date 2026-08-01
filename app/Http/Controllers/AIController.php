<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        try {

            $apiKey = env('GEMINI_API_KEY');
            $model = env('GEMINI_MODEL');

            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, [
                "contents" => [
                    [
                        "parts" => [
                            [
                                "text" => $request->message
                            ]
                        ]
                    ]
                ]
            ]);

            // If the API returned an error, show it
            if (!$response->successful()) {
                return response()->json([
                    'status' => $response->status(),
                    'url' => $url,
                    'body' => $response->json(),
                    'raw' => $response->body(),
                ], 500);
            }

            return response()->json([
                'reply' => $response['candidates'][0]['content']['parts'][0]['text'] ?? 'No response from Gemini.'
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);

        }
    }
}