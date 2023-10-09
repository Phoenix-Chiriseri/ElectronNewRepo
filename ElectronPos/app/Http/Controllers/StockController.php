<?php

namespace App\Http\Controllers;

use App\Models\Stock;
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
        $stocks = DB::table('stocks')
        ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->select('products.name','products.unit_of_measurement','products.selling_price','stocks.quantity','stocks.id')
        ->orderBy('products.id', 'desc') // Add this line to order by id in descending order
        ->get();
        return view("pages.view-stock")->with("stocks",$stocks);
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
