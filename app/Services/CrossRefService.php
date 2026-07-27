<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CrossrefService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)->withHeaders([
                'User-Agent' => 'ScholarFlow (your@email.com)'
            ])->get(
                'https://api.crossref.org/works',
                [
                    'query' => $query,
                    'rows' => 20
                ]
            );

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();

            $papers = [];

            foreach ($data['message']['items'] ?? [] as $paper) {

                $authors = [];

                foreach ($paper['author'] ?? [] as $author) {

                    $authors[] =
                        ($author['given'] ?? '') . ' ' .
                        ($author['family'] ?? '');

                }

                $papers[] = [

                    'title' => $paper['title'][0] ?? 'No Title',

                    'authors' => implode(', ', $authors),

                    'abstract' => 'Abstract not available.',

                    'year' => $paper['published-print']['date-parts'][0][0]
                        ?? $paper['published-online']['date-parts'][0][0]
                        ?? '',

                    'source' => $paper['container-title'][0] ?? 'Crossref',

                    'citations' => $paper['is-referenced-by-count'] ?? 0,

                    'url' => $paper['URL'] ?? '#'

                ];
            }

            return $papers;

        } catch (\Exception $e) {

            return [];

        }
    }
}