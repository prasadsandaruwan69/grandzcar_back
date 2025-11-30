<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReviewsController extends Controller
{
    /** GET /api/reviews?category=…&search=…&featured=1 */
    public function index(Request $request)
    {
        $query = reviews::query();

        // ----- filter by category -----
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // ----- search -----
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('text', 'like', "%{$term}%");
            });
        }

        // ----- featured (verified) -----
        if ($request->boolean('featured')) {
            $query->where('verified', true);
        }

        $reviews = $query->latest()->paginate(12);

        return response()->json([
            'data'         => $reviews->items(),
            'current_page' => $reviews->currentPage(),
            'last_page'    => $reviews->lastPage(),
            'total'        => $reviews->total(),
        ]);
    }

    /** POST /api/reviews  (multipart/form-data) */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'title'    => 'required|string|max:255',
            'rating'   => 'required|integer|min:1|max:5',
            'text'     => 'required|string|max:2000',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => ['required', Rule::in(['business','corporate','fleet','family'])],
            'date'     => 'nullable|date',
            'verified' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // ---- image upload ----
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('reviews', 'public'); // storage/app/public/reviews/…
        }

        $review = reviews::create($data);

        return response()->json([
            'message' => 'Review created!',
            'data'    => $review,
        ], 201);
    }

    /** GET /api/reviews/{review} */
    public function show(reviews $review)
    {
        return response()->json($review);
    }

    /** PUT /api/reviews/{review} */
    public function update(Request $request, reviews $review)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'sometimes|string|max:255',
            'title'    => 'sometimes|string|max:255',
            'rating'   => 'sometimes|integer|min:1|max:5',
            'text'     => 'sometimes|string|max:2000',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category' => ['sometimes', Rule::in(['business','corporate','fleet','family'])],
            'verified' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // ---- replace image ----
        if ($request->hasFile('image')) {
            if ($review->image) {
                Storage::disk('public')->delete($review->image);
            }
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        $review->update($data);

        return response()->json([
            'message' => 'Review updated!',
            'data'    => $review->fresh(),
        ]);
    }

    /** DELETE /api/reviews/{review} */
    public function destroy(reviews $review)
    {
        if ($review->image) {
            Storage::disk('public')->delete($review->image);
        }
        $review->delete();

        return response()->json(['message' => 'Review deleted!']);
    }
}
