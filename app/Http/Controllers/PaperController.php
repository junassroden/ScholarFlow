<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Paper;
use App\Models\Bookmark;

class PaperController extends Controller
{
    public function show($id)
    {
        $cacheKey = 'paper_' . md5($id);
        $paper = Cache::get($cacheKey);

        if ($paper) {
            $isSaved = false;
            if (Auth::check() && !empty($paper['doi'])) {
                $paperModel = Paper::where('doi', $paper['doi'])->first();
                if ($paperModel) {
                    $isSaved = Bookmark::where('user_id', Auth::id())
                        ->where('paper_id', $paperModel->id)
                        ->exists();
                }
            }
            return view('paper.show', compact('paper', 'isSaved'));
        }

        $paper = $this->fetchPaperData($id);

        if (empty($paper['title']) || $paper['title'] === 'Untitled') {
            abort(404, 'Paper not found');
        }

        Cache::put($cacheKey, $paper, 3600);

        $isSaved = false;
        if (Auth::check() && !empty($paper['doi'])) {
            $paperModel = Paper::where('doi', $paper['doi'])->first();
            if ($paperModel) {
                $isSaved = Bookmark::where('user_id', Auth::id())
                    ->where('paper_id', $paperModel->id)
                    ->exists();
            }
        }

        return view('paper.show', compact('paper', 'isSaved'));
    }

    public function showFallback(Request $request)
    {
        $doi = $request->input('doi');
        if (!empty($doi)) {
            try {
                $paper = $this->fetchPaperData($doi);
                if (!empty($paper['title']) && $paper['title'] !== 'Untitled') {
                    $isSaved = false;
                    if (Auth::check() && !empty($paper['doi'])) {
                        $paperModel = Paper::where('doi', $paper['doi'])->first();
                        if ($paperModel) {
                            $isSaved = Bookmark::where('user_id', Auth::id())
                                ->where('paper_id', $paperModel->id)
                                ->exists();
                        }
                    }
                    return view('paper.show', compact('paper', 'isSaved'));
                }
            } catch (\Exception $e) {
                Log::warning("Fallback fetch failed for DOI: $doi - " . $e->getMessage());
            }
        }

        $paper = [
            'title'       => $request->input('title', 'Untitled'),
            'authors'     => $request->input('authors', 'Unknown Authors'),
            'abstract'    => $request->input('abstract', 'No abstract available.'),
            'year'        => $request->input('year'),
            'source'      => $request->input('source', 'Unknown'),
            'citations'   => $request->input('citations', 0),
            'link'        => $request->input('link', '#'),
            'doi'         => $request->input('doi'),
            'open_access' => $request->input('open_access', false),
            'api_source'  => $request->input('api_source', 'ScholarFlow'),
            'pdf_url'     => null,
            'keywords'    => [],
        ];

        $isSaved = false;
        if (Auth::check() && !empty($paper['doi'])) {
            $paperModel = Paper::where('doi', $paper['doi'])->first();
            if ($paperModel) {
                $isSaved = Bookmark::where('user_id', Auth::id())
                    ->where('paper_id', $paperModel->id)
                    ->exists();
            }
        }

        return view('paper.show', compact('paper', 'isSaved'));
    }

    private function fetchPaperData($id)
    {
        // Try OpenAlex
        $data = $this->fetchFromOpenAlex($id);

        if (empty($data['abstract']) || $data['abstract'] === 'No abstract available.') {
            $crossrefData = $this->fetchFromCrossref($id);
            if (!empty($crossrefData['abstract'])) {
                $data['abstract'] = $crossrefData['abstract'];
            }
        }

        if (empty($data['abstract']) || $data['abstract'] === 'No abstract available.') {
            $pmcData = $this->fetchFromEuropePMC($id);
            if (!empty($pmcData['abstract'])) {
                $data['abstract'] = $pmcData['abstract'];
            }
        }

        if (empty($data['title'])) {
            return [
                'title'       => 'Untitled',
                'authors'     => 'Unknown Authors',
                'abstract'    => 'No abstract available.',
                'year'        => null,
                'source'      => 'Unknown',
                'citations'   => 0,
                'link'        => '#',
                'doi'         => $id,
                'open_access' => false,
                'pdf_url'     => null,
                'api_source'  => 'None',
                'keywords'    => [],
            ];
        }

        $oaData = [];
        if (isset($data['doi'])) {
            $oaData = $this->fetchFromUnpaywall($data['doi']);
        }

        return [
            'title'       => $data['title'] ?? 'Untitled',
            'authors'     => is_array($data['authors']) ? implode(', ', $data['authors']) : ($data['authors'] ?? 'Unknown Authors'),
            'abstract'    => $data['abstract'] ?? 'No abstract available.',
            'year'        => $data['year'] ?? null,
            'source'      => $data['source'] ?? 'Unknown',
            'citations'   => $data['citations'] ?? 0,
            'link'        => $data['link'] ?? '#',
            'doi'         => $data['doi'] ?? $id,
            'open_access' => $oaData['is_oa'] ?? $data['open_access'] ?? false,
            'pdf_url'     => $oaData['pdf_url'] ?? null,
            'api_source'  => $data['api_source'] ?? 'Unknown',
            'keywords'    => $data['keywords'] ?? [],
        ];
    }

    private function fetchFromOpenAlex($id)
    {
        try {
            $response = Http::timeout(5)->get("https://api.openalex.org/works/doi/{$id}");
            if (!$response->successful()) {
                $response = Http::timeout(5)->get("https://api.openalex.org/works", [
                    'filter' => "ids:https://doi.org/{$id},https://arxiv.org/abs/{$id},pmid:{$id}",
                ]);
                if (!$response->successful()) return [];
                $results = $response->json()['results'] ?? [];
                if (empty($results)) return [];
                $data = $results[0];
            } else {
                $data = $response->json();
            }

            $abstract = $data['abstract'] ?? null;
            if (!$abstract && isset($data['abstract_inverted_index'])) {
                $abstract = $this->reconstructAbstract($data['abstract_inverted_index']);
            }

            return [
                'title'       => $data['display_name'] ?? null,
                'authors'     => collect($data['authorships'] ?? [])
                    ->map(fn($a) => $a['author']['display_name'])
                    ->filter()
                    ->toArray(),
                'abstract'    => $abstract,
                'year'        => $data['publication_year'] ?? null,
                'source'      => $data['primary_location']['source']['display_name'] ?? null,
                'citations'   => $data['cited_by_count'] ?? 0,
                'link'        => $data['primary_location']['landing_page_url'] ?? null,
                'doi'         => $data['doi'] ?? null,
                'open_access' => $data['open_access']['is_oa'] ?? false,
                'api_source'  => 'OpenAlex',
                'keywords'    => collect($data['keywords'] ?? [])->pluck('display_name')->toArray(),
            ];
        } catch (\Exception $e) {
            Log::error("OpenAlex error: " . $e->getMessage());
            return [];
        }
    }

    private function reconstructAbstract($invertedIndex)
    {
        if (empty($invertedIndex)) return null;
        $maxPos = 0;
        foreach ($invertedIndex as $positions) {
            foreach ($positions as $pos) {
                if ($pos > $maxPos) $maxPos = $pos;
            }
        }
        $words = array_fill(0, $maxPos + 1, '');
        foreach ($invertedIndex as $word => $positions) {
            foreach ($positions as $pos) {
                $words[$pos] = $word;
            }
        }
        return implode(' ', $words);
    }

    private function fetchFromCrossref($id)
    {
        try {
            $response = Http::timeout(5)
                ->withHeaders(['User-Agent' => 'ScholarFlow (your@email.com)'])
                ->get("https://api.crossref.org/works/{$id}");
            if (!$response->successful()) return [];

            $data = $response->json()['message'] ?? [];
            $authors = collect($data['author'] ?? [])
                ->map(fn($a) => trim(($a['given'] ?? '') . ' ' . ($a['family'] ?? '')))
                ->filter()
                ->toArray();

            return [
                'title'       => $data['title'][0] ?? null,
                'authors'     => $authors,
                'abstract'    => null,
                'year'        => $data['published-print']['date-parts'][0][0] ?? $data['published-online']['date-parts'][0][0] ?? null,
                'source'      => $data['container-title'][0] ?? null,
                'citations'   => $data['is-referenced-by-count'] ?? 0,
                'link'        => $data['URL'] ?? null,
                'doi'         => $data['DOI'] ?? $id,
                'open_access' => false,
                'api_source'  => 'Crossref',
                'keywords'    => [],
            ];
        } catch (\Exception $e) {
            Log::error("Crossref error: " . $e->getMessage());
            return [];
        }
    }

    private function fetchFromEuropePMC($id)
    {
        try {
            $query = $id;
            if (str_starts_with($id, '10.')) {
                $query = "DOI:" . $id;
            }
            $response = Http::timeout(5)->get("https://www.ebi.ac.uk/europepmc/webservices/rest/search", [
                'query' => $query,
                'format' => 'json',
                'pageSize' => 1,
            ]);
            if (!$response->successful()) return [];

            $data = $response->json();
            $result = $data['resultList']['result'][0] ?? [];
            if (empty($result)) return [];

            return [
                'abstract' => $result['abstractText'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error("EuropePMC error: " . $e->getMessage());
            return [];
        }
    }

    private function fetchFromUnpaywall($doi)
    {
        try {
            $response = Http::timeout(5)->get("https://api.unpaywall.org/v2/{$doi}", [
                'email' => 'your@email.com'
            ]);
            if (!$response->successful()) return [];

            $data = $response->json();
            return [
                'pdf_url'     => $data['best_oa_location']['pdf_url'] ?? null,
                'is_oa'       => $data['is_oa'] ?? false,
            ];
        } catch (\Exception $e) {
            Log::error("Unpaywall error: " . $e->getMessage());
            return [];
        }
    }
}