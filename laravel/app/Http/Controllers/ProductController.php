<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {

        return view('product.index');

    }

    public function list() {

        return \App\Product::with('reviews.user')->get();

    }

    public function review(Request $request) {

        $result = false;

        // バリデーション
        $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
                function($attribute, $value, $fail) use($request) {

                    // ログインしてるかチェック
                    if(!auth()->check()) {

                        $fail('レビューするにはログインしてください。');
                        return;

                    }

                    // すでにレビュー投稿してるかチェック
                    $exists = \App\ProductReview::where('user_id', $request->user()->id)
                        ->where('product_id', $request->product_id)
                        ->exists();

                    if($exists) {

                        $fail('すでにレビューは投稿済みです。');
                        return;

                    }

                }
            ],
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        $review = new \App\ProductReview();
        $review->product_id = $request->product_id;
        $review->user_id = $request->user()->id;
        $review->stars = $request->stars;
        $review->comment = $request->comment;
        $result = $review->save();
        return ['result' => $result];

    }
}
