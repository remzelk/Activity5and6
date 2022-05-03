<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request['search'] ?? "";
        if ($search != ""){
            $products = Product::where('ProductId', 'LIKE', "%$search%")
            ->orwhere('ProductCode', 'LIKE', "%$search%")
            ->orwhere('ProductName', 'LIKE', "%$search%")
            ->get();
        }
        else{
            $products = Product::all();
        }
        $data = compact('products', 'search');
        return view('Product.index')->with($data);
    }

    public function create()
    {
        return view('Product.create');
    }
    public function store(Request $request)
    {
        $products = new Product();
        $products->ProductCode = request('ProductCode');
        $products->ProductName = request('ProductName');
        $products->Description = request('Description');
        $products->Price = request('Price');
        $products->IsActive = $request->has('IsActive');
        $products->save();
        return redirect('/Product');
    }
    public function edit($ProductId)
    {
        $products = Product::findorfail($ProductId);
        return view('Product.edit')->with('product', $products);   
    }
    public function update(Request $request, $ProductId)
    {   
        $products = Product::findorfail($ProductId);
        $products->ProductCode = $request->input('ProductCode');
        $products->ProductName = $request->input('ProductName');
        $products->Description = $request->input('Description');
        $products->Price = $request->input('Price');
        $products->IsActive = $request->has('IsActive');
        $products->update();
        return redirect('/Product');
    }
    public function destroy($ProductId)
    {
        $products = Product::findorfail($ProductId);
        $products->delete();
        return redirect('/Product');
    }
    
   
}
