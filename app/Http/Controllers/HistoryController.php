<?php

namespace App\Http\Controllers;

use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $history = SearchHistory::where('user_id', Auth::id())
            ->orderBy('searched_at', 'desc') // <-- using your column name
            ->get();

        return view('history', compact('history'));
    }

    public function destroyAll()
    {
        SearchHistory::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Search history cleared.',
        ]);
    }
}