<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class MainController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        return view('main.index',['products'=>$products]);
    }
}
