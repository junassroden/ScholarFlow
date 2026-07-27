<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PubMedService
{
    public function search(string $query): array
    {
        try {

            // Search PubMed IDs
            $search = Http::timeout(5)->get(
                'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi',
                [
                    'db' => 'pubmed',
                    'term' => $query,
                    'retmode' => 'json',
                    'retmax' => 20,
                ]
            );

            if (!$search->successful()) {
                return [];
            }

            $ids = $search->json()['esearchresult']['idlist'] ?? [];

            if (empty($ids)) {
                return [];
            }

            // Fetch paper details
            $summary = Http::timeout(5)->get(
                'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi',
                [
                    'db' => 'pubmed',
                    'id' => implode(',', $ids),
                    'retmode' => 'json',
                ]
            );

            if (!$summary->successful()) {
                return [];
            }

            $json = $summary->json();

            $papers = [];

            foreach ($ids as $id) {

                if (!isset($json['result'][$id])) {
                    continue;
                }

                $paper = $json['result'][$id];

                $authors = [];

                foreach ($paper['authors'] ?? [] as $author) {
                    $authors[] = $author['name'];
                }

                $papers[] = [

                    'title' => $paper['title'] ?? 'Untitled',

                    'authors' => implode(', ', $authors),

                    'abstract' => 'View the paper on PubMed for the abstract.',

                    'year' => substr($paper['pubdate'] ?? '', 0, 4),

                    'source' => 'PubMed',

                    'citations' => 0,

                    'url' => "https://pubmed.ncbi.nlm.nih.gov/{$id}/",

                ];
            }

            return $papers;

        } catch (\Throwable $e) {

            return [];

        }
    }
}