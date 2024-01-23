<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Grv;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class StockController extends Controller
{

    public function createGRNView(){

        $shops = Shop::orderBy("id","desc")->get();
        $suppliers = Supplier::orderBy("id","desc")->get();
        return view("pages.create-grn-view")->with("suppliers",$suppliers)
        ->with("shops",$shops);
    }

    public function viewStock()
    {
        $products = Product::all();
        return view("pages.view-stock")->with("products",$products);
    }


    public function viewAllStockItems(){
       
        $stocks = GRV::join('suppliers', 'g_r_v_s.supplier_id', '=', 'suppliers.id')
        ->leftJoin('stocks', 'g_r_v_s.id', '=', 'stocks.grv_id')
        ->leftJoin('products', 'stocks.product_name', '=', 'products.name') // Join with the products table
        ->select(
            'products.id',
            'products.*',
            'stocks.*',
            \DB::raw('(SELECT COALESCE(SUM(quantity), 0) FROM stocks WHERE product_name = products.name) as total_stock') // Calculate the total stock for each product
             // Calculate the total stock for each product
        )
        ->orderByDesc("total_stock") // Order by total stock in descending order
        ->get();
         $total_stock = $stocks->isEmpty() ? 0 : $stocks->first()->total_stock;          
          return view("pages.viewall-stock")->with("stocks", $stocks)->with("total_stock", $total_stock);
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
        $stock->product_id = $request->input("product_id");
        $stock->date = $request->input("date");
        $stock->due_date = $request->input("due_date");
        $stock->stock_date = $request->input("stock_date");
        $stock->quantity = $request->input("quantity");
        $stock->price = $request->input("price");
        $stock->total = $request->input("total");
        $stock->save();
        return redirect()->route('viewall-stock');
    }

    public function editStock($id){

        //find the stock object by the id and also return the suppliers to the blade front end
        $stock = Stock::find($id);
        $suppliers = Supplier::all();
        return view("pages.edit-stock")->with("stock",$stock)->with("suppliers",$suppliers);
    }


    public function store(Request $request)
    {
       dd($request->all());
    
    }
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
