<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAIREService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)->get(
                'https://api.openaire.eu/search/publications',
                [
                    'keywords' => $query,
                    'format' => 'json',
                    'size' => 20,
                ]
            );

            if (!$response->successful()) {
                return [];
            }

            $json = $response->json();

            $papers = [];

            foreach ($json['results'] ?? [] as $paper) {

                $papers[] = [

                    'title' => $paper['title'] ?? 'Untitled',

                    'authors' => isset($paper['authors'])
                        ? implode(', ', $paper['authors'])
                        : 'Unknown',

                    'abstract' => $paper['description'] ?? 'No abstract available.',

                    'year' => $paper['publicationYear'] ?? '',

                    'source' => 'OpenAIRE',

                    'citations' => 0,

                    'url' => $paper['url'] ?? '#',

                ];
            }

            return $papers;

        } catch (\Throwable $e) {

            \Log::error($e->getMessage());

            return [];

        }
    }
}