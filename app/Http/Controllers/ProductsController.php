<?php

namespace App\Http\Controllers;

use Session;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // Shows a list of products from the products table
        $products = Product::all();
        return view('products')->with('products',$products);
    }


}
