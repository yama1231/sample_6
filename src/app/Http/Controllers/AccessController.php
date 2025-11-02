<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AccessController extends Controller
{
    public function access(): View
    {
        return view('user.access');
    }
}
