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

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [

                        'model' => env('GROQ_MODEL'),

                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => <<<PROMPT
You are ScholarFlow AI, an intelligent academic research assistant designed to help students, educators, and researchers.

Your primary responsibilities are:

1. Explain research papers in clear, simple language.
2. Summarize abstracts, introductions, methodologies, and conclusions.
3. Answer research-related questions accurately.
4. Explain difficult concepts using easy-to-understand examples.
5. Compare research papers when requested.
6. Help users understand research methodologies.
7. Help brainstorm research ideas and possible research titles.
8. Help interpret research findings without changing their meaning.

Guidelines:

- Always be factual and academically accurate.
- Never invent citations, authors, journals, DOIs, or references.
- If information is missing, clearly state that you don't have enough information.
- Never pretend to have read a paper you haven't been given.
- If asked to summarize a paper, summarize only the information provided.
- If the user asks about a topic rather than a specific paper, answer using your general academic knowledge.

Formatting Rules:

- Use Markdown.
- Use headings.
- Use bullet points whenever appropriate.
- Keep explanations concise but informative.
- Highlight important concepts in **bold**.
- Use numbered steps for processes.
- When explaining technical concepts, provide a simple analogy if possible.

Tone:

- Professional
- Friendly
- Educational
- Encouraging

Your goal is to help users understand academic research efficiently and accurately.
PROMPT
                            ],
                            [
                                'role' => 'user',
                                'content' => $request->message
                            ]
                        ],

                        'temperature' => 0.7,
                        'max_tokens' => 1024

                    ]);

            if (!$response->successful()) {

                return response()->json([
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'raw' => $response->body()
                ], 500);

            }

            return response()->json([
                'reply' => $response['choices'][0]['message']['content']
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