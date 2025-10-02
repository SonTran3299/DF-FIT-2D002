<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('client.pages.contact');
    }

    public function store(ContactRequest $request){
        $userId = Auth::id() ?? null;

        $check = Contact::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'message' =>$request->message,
            'status' => 0,
            'user_id' => $userId,
        ])? 'Cảm ơn bạn đã phản hồi, chúng tôi sẽ liên lạc với bạn trong thời gian sớm nhất' : 'Thất bại';
        return redirect()->route('client.contact')->with('msg', $check);
    }
}
