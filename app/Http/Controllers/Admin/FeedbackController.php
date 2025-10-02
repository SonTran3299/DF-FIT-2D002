<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $itemPerPage = config('my-config.item_per_page');
        $datas = Contact::orderBy('created_at', 'desc')->paginate($itemPerPage);
        return view('admin.pages.feedback.list', ['datas' => $datas]);
    }

    public function detail(Contact $contact)
    {
        return view('admin.pages.feedback.detail', ['contact' => $contact]);
    }

    public function answer(Contact $contact)
    {
        $contact->status = 2;
        $check = $contact->save() ? 'Thành công' : 'Thất bại';
        return redirect()->route('admin.feedback')->with('msg', $check);
    }
}
