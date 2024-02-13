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

        //return the unit cost to the front end
        $shops = Shop::orderBy("id","desc")->get();
        $products = Product::all();
        $suppliers = Supplier::orderBy("id","desc")->get();
        return view("pages.create-grn-view")->with("suppliers",$suppliers)
        ->with("shops",$shops)->with("products",$products);
    }

    //getting
    public function viewAllStockItems(){ 
        
        $stocks = DB::table('stocks')
        ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
        ->select('products.name as product_name', 'cattegories.cattegory_name','products.barcode as barcode', 'products.selling_price as selling_price', DB::raw('SUM(stocks.quantity) as total_quantity'))
        ->groupBy('products.name', 'products.barcode', 'products.selling_price','cattegories.cattegory_name')
        ->get();

        $lowestStockProduct = null;
        foreach ($stocks as $stock) {
        if ($stock->total_quantity <= 5) {
        if (!$lowestStockProduct || $stock->total_quantity < $lowestStockProduct->total_quantity) {
            $lowestStockProduct = $stock;
        }
        }
    }

        $flashMessages = [];

    if ($lowestStockProduct) {
    $flashMessages[] = "Product {$lowestStockProduct->product_name} is the lowest in stock with {$lowestStockProduct->total_quantity} items.";
    }
        return view("pages.viewall-stock")->with("stocks", $stocks)->with("flashMessages", $flashMessages);
    }
        
    public function addToStock($id){

        $product = Product::find($id);
        $suppliers = Supplier::all();
        return view("pages.add-product-stock")->with("product",$product)->with("suppliers",$suppliers);
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
