<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function viewInventoryValuationReport()
    {
        $stocks = DB::table('stocks')
        ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
        ->select(
            'products.name as product_name',
            'cattegories.cattegory_name as category_name',
            'products.barcode',
            'products.selling_price',
            DB::raw('SUM(stocks.quantity) as total_quantity'),
            DB::raw('SUM(stocks.total_cost) as total_cost') // Ensure total_cost is selected
        )
        ->groupBy('products.name', 'products.barcode', 'products.selling_price', 'cattegories.cattegory_name')
        ->get();

        $inventoryValuationReport = [];
        $totalInventoryValue = 0;
        $totalRetailValue = 0;

        foreach ($stocks as $stock) {
            $inventoryValue = round($stock->selling_price * $stock->total_quantity, 3);
            $totalInventoryValue += $inventoryValue;
            
            // Additional calculations
            $inHandStock = $stock->total_quantity;
            //$averageCost = round($stock->average_cost, 3); 
            $averageCost = round($stock->total_cost/$stock->total_quantity, 2);
            $retailPrice = round($stock->selling_price, 3); // Rounded to 3 decimal places
            $retailValue = round($retailPrice * $inHandStock, 3); // Rounded to 3 decimal places
            $potentialProfit = round(($retailPrice - $averageCost) * $inHandStock, 3); // Rounded to 3 decimal places
            //$margin = round(($potentialProfit / $retailValue) * 100, 3); // Rounded to 3 decimal places
            $margin = 0; // Default value

            if ($retailValue != 0) {
            $margin = round(($potentialProfit / $retailValue) * 100, 3); // Calculate margin if retail value is non-zero
            }

            $inventoryValuationReport[] = [
                'Product Name' => $stock->product_name,
                'Category' => $stock->category_name,
                'Barcode' => $stock->barcode,
                'Selling Price' => $retailPrice, // Using retail price instead of selling price
                'In Hand Stock' => $inHandStock,
                'Average Cost' => $averageCost,
                'Retail Price' => $retailPrice,
                'Inventory Value' => $inventoryValue,
                'Retail Value' => $retailValue,
                'Potential Profit' => $potentialProfit,
                'Margin' => $margin,
            ];
        }

        return view('pages.inventoryvaluation', [
            'inventoryValuationReport' => $inventoryValuationReport,
            'totalInventoryValue' => $totalInventoryValue,
        ]);
        
    }
      

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('pages.view-reports');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
