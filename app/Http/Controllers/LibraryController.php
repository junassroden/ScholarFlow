<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LibraryController extends Controller
{
    /**
     * Display the user's library.
     */
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

    /**
     * Save a paper (bookmark) – POST /library/save
     */
    public function save(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'      => 'required|string|max:255',
                'authors'    => 'nullable|string',
                'citations'  => 'nullable',
                'abstract'   => 'nullable|string',
                'year'       => 'nullable|integer',
                'doi'        => 'nullable|string',
                'link'       => 'nullable|url',
                'api_source' => 'nullable|string',
                'source'     => 'nullable|string',
            ]);

            // Clean citations
            $citationCount = 0;
            if (!empty($validated['citations'])) {
                $cleaned = preg_replace('/[^0-9]/', '', (string) $validated['citations']);
                $citationCount = (int) $cleaned;
            }

            // Extract year from authors if not provided
            $year = $validated['year'] ?? null;
            if (!$year && !empty($validated['authors'])) {
                if (preg_match('/\b(\d{4})\b/', $validated['authors'], $matches)) {
                    $year = (int) $matches[1];
                }
            }

            // Find or create paper
            $paper = Paper::firstOrCreate(
                ['title' => $validated['title']],
                [
                    'abstract'         => $validated['abstract'] ?? null,
                    'publication_year' => $year,
                    'citation_count'   => $citationCount,
                    'doi'              => $validated['doi'] ?? null,
                    'pdf_url'          => $validated['link'] ?? null,
                    'journal'          => $validated['source'] ?? null,
                    'api_source'       => $validated['api_source'] ?? null,
                ]
            );

            // Update existing paper with new data if necessary
            if (!$paper->wasRecentlyCreated) {
                $paper->update(array_filter([
                    'abstract'         => $validated['abstract'] ?? $paper->abstract,
                    'publication_year' => $year ?? $paper->publication_year,
                    'citation_count'   => $citationCount ?? $paper->citation_count,
                    'doi'              => $validated['doi'] ?? $paper->doi,
                    'pdf_url'          => $validated['link'] ?? $paper->pdf_url,
                    'journal'          => $validated['source'] ?? $paper->journal,
                    'api_source'       => $validated['api_source'] ?? $paper->api_source,
                ]));
            }

            // Check if already bookmarked by this user
            $existingBookmark = Bookmark::where('user_id', Auth::id())
                                        ->where('paper_id', $paper->id)
                                        ->first();

            if ($existingBookmark) {
                return response()->json([
                    'success' => false,
                    'message' => 'This paper is already in your library.',
                    'already_saved' => true,
                ], 409);
            }

            // Create bookmark
            $bookmark = Bookmark::create([
                'user_id'  => Auth::id(),
                'paper_id' => $paper->id,
            ]);

            return response()->json([
                'success'  => true,
                'message'  => 'Paper saved to your library!',
                'paper'    => $paper,
                'bookmark' => $bookmark,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove a paper from the library (delete bookmark) – DELETE /library/{paper}
     */
    public function destroy(Paper $paper)
    {
        $bookmark = Bookmark::where('user_id', Auth::id())
                            ->where('paper_id', $paper->id)
                            ->first();

        if (!$bookmark) {
            return response()->json([
                'success' => false,
                'message' => 'Paper not found in your library.',
            ], 404);
        }

        $bookmark->delete();

        return response()->json([
            'success' => true,
            'message' => 'Paper removed from your library.',
        ]);
    }
}