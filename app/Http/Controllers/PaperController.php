<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function show(Request $request)
    {
        return view('paper.show', [
            'paper' => $request->only([
                'title',
                'authors',
                'abstract',
                'year',
                'source',
                'citations',
                'link',
            ]),
        ]);
    }
}