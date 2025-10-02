<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $newProduct = Product::orderBy('id',  'desc')->where('status', '!=', 0)->take(8)->get();
        $outstandingProducts = Product::orderBy('discount_percentage',  'desc')->where('status', '!=', 0)->take(8)->get();
        return view('client.pages.home', [
            'newProduct' => $newProduct,
            'outstandingProducts' => $outstandingProducts,
            'categoryDemo' => $this->loadCategoryHome(),
            'productCounts' => $this->loadProductInCategory()
        ]);
    }
    public function loadCategoryHome()
    {
        return ProductCategory::orderBy('id',  'desc')->where('status', '1')->take(6)->get();
    }

    public function loadProductInCategory()
    {
        $counts = DB::table('product')
            ->select('product_category_id', DB::raw('COUNT(*) as soluong'))
            ->groupBy('product_category_id')
            ->get();

        $productCounts = [];
        foreach ($counts as $count) {
            $productCounts[$count->product_category_id] = $count->soluong;
        }
        return $productCounts;
    }
}
