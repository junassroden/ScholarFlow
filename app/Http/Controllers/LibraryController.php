<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LibraryController extends Controller
{
    public function index()
    {
        $savedPapers = Bookmark::with('paper')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->pluck('paper')
            ->filter();

        return view('library', compact('savedPapers'));
    }

    public function save(Request $request)
    {
        try {
            $data = $request->all();

            // Validate required fields
            if (empty($data['title'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paper title is required.'
                ], 422);
            }

            // Find or create paper using DOI if available, else title
            $paper = null;
            if (!empty($data['doi'])) {
                $paper = Paper::where('doi', $data['doi'])->first();
            }

            if (!$paper) {
                // Try by title if DOI not found or not provided
                $paper = Paper::where('title', $data['title'])->first();
            }

            if (!$paper) {
                $paper = new Paper();
            }

            // Fill paper data
            $paper->title = $data['title'];
            $paper->abstract = $data['abstract'] ?? null;
            $paper->publication_year = $data['year'] ?? null;
            $paper->citation_count = isset($data['citations']) ? (int) preg_replace('/[^0-9]/', '', (string) $data['citations']) : 0;
            $paper->pdf_url = $data['link'] ?? null;
            $paper->journal = $data['source'] ?? null;
            $paper->api_source = $data['api_source'] ?? null;

            // If DOI is provided, set it (if not already set)
            if (!empty($data['doi']) && empty($paper->doi)) {
                $paper->doi = $data['doi'];
            }

            $paper->save();

            // Check if already bookmarked by this user
            $existing = Bookmark::where('user_id', Auth::id())
                ->where('paper_id', $paper->id)
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'message' => 'This paper is already in your library.',
                    'already_saved' => true,
                ], 409);
            }

            // Create bookmark
            Bookmark::create([
                'user_id' => Auth::id(),
                'paper_id' => $paper->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Paper saved to your library!',
                'paper' => $paper,
                'doi' => $paper->doi,
            ], 201);
        } catch (\Exception $e) {
            // Return detailed error for debugging
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }

    public function destroy($identifier)
    {
        try {
            // Try to find paper by DOI first, then by ID
            $paper = Paper::where('doi', $identifier)->first();

            if (!$paper && is_numeric($identifier)) {
                $paper = Paper::find($identifier);
            }

            if (!$paper) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paper not found.'
                ], 404);
            }

            $bookmark = Bookmark::where('user_id', Auth::id())
                ->where('paper_id', $paper->id)
                ->first();

            if (!$bookmark) {
                return response()->json([
                    'success' => false,
                    'message' => 'Paper not found in your library.'
                ], 404);
            }

            $bookmark->delete();

            return response()->json([
                'success' => true,
                'message' => 'Paper removed from your library.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}