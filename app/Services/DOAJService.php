<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DOAJService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)->get(
                'https://doaj.org/api/search/articles/' . urlencode($query)
            );

            if (!$response->successful()) {
                return [];
            }

            $json = $response->json();

            $papers = [];

            foreach ($json['results'] ?? [] as $paper) {

                $bib = $paper['bibjson'] ?? [];

                $authors = [];

                foreach ($bib['author'] ?? [] as $author) {
                    $authors[] = $author['name'] ?? '';
                }

                $papers[] = [

                    'title' => $bib['title'] ?? 'Untitled',

                    'authors' => implode(', ', $authors),

                    'abstract' => $bib['abstract'] ?? 'No abstract available.',

                    'year' => $bib['year'] ?? '',

                    'source' => 'DOAJ',

                    'citations' => 0,

                    'url' => $bib['link'][0]['url'] ?? '#',

                ];
            }

            return $papers;

        } catch (\Throwable $e) {

            return [];

        }
    }
}