<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function about()
    {
        return view('website.about-us');
    }

    public function contact()
    {
        return view('website.contact-us');
    }


    public function privacy()
    {
        return view('website.privacy');
    }


    public function terms()
    {
        return view('website.terms');
    }
}
