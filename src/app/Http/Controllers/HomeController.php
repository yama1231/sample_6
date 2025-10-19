<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;


const STATUS_NOT_COMPLETE = '0';
const STATUS_COMPLETE = '1';

class HomeController extends Controller
{
    public function index()
    {
        $contact_list = Contact::orderBy('created_at','desc')->paginate(5);
        return view('dashboard',compact('contact_list'));
    }


    public function dashboard_detail(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $contact = Contact::findOrFail($contact_id);
        return view('dashboard_detail',compact('contact'));
    }

    public function dashboard_edit(Request $request)
    {
        $contact_id = $request->input('contact_id');
        $status = $request->status;
        $contact = Contact::findOrFail($contact_id);
        $contact->status = $status;
        $contact->update();

        return redirect()->route('dashboard_detail', ['contact_id' => $contact->id]);
        // return redirect('/dashboard_detail?contact_id=' . $contact->id);
    }


}


