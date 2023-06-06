<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaderController extends Controller
{
    public function index()
    {
        return view('account_kader');
    }
}
