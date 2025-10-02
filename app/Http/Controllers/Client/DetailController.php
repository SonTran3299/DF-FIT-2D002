<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CommentRequest;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function detail(Product $product)
    {
        $productImages = Product::where('id', $product->id)->with('images')->first();
        $products = Product::inRandomOrder()->limit(4)->get();
        $comments = Comment::where('product_id', $product->id)->with('user')->get();
        $userHasCommented = Comment::where('user_id', Auth::id())->where('product_id', $product->id)->exists();

        $averageRating = Comment::where('product_id', $product->id)->avg('stars') ?? 0;
        return view(
            'client.pages.detail',
            [
                'data' => $product,
                'productImages' => $productImages->images,
                'products' => $products,
                'comments' => $comments,
                'userHasCommented' => $userHasCommented,
                'averageRating' => $averageRating
            ]
        );
    }

    public function comment(Product $product, CommentRequest $request)
    {
        Comment::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'stars' => $request->rating,
                'comment' => $request->comment,
            ]
        );
        return redirect()->back();
    }
}
