<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use ProductWeb as GlobalProductWeb;

class ProductWebController extends Controller
{
    public function index()
    {
        return 'pakyu';
        $products = Product::paginate(20);
        // dd($products);
        return view('product.index', compact('products'));
    }

    public function show($id)
    {

    }
}
