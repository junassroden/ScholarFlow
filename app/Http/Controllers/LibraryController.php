<?php

namespace App\Http\Controllers;

use App\Models\SavedPaper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    public function save(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'authors' => 'nullable|string',
            'abstract' => 'nullable|string',
            'year' => 'nullable',
            'source' => 'nullable|string',
            'citations' => 'nullable',
            'link' => 'nullable|string',
            'doi' => 'nullable|string',
            'open_access' => 'nullable',
            'api_source' => 'nullable|string',
        ]);

        SavedPaper::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'authors' => $validated['authors'] ?? null,
            'abstract' => $validated['abstract'] ?? null,
            'year' => $validated['year'] ?? null,
            'source' => $validated['source'] ?? null,
            'citations' => $validated['citations'] ?? 0,
            'link' => $validated['link'] ?? null,
            'doi' => $validated['doi'] ?? null,
            'open_access' => $validated['open_access'] ?? null,
            'api_source' => $validated['api_source'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paper saved successfully.'
        ]);
    }
}