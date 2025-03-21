<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Product;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //view for making the sales (view will return the total sales also to the blade file)
    public function index()
    {
        $products = Product::all();
        $customers = Customer::all();
        return view('pages.sell-products', compact('products'))->with("customers",$customers);
    }

    public function finaliseSale(Request $request){

        dd($request->all());

    }

    public function processSale(Request $request)
    {
        $productId = $request->input('product');
        $quantity = $request->input('quantity');

        // Validate inputs as needed

        // Check if there is enough stock
        $stock = Stock::where('product_id', $productId)->sum('quantity');

        if ($quantity > $stock) {
            return redirect()->back()->with('error', 'Not enough stock available.');
        }

        return redirect()->back()->with('success', 'Sale completed successfully.');
    }
}
