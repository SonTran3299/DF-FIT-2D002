<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
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
            $datas = User::orderBy($column,  $sort)->paginate($itemPerPage);
        } else {
            $datas = User::where('name', 'LIKE', "%$searchQuery%")->orderBy($column,  $sort)->paginate($itemPerPage);
        }

        return view('admin.pages.user.list', ['datas' => $datas]);
    }

    public function detail(User $user)
    {
        return view('admin.pages.user.detail', ['user' => $user]);
    }
}
