<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductWeb;
use ProductWeb as GlobalProductWeb;

class ProductWebController extends Controller
{
   public function index()
   {
       $product = GlobalProductWeb::all();
       return view('product.index', compact('product'));
   }
}
