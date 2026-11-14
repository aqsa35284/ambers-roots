<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Submit customer review.
     * Saved with status 'pending' awaiting admin moderation.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'min:10', 'max:1500'],
            'product_id' => ['nullable', 'integer', 'exists:products,id'],
        ]);

        $productId = $validated['product_id'] ?? null;
        if (!$productId) {
            $defaultProduct = Product::active()->first() ?? Product::first();
            $productId = $defaultProduct?->id;
        }

        $review = Review::create([
            'product_id' => $productId,
            'customer_name' => trim($validated['customer_name']),
            'customer_phone' => $validated['customer_phone'] ? trim($validated['customer_phone']) : null,
            'rating' => (int)$validated['rating'],
            'review_text' => trim($validated['review_text']),
            'status' => 'pending',
        ]);

        $message = "We hope you're loving your purchase! Your feedback makes our journey even more special.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'title' => 'Thank You for Choosing Us!',
                'message' => $message,
                'review_id' => $review->id,
            ]);
        }

        return back()->with('review_success', $message);
    }
}
