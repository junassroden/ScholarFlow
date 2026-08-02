<?php

namespace App\Http\Controllers;

use App\Models\SavedPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedPaperController extends Controller
{
    public function store(Request $request)
    {
        SavedPaper::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'doi' => $request->doi,
                'title' => $request->title,
            ],
            [
                'authors' => $request->authors,
                'abstract' => $request->abstract,
                'year' => $request->year,
                'source' => $request->source,
                'citations' => $request->citations,
                'link' => $request->link,
                'open_access' => $request->open_access,
                'api_source' => $request->api_source,
            ]
        );

        return response()->json([
            'success' => true
        ]);
    }
}