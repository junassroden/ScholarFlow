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


use Illuminate\Support\Facades\Concurrency;


class SearchController extends Controller
{
    protected $core;
    protected $arxiv;
    protected $crossref;
    protected $openAlex;
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
        $query = $request->input('q');

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required.'
            ], 400);
        }

        $arxivResults = $this->arxiv->search($query);
        $openAlexResults = $this->openAlex->search($query);
        $crossrefResults = $this->crossref->search($query);
        $coreResults = $this->core->search($query);
        $europePMCResults = $this->europePMC->search($query);
        $doaj = $this->doaj->search($query);
        $pubMedResults = $this->pubMed->search($query);
        $zenodoResults = $this->zenodo->search($query);
        $openAIREResults = $this->openAIRE->search($query);
        // Merge both results
        $results = array_merge(
                $arxivResults,
                $openAlexResults,
                $crossrefResults,
                $coreResults,
                $europePMCResults,
                $doaj,
                $pubMedResults,
                $zenodoResults,
                $openAIREResults
        );

        return response()->json([
            'success' => true,
            'total' => count($results),
            'results' => $results
        ]);
    }
}