<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        
    }

    public function viewStock()
    {

        $products = Product::all();
        /*$stocks = DB::table('stocks')
        ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->select('products.name','products.unit_of_measurement','products.selling_price','stocks.quantity','stocks.id')
        ->orderBy('products.id', 'desc') // Add this line to order by id in descending order
        ->get();*/
        return view("pages.view-stock")->with("products",$products);
    }
  
    public function addToStock($id){

        $product = Product::find($id);
        $suppliers = Supplier::all();
        return view("pages.add-product-stock")->with("product",$product)->with("suppliers",$suppliers);
    }


    public function submitProductToStock(Request $request){

        /*$request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'stock_date' => 'required|date',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'total' => 'required|numeric',
        ]);*/

        $stock = new Stock();
        $stock->supplier_id = $request->input("supplier_id");
        $stock->date = $request->input("date");
        $stock->due_date = $request->input("due_date");
        $stock->stock_date = $request->input("stock_date");
        $stock->quantity = $request->input("quantity");
        $stock->price = $request->input("price");
        $stock->total = $request->input("total");
        $stock->save();
        return redirect()->route('dashboard');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
