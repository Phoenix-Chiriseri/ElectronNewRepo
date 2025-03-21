<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Grv;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SetStockLevels;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class StockController extends Controller
{

    public function createGRNView(){

        //return the unit cost to the front end
        $products = Product::orderBy("id","desc")->get();
        $suppliers = Supplier::orderBy("id","desc")->get();
        return view("pages.create-grn-view")->with("suppliers",$suppliers)->with("products",$products);
    }

    public function enquire(){
        
        $products = Product::all();
        return view("pages.stock-enquiry")->with("products",$products);
    }

    public function searchStock(Request $request){

        $product_id = $request->input("produc t_id");
        $from_date = $request->input("from_date");
        $to_date = $request->input("to_date");
        $stocks = Stock::leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->select(DB::raw('SUM(stocks.quantity) as total_quantity'))
        ->where('products.id',$product_id)
        ->get();
        $total_quantity = $stocks[0]->total_quantity;
        if (!$total_quantity) {
            return redirect()->back()->with('success', 'Stock Level Is'.$total_quantity);
         } else {
             return redirect()->back()->with('error', 'Sorry, there was a problem retrieving the stock count');
        }     
    }

    public function viewAllStockItems(){ 

        //set the stock levels to the latest value that has been inserted into the database
        $stockLevels = SetStockLevels::latest()->first();
        $allProducts = Product::all()->count();
        $stocks = Stock::leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
        ->select(
        'products.name as product_name', 
        'cattegories.cattegory_name', 
        'products.barcode as barcode', 
        'products.selling_price as selling_price', 
        'products.price as unit_cost', 
        'products.unit_of_measurement as measurement', 
        DB::raw('SUM(stocks.quantity) as total_quantity'), // Total quantity
        DB::raw('SUM(stocks.quantity * products.price) as cost'), // Total cost
        DB::raw('SUM(stocks.quantity * products.selling_price) as value') // Total value
    )
    ->groupBy('products.name', 'products.barcode', 'products.selling_price', 'products.price', 'cattegories.cattegory_name', 'products.unit_of_measurement')
    ->get();


    //fetch the overall cost price from the database
     $overallCost = Stock::leftJoin('products', 'stocks.product_id', '=', 'products.id')
    ->select(DB::raw('SUM(stocks.quantity * products.price) as overall_cost'))
    ->first()->overall_cost;
    
    //fetch the overall selling pice from the database
    $overallSellingPrice = Stock::leftJoin('products', 'stocks.product_id', '=', 'products.id')
    ->select(DB::raw('SUM(stocks.quantity * products.selling_price) as overall_selling_price'))
    ->first()->overall_selling_price;
        
    $totalPurchases = 0;
        foreach ($stocks as $stock) {
        // Calculate the total purchase cost for each item
        $purchaseCost = $stock->unit_cost * $stock->total_quantity;
        // Add the total purchase cost to the overall total
        $totalPurchases += $purchaseCost;
        }    
        $totalValueOfStock = Stock::sum('total_cost');
        $totalValueOfStock2 = Stock::sum('total_cost');
        //dd($totalValueOfProducts);
        $lowestStockProduct = null;
        foreach ($stocks as $stock) {
        if ($stock->total_quantity <= $stockLevels) {
        if (!$lowestStockProduct || $stock->total_quantity < $lowestStockProduct->total_quantity) {
            $lowestStockProduct = $stock;
        }
       }
     } 

        $flashMessages = [];

    if ($lowestStockProduct) {
    $flashMessages[] = "Product {$lowestStockProduct->product_name} is the lowest in stock with {$lowestStockProduct->total_quantity} items.";
    }
        return view("pages.viewall-stock")->with("stocks", $stocks)->with("flashMessages", $flashMessages)->with("totalValueOfStock",$totalValueOfStock)->with("totalPurchases",$totalPurchases)->with("allProducts",$allProducts)->with("overallCost",$overallCost)->with("overallSelling",$overallSellingPrice);
    }
        
    public function addToStock($id){

        $product = Product::find($id);
        $suppliers = Supplier::orderBy("id","desc")->get();
        return view("pages.add-product-stock")->with("product",$product)->with("suppliers",$suppliers);
    }

    public function editStock($id){

        //find the stock object by the id and also return the suppliers to the blade front end
        $stock = Stock::find($id);
        $suppliers = Supplier::all();
        return view("pages.edit-stock")->with("stock",$stock)->with("suppliers",$suppliers);
    }
}
