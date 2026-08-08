<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArXivService;
use App\Services\OpenAlexService;
use App\Services\CrossrefService;
use App\Services\CoreService;
use App\Services\EuropePMCService;
use App\Services\DOAJService;
use App\Services\PubMedService;
use App\Services\ZenodoService;
use App\Services\OpenAIREService;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    private const PER_PAGE = 20;
    private const CACHE_TTL = 300; // 5 minutes

    protected $arxiv;
    protected $openAlex;
    protected $crossref;
    protected $core;
    protected $europePMC;
    protected $doaj;
    protected $pubMed;
    protected $zenodo;
    protected $openAIRE;

    public function __construct(
        ArXivService $arxiv,
        OpenAlexService $openAlex,
        CrossrefService $crossref,
        CoreService $core,
        EuropePMCService $europePMC,
        DOAJService $doaj,
        PubMedService $pubMed,
        ZenodoService $zenodo,
        OpenAIREService $openAIRE
    ) {
        $this->arxiv = $arxiv;
        $this->openAlex = $openAlex;
        $this->crossref = $crossref;
        $this->core = $core;
        $this->europePMC = $europePMC;
        $this->doaj = $doaj;
        $this->pubMed = $pubMed;
        $this->zenodo = $zenodo;
        $this->openAIRE = $openAIRE;
    }

    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required.'
            ], 400);
        }

        $yearFilter   = $request->input('year');
        $oaFilter     = $request->input('open_access');
        $sourceFilter = $request->input('source');
        $sortOption   = $request->input('sort', 'relevant');
        $page         = max((int) $request->input('page', 1), 1);

        // Build a unique cache key
        $cacheKey = 'search_' . md5(serialize([
            $query, $yearFilter, $oaFilter, $sourceFilter, $sortOption, $page
        ]));

        // Try to get cached result
        try {
            $cached = Cache::get($cacheKey);
            if ($cached !== null) {
                // Save history only on first page (even if cached)
                if ($page === 1 && Auth::check()) {
                    SearchHistory::create([
                        'user_id'     => Auth::id(),
                        'keyword'     => $query,
                        'searched_at' => now(),
                    ]);
                }
                return response()->json($cached);
            }
        } catch (\Exception $e) {
            Log::warning('Cache read failed: ' . $e->getMessage());
        }

        // Call each service sequentially
        $allResults = [];
        $services = [
            'arXiv'     => $this->arxiv,
            'OpenAlex'  => $this->openAlex,
            'Crossref'  => $this->crossref,
            'CORE'      => $this->core,
            'EuropePMC' => $this->europePMC,
            'DOAJ'      => $this->doaj,
            'PubMed'    => $this->pubMed,
            'Zenodo'    => $this->zenodo,
            'OpenAIRE'  => $this->openAIRE,
        ];

        foreach ($services as $name => $service) {
            try {
                $papers = $service->search($query);
                if (is_array($papers)) {
                    $allResults = array_merge($allResults, $papers);
                }
            } catch (\Exception $e) {
                Log::error("Error from {$name}: " . $e->getMessage());
                // Continue with other services
            }
        }

        // Remove duplicates
        $results = $this->removeDuplicates($allResults);

        // Apply filters
        if ($yearFilter || $oaFilter || $sourceFilter) {
            $results = array_filter($results, function ($paper) use ($yearFilter, $oaFilter, $sourceFilter) {
                if (!empty($yearFilter) && (string)($paper['year'] ?? '') !== (string)$yearFilter) {
                    return false;
                }
                if ($oaFilter === 'open') {
                    $isOpen = !empty($paper['is_oa']) || !empty($paper['open_access']);
                    if (!$isOpen) {
                        return false;
                    }
                }
                if (!empty($sourceFilter) && strcasecmp($paper['source'] ?? '', $sourceFilter) !== 0) {
                    return false;
                }
                return true;
            });
            $results = array_values($results);
        }

        // Sort
        $results = $this->sortResults($results, $sortOption);

        // Paginate
        $total = count($results);
        $paginatedResults = array_slice(
            $results,
            ($page - 1) * self::PER_PAGE,
            self::PER_PAGE
        );

        $responseData = [
            'success'  => true,
            'page'     => $page,
            'per_page' => self::PER_PAGE,
            'total'    => $total,
            'results'  => $paginatedResults
        ];

        // Store in cache
        try {
            Cache::put($cacheKey, $responseData, self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::warning('Cache write failed: ' . $e->getMessage());
        }

        // Save search history (first page only)
        if ($page === 1 && Auth::check()) {
            SearchHistory::create([
                'user_id'     => Auth::id(),
                'keyword'     => $query,
                'searched_at' => now(),
            ]);
        }

        return response()->json($responseData);
    }

    // ---- Helper methods ----

    private function removeDuplicates(array $papers): array
    {
        $unique = [];
        foreach ($papers as $paper) {
            if (!empty($paper['doi'])) {
                $key = strtolower(trim($paper['doi']));
            } else {
                $title = strtolower(trim($paper['title'] ?? ''));
                $title = preg_replace('/\s+/', ' ', $title);
                $key = preg_replace('/[^a-z0-9]/', '', $title);
                if ($key === '') {
                    $key = md5(json_encode($paper));
                }
            }
            if (!isset($unique[$key])) {
                $unique[$key] = $paper;
            } else {
                if ($this->paperScore($paper) > $this->paperScore($unique[$key])) {
                    $unique[$key] = $paper;
                }
            }
        }
        return array_values($unique);
    }

    private function paperScore(array $paper): int
    {
        $score = 0;
        $score += $paper['citations'] ?? 0;
        if (!empty($paper['doi'])) {
            $score += 100;
        }
        if (!empty($paper['abstract']) && $paper['abstract'] !== 'No abstract available.') {
            $score += 20;
        }
        if (!empty($paper['authors'])) {
            $score += 10;
        }
        if (!empty($paper['url'])) {
            $score += 5;
        }
        return $score;
    }

    private function sortResults(array $papers, string $sort = 'relevant'): array
    {
        usort($papers, function ($a, $b) use ($sort) {
            if ($sort === 'newest') {
                return ((int)($b['year'] ?? 0)) <=> ((int)($a['year'] ?? 0));
            }
            if ($sort === 'oldest') {
                return ((int)($a['year'] ?? 0)) <=> ((int)($b['year'] ?? 0));
            }
            if ($sort === 'citations') {
                return ((int)($b['citations'] ?? 0)) <=> ((int)($a['citations'] ?? 0));
            }
            // Default: Most Relevant
            $citationA = $a['citations'] ?? 0;
            $citationB = $b['citations'] ?? 0;
            if ($citationA !== $citationB) {
                return $citationB <=> $citationA;
            }
            $yearA = (int)($a['year'] ?? 0);
            $yearB = (int)($b['year'] ?? 0);
            return $yearB <=> $yearA;
        });
        return $papers;
    }
}