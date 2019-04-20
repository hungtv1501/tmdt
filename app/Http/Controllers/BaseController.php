<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function getAllDataCatForUser($cat)
    {
    	return $cat->getAllDataCategories();
    }
}
