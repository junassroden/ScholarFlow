<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ArXivService
{
    public function search(string $query): array
    {
        try {

            $response = Http::timeout(5)->get(
                'https://export.arxiv.org/api/query',
                [
                    'search_query' => 'all:' . $query,
                    'start' => 0,
                    'max_results' => 20,
                ]
            );

            if (!$response->successful()) {
                return [];
            }

            $xml = simplexml_load_string($response->body());

            if (!$xml) {
                return [];
            }

            $papers = [];

            foreach ($xml->entry as $entry) {

                $authors = [];

                foreach ($entry->author as $author) {
                    $authors[] = (string) $author->name;
                }

                $papers[] = [
                    'title'      => trim((string) $entry->title),
                    'authors'    => implode(', ', $authors),
                    'abstract'   => trim((string) $entry->summary),
                    'year'       => date('Y', strtotime((string) $entry->published)),
                    'source'     => 'arXiv',
                    'citations'  => 0,
                    'url'        => (string) $entry->id,
                ];
            }

            return $papers;

        } catch (\Throwable $e) {

            return [];
        }
    }
}