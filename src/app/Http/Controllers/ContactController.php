<?php

namespace App\Http\Controllers;

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
        return view('user.contact.complete');
    }

}
