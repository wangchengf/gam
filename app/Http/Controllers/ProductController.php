<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::all();
        return view('admin.products',['products'=>$products]);
    }

    public function destroy($id){
        Product::destroy($id);
        return redirect('/admin/products');
    }

    public function newProduct(){
        return view('admin.new');
    }

    public function add(Request $request){
        $file = $request->file('file');
        $extension = $file->extension();
        //Storage::disk('local')->put(,File::get($file));
        $path = $file->storeAs('images', $file->getFilename().'.'.$extension);
        $entry = new \App\File();
        $entry ->mime = $file->getClientMimeType();
        $entry->original_filename = $file->getClientOriginalName();
        $entry->filename = $file->getFilename().'.'.$extension;
        $entry->save();

        $product = new Product();
        $product->file_id= $entry->id;
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = floatval($request->input('price'));
        $product->imageurl = $request->input('imageurl');
        $product->save();
        return redirect('/admin/products');
    }
}
