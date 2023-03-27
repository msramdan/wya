<?php

namespace App\Http\Controllers\LandingWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingWebController extends Controller
{
    public function index()
    {
        return view('landing_web.index');
    }
}
