<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CoreService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)
                ->acceptJson()
                ->get('https://api.core.ac.uk/v3/search/works', [
                    'q' => $query,
                    'limit' => 20,
                ]);

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();

            $papers = [];

            foreach ($data['results'] ?? [] as $paper) {

                $authors = [];

                foreach ($paper['authors'] ?? [] as $author) {

                    if (is_array($author)) {
                        $authors[] = $author['name'] ?? '';
                    } else {
                        $authors[] = $author;
                    }

                }

                $papers[] = [

                    'title' => $paper['title'] ?? 'No Title',

                    'authors' => implode(', ', $authors),

                    'abstract' => $paper['abstract'] ?? 'No abstract available.',

                    'year' => $paper['yearPublished'] ?? '',

                    'source' => 'CORE',

                    'citations' => 0,

                    'url' =>
                        $paper['downloadUrl']
                        ?? $paper['sourceFulltextUrls'][0]
                        ?? '#',

                ];
            }

            return $papers;

        } catch (\Throwable $e) {

            return [];

        }
    }
}