<?php

namespace App\Http\Controllers\LandingWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingWebController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function list()
    {
        return view('frontend.list');
    }

    public function form()
    {
        return view('frontend.form');
    }

    public function private()
    {
        return view('frontend.private');
    }

}
