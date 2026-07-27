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

class SearchController extends Controller
{
    private const PER_PAGE = 20;

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

        // Get Filter & Sort parameters
        $yearFilter  = $request->input('year');
        $oaFilter    = $request->input('open_access');
        $sourceFilter = $request->input('source');
        $sortOption   = $request->input('sort', 'relevant');

        // Search every API
        $arxivResults     = $this->arxiv->search($query);
        $openAlexResults  = $this->openAlex->search($query);
        $crossrefResults  = $this->crossref->search($query);
        $coreResults      = $this->core->search($query);
        $europePMCResults = $this->europePMC->search($query);
        $doajResults      = $this->doaj->search($query);
        $pubMedResults    = $this->pubMed->search($query);
        $zenodoResults    = $this->zenodo->search($query);
        $openAIREResults  = $this->openAIRE->search($query);

        // Merge all APIs
        $results = array_merge(
            $arxivResults,
            $openAlexResults,
            $crossrefResults,
            $coreResults,
            $europePMCResults,
            $doajResults,
            $pubMedResults,
            $zenodoResults,
            $openAIREResults
        );

        // Remove duplicates
        $results = $this->removeDuplicates($results);

        // Filter results
        if ($yearFilter || $oaFilter || $sourceFilter) {
            $results = array_filter($results, function ($paper) use ($yearFilter, $oaFilter, $sourceFilter) {
                // Filter by Year
                if (!empty($yearFilter) && (string)($paper['year'] ?? '') !== (string)$yearFilter) {
                    return false;
                }

                // Filter by Open Access
                if ($oaFilter === 'open') {
                    $isOpen = !empty($paper['is_oa']) || !empty($paper['open_access']);
                    if (!$isOpen) {
                        return false;
                    }
                }

                // Filter by API Source
                if (!empty($sourceFilter) && strcasecmp($paper['source'] ?? '', $sourceFilter) !== 0) {
                    return false;
                }

                return true;
            });

            $results = array_values($results);
        }

        // Sort papers
        $results = $this->sortResults($results, $sortOption);

        // Pagination
        $page = max((int) $request->input('page', 1), 1);
        $total = count($results);

        $results = array_slice(
            $results,
            ($page - 1) * self::PER_PAGE,
            self::PER_PAGE
        );

        return response()->json([
            'success'  => true,
            'page'     => $page,
            'per_page' => self::PER_PAGE,
            'total'    => $total,
            'results'  => $results
        ]);
    }

    /**
     * Remove duplicate papers.
     */
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

    /**
     * Score a paper.
     */
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

    /**
     * Sort papers according to criteria.
     */
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

            // Default: Most Relevant (Citations desc, then Year desc)
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