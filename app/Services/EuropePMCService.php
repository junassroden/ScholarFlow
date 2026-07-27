<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EuropePMCService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)->get(
                'https://www.ebi.ac.uk/europepmc/webservices/rest/search',
                [
                    'query' => $query,
                    'format' => 'json',
                    'pageSize' => 20,
                ]
            );

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();

            $papers = [];

            foreach ($data['resultList']['result'] ?? [] as $paper) {

                $papers[] = [

                    'title' => $paper['title'] ?? 'No Title',

                    'authors' => $paper['authorString'] ?? 'Unknown Authors',

                    'abstract' => $paper['abstractText'] ?? 'No abstract available.',

                    'year' => $paper['pubYear'] ?? '',

                    'source' => 'Europe PMC',

                    'citations' => 0,

                    'url' => isset($paper['pmid'])
                        ? 'https://europepmc.org/article/MED/' . $paper['pmid']
                        : '#',

                ];
            }

            return $papers;

        } catch (\Throwable $e) {

            return [];

        }
    }
}