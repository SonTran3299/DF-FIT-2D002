<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryStoreRequest;
use App\Http\Requests\Admin\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function list(Request $request): View
    {
        $searchQuery = $request->query('query') ?? null;
        $sort  = $request->sort ?? 'latest';

        $arraySort = ['id', 'desc'];
        if ($sort === 'oldest') {
            $arraySort = ['id', 'asc'];
        }

        [$column, $sort] = $arraySort;

        $itemPerPage = config('my-config.item_per_page');

        if (!$searchQuery) {
            $datas = DB::table('product_category')->orderBy($column, $sort)->paginate($itemPerPage);
        } else {
            $datas = DB::table('product_category')->where('name', 'LIKE', "%$searchQuery%")->orderBy($column, $sort)->paginate($itemPerPage);
        }

        return view('admin.pages.product_category.list', ['datas' => $datas]);
    }

    public function create(): View
    {
        return view('admin.pages.product_category.create');
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);

            $fileName = sprintf('%s_%s.%s', $fileName, uniqid(), $extension);

            $image->move(public_path('images/category'), $fileName);
        }

        $check = ProductCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'image' => $fileName
        ]) ? 'Thêm thành công' : 'Thất bại'; //mass asignment

        return redirect()->route('admin.product_category.list')->with('msg', $check);
    }

    public function makeSlug(Request $request)
    {
        $slug = Str::slug($request->slug);
        $result = DB::select('SELECT COUNT(*) as count FROM product_category WHERE slug = ?', [$slug]);

        if ($result[0]->count > 0) {
            $slug .= '-' . uniqid();
        }
        return response()->json(['slug' => $slug]);
    }

    public function destroy(ProductCategory $productCategory)
    {
        $msg = $productCategory->delete() ? 'Xóa thành công' : 'Xóa thất bại';

        return redirect()->route('admin.product_category.list')->with('msg', $msg);
    }

    public function detail(ProductCategory $productCategory): View
    {
        return view('admin.pages.product_category.detail', ['data' => $productCategory]);
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        $productCategory = ProductCategory::findOrFail($productCategory->id);
        $newImage = $productCategory->image;

        if ($request->hasFile('image')) {
            if ($productCategory->image) {
                $oldFilePath = public_path('images/category/' . $productCategory->image);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            $image = $request->file('image');
            $newFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            $newImage = sprintf('%s_%s.%s', $newFileName, uniqid(), $extension);

            $image->move(public_path('images/category'), $newImage);
        }

        $productCategory->name = $request->name;
        $productCategory->slug = $request->slug;
        $productCategory->status = $request->status;
        $productCategory->image = $newImage;
        $check = $productCategory->save() ? 'Cập nhật danh mục thành công' : 'Cập nhật danh mục thất bại';

        return redirect()->route('admin.product_category.list')->with('msg', $check);
    }

    public function restore(string|int $id)
    {
        $productCategory = ProductCategory::withTrashed()->find($id);

        $productCategory->restore();

        return redirect()->route('admin.product_category.list')->with('msg', 'Khôi phục thành công');
    }
}
