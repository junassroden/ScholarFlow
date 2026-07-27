<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZenodoService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)->get(
                'https://zenodo.org/api/records',
                [
                    'q' => $query,
                    'size' => 20,
                ]
            );

            if (!$response->successful()) {
                return [];
            }

            $json = $response->json();

            $papers = [];

            foreach ($json['hits']['hits'] ?? [] as $paper) {

                $metadata = $paper['metadata'] ?? [];

                $authors = [];

                foreach ($metadata['creators'] ?? [] as $creator) {
                    $authors[] = $creator['name'] ?? '';
                }

                $papers[] = [

                    'title' => $metadata['title'] ?? 'Untitled',

                    'authors' => implode(', ', $authors),

                    'abstract' => $metadata['description'] ?? 'No abstract available.',

                    'year' => substr($metadata['publication_date'] ?? '', 0, 4),

                    'source' => 'Zenodo',

                    'citations' => 0,

                    'url' => $paper['links']['html'] ?? '#',

                ];
            }

            return $papers;

        } catch (\Throwable $e) {

            return [];

        }
    }
}