<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail; 
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.contact.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'title' => 'required|max:255',
            'detail' => 'required'
        ]);
        
        // セッションに保存
        session([
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'detail' => $request->detail,
        ]);

        return view('user.contact.confirm');
    }


    public function complete(Request $request)
    {
        Contact::create([
            'name' => session('name'),
            'email' => session('email'),
            'title' => session('title'),
            'detail' => session('detail'),
        ]);

        $session_data = session()->only(['name','email','title','detail']);
        // ユーザへ送信　
        Mail::to($session_data['email'])->send(new ContactMail('user.contact.mail', 'お問い合わせが完了しました', $session_data));
        // 管理者へ送信
        Mail::to('admin@example.com')->send(new ContactMail('user.contact.admin_mail', 'お問い合わせを受信しました', $session_data));
        
        return view('user.contact.complete');
    }

}
