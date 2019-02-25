<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
    	$title = "This is About";

    	// nap vao 1 view HTML
    	return view('about.index')->with('title',$title);
    }
}
