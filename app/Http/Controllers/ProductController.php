<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    
    public function index() {
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */

}

   