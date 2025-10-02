<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function shop(Request $request)
    {
        $categoryFilter = $request->query('category') ?? null;
        $searchQuery = $request->query('query') ?? null;

        $sort  = $request->sort ?? 'latest';
        $arraySort = ['id', 'desc'];

        $maxPrice = $request->query('max_price') ?? Product::max('price');
        $minPrice = $request->query('min_price') ?? 0;

        if ($sort === 'oldest') {
            $arraySort = ['id', 'asc'];
        } else if ($sort === 'highest') {
            $arraySort = ['price', 'desc'];
        } else if ($sort === 'lowest') {
            $arraySort = ['price', 'asc'];
        }

        [$column, $sort] = $arraySort;

        $itemPerPage = config('my-config.client_product_per_page');

        $query = Product::orderBy($column, $sort)->whereBetween('price', [$minPrice, $maxPrice]);
        if ($categoryFilter) {
            $category = ProductCategory::where('slug', $categoryFilter)->first();
            $query->where('product_category_id', $category->id);
        }
        if ($searchQuery) {
            $query->where('name', 'LIKE', "%$searchQuery%");
        }
        $dataProduct = $query->where('status', 1)->paginate($itemPerPage);

        return view('client.pages.shop', ['dataProduct' => $dataProduct]);
    }

    public function contact()
    {
        return view('client.pages.contact');
    }

    public function orderHistory()
    {
        $userId = Auth::user()->id;
        $dataOrder = Order::where('user_id', $userId)->with('orderItems', 'orderPaymentMethods')->orderBy('updated_at', 'desc')->get();
        return view('client.pages.order_history', ['dataOrder' => $dataOrder]);
    }
}
