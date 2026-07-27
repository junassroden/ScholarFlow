<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAlexService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)->get(
                'https://api.openalex.org/works',
                [
                    'search' => $query,
                    'per-page' => 20,
                ]
            );

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();

            $papers = [];

            foreach ($data['results'] ?? [] as $paper) {

                $authors = [];

                foreach ($paper['authorships'] ?? [] as $author) {

                    if (isset($author['author']['display_name'])) {
                        $authors[] = $author['author']['display_name'];
                    }

                }

                $papers[] = [

                    'title' => $paper['display_name'] ?? 'No Title',

                    'authors' => implode(', ', $authors),

                    'abstract' => 'Abstract not provided by OpenAlex.',

                    'year' => $paper['publication_year'] ?? '',

                    'source' => 'OpenAlex',

                    'citations' => $paper['cited_by_count'] ?? 0,

                    'url' => $paper['primary_location']['landing_page_url']
                        ?? $paper['primary_location']['source']['homepage_url']
                        ?? '#',

                ];
            }

            return $papers;

        } catch (\Exception $e) {

            return [];

        }
    }
}