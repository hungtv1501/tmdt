<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index()
    {
    	return "This is democontroller";
    }

    public function test($myName, $myAge, Request $request)
    {
    	$name = $request->name;
    	$age  = $request->age;
    	
    	return "my name - {$name} : My age - {$age} ";
    }
}
