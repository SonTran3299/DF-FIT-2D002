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
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryController extends Controller
{
    public function list(Request $request): View
    {
        $searchQuery = $request->query('query') ?? null;
        $sort  = $request->sort ?? 'latest';

        $arraySort = ['updated_at', 'desc'];
        if ($sort === 'oldest') {
            $arraySort = ['updated_at', 'asc'];
        }

        [$column, $sort] = $arraySort;

        $itemPerPage = config('my-config.item_per_page');

        if (!$searchQuery) {
            $datas = ProductCategory::orderBy($column, $sort)->paginate($itemPerPage);
        } else {
            $datas = ProductCategory::where('name', 'LIKE', "%$searchQuery%")->orderBy($column, $sort)->paginate($itemPerPage);
        }

        return view('admin.pages.product_category.index', ['datas' => $datas]);
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        $fileName = ProductCategory::DEFAULT_IMAGE;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);

            $fileName = sprintf('%s_%s.%s', $fileName, uniqid(), $extension);

            $image->move(public_path(ProductCategory::IMAGE_PATH), $fileName);
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

    public function detail(ProductCategory $productCategory) : Response
    {
        return response()->json($productCategory);
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        $newImage = $productCategory->image;

        if ($request->hasFile('image')) {
            if ($productCategory->image && $productCategory->image !== ProductCategory::DEFAULT_IMAGE) {
                $oldFilePath = public_path(ProductCategory::IMAGE_PATH . '/' . $productCategory->image);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            //Save new image
            $image = $request->file('image');
            $newFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            $newImage = sprintf('%s_%s.%s', $newFileName, uniqid(), $extension);

            $image->move(public_path(ProductCategory::IMAGE_PATH), $newImage);
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
