<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
	public function __construct()
	{
		// khai bao su dung middleware o day
		//$this->middleware('testLogin')->only('index');
		$this->middleware('testLogin:user')->except(['info','demo']);
	}

    public function index()
    {
    	return "This is index - ExampleController";
    }

    public function demo()
    {
    	return "Demo middleware";
    }

    public function info()
    {
    	return "Hello you";
    }
}
