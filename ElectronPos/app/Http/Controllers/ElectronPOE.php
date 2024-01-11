<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Product;

class ElectronPOE extends Controller
{
    
    //show the products and customers on the front end of the point of sale application 
    public function index()
    {
        $customers = Customer::orderBy("id","desc")->get();
        $products = Product::orderBy("id","asc")->get();
        return view('pages.cart.index')->with("customers",$customers)->with("products",$products);
    }

    
}
