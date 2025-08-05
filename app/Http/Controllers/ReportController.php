<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Sales;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(){
        return view("pages.reports");
    }

    public function dailySales() {
        $today = Carbon::today();
        $sales = Sales::whereDate('created_at', $today)
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
            ->get();
        
        $totalSales = $sales->sum('total');
        $totalTransactions = $sales->sum('count');
        
        return view('pages.reports', [
            'reportData' => compact('sales', 'totalSales', 'totalTransactions', 'today'),
            'reportTitle' => 'Daily Sales Report - ' . $today->format('Y-m-d'),
            'reportType' => 'daily'
        ]);
    }

    public function weeklySales() {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        
        $sales = Sales::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
        
        $totalWeeklySales = $sales->sum('total');
        
        return view('pages.reports', [
            'reportData' => compact('sales', 'totalWeeklySales', 'startOfWeek', 'endOfWeek'),
            'reportTitle' => 'Weekly Sales Report',
            'reportType' => 'weekly'
        ]);
    }

    public function yearlySales() {
        $currentYear = Carbon::now()->year;
        $year = request('year', $currentYear);
        
        $sales = Sales::leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->select('users.name as cashier_name', 'sales.*')
            ->whereYear('sales.created_at', $year)
            ->orderBy('sales.created_at', 'desc')
            ->get();
        
        // Calculate summary statistics
        $totalSales = $sales->sum('total');
        $totalTransactions = $sales->count();
        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        
        // Group sales by month
        $monthlySales = $sales->groupBy(function($sale) {
            return Carbon::parse($sale->created_at)->format('M');
        })->map(function($monthSales) {
            return [
                'total' => $monthSales->sum('total'),
                'count' => $monthSales->count()
            ];
        });
        
        return view('pages.reports', [
            'reportData' => compact('sales', 'year', 'totalSales', 'totalTransactions', 'averageTransaction', 'monthlySales'),
            'reportTitle' => 'Yearly Sales Report - ' . $year,
            'reportType' => 'yearly'
        ]);
    }

    public function zReport() {
        $today = Carbon::today();
        $sales = Sales::whereDate('created_at', $today)->get();
        
        $cashSales = $sales->where('payment_method', 'Cash')->sum('total');
        $cardSales = $sales->where('payment_method', 'Card')->sum('total');
        $totalSales = $sales->sum('total');
        $transactionCount = $sales->count();
        
        return view('pages.reports', [
            'reportData' => compact('cashSales', 'cardSales', 'totalSales', 'transactionCount', 'today'),
            'reportTitle' => 'Z Report - End of Day',
            'reportType' => 'z-report'
        ]);
    }

    public function taxReport() {
        $today = Carbon::today();
        $sales = Sales::with('products')->whereDate('created_at', $today)->get();
        
        $taxableAmount = 0;
        $taxAmount = 0;
        
        foreach($sales as $sale) {
            foreach($sale->products as $product) {
                $itemTotal = $product->pivot->quantity * $product->price;
                $itemTax = $itemTotal * ($product->tax ?? 0);
                $taxableAmount += $itemTotal;
                $taxAmount += $itemTax;
            }
        }
        
        return view('pages.reports', [
            'reportData' => compact('taxableAmount', 'taxAmount', 'today'),
            'reportTitle' => 'Tax Report',
            'reportType' => 'tax'
        ]);
    }

    public function employeeShift() {
        $today = Carbon::today();
        $employees = User::with(['sales' => function($query) use ($today) {
            $query->whereDate('created_at', $today);
        }])->get();
        
        $employeeData = $employees->map(function($employee) {
            return [
                'name' => $employee->name,
                'sales_count' => $employee->sales->count(),
                'total_sales' => $employee->sales->sum('total')
            ];
        })->filter(function($data) {
            return $data['sales_count'] > 0;
        });
        
        return view('pages.reports', [
            'reportData' => compact('employeeData', 'today'),
            'reportTitle' => 'Employee Shift Report',
            'reportType' => 'employee-shift'
        ]);
    }

    public function inventoryValuation() {
        $stocks = DB::table('stocks')
        ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
        ->select(
            'products.name as product_name',
            'cattegories.cattegory_name as category_name',
            'products.barcode',
            'products.selling_price',
            DB::raw('SUM(stocks.quantity) as total_quantity'),
            DB::raw('SUM(stocks.total_cost) as total_cost')
        )
        ->groupBy('products.name', 'products.barcode', 'products.selling_price', 'cattegories.cattegory_name')
        ->get();

        $inventoryValuationReport = [];
        $totalInventoryValue = 0;
        $totalRetailValue = 0;

        foreach ($stocks as $stock) {
            $inventoryValue = round($stock->selling_price * $stock->total_quantity, 3);
            $totalInventoryValue += $inventoryValue;
            
            $inHandStock = $stock->total_quantity;
            $averageCost = round($stock->total_cost/$stock->total_quantity, 2);
            $retailPrice = round($stock->selling_price, 3);
            $retailValue = round($retailPrice * $inHandStock, 3);
            $potentialProfit = round(($retailPrice - $averageCost) * $inHandStock, 3);
            $margin = 0;

            if ($retailValue != 0) {
                $margin = round(($potentialProfit / $retailValue) * 100, 3);
            }

            $inventoryValuationReport[] = [
                'Product Name' => $stock->product_name,
                'Category' => $stock->category_name,
                'Barcode' => $stock->barcode,
                'Selling Price' => $retailPrice,
                'In Hand Stock' => $inHandStock,
                'Average Cost' => $averageCost,
                'Retail Price' => $retailPrice,
                'Inventory Value' => $inventoryValue,
                'Retail Value' => $retailValue,
                'Potential Profit' => $potentialProfit,
                'Margin' => $margin,
            ];
        }

        return view('pages.reports', [
            'reportData' => compact('inventoryValuationReport', 'totalInventoryValue'),
            'reportTitle' => 'Inventory Valuation Report',
            'reportType' => 'inventory-valuation'
        ]);
    }

    public function downloadReport($type) {
        // Simple CSV download for now
        $filename = $type . '-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];
        
        return response()->stream(function() {
            echo "Report data would be here";
        }, 200, $headers);
    }

    //  public function inventoryValuation()
    // {
    //     $stocks = DB::table('stocks')
    //     ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
    //     ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
    //     ->select(
    //         'products.name as product_name',
    //         'cattegories.cattegory_name as category_name',
    //         'products.barcode',
    //         'products.selling_price',
    //         DB::raw('SUM(stocks.quantity) as total_quantity'),
    //         DB::raw('SUM(stocks.total_cost) as total_cost') // Ensure total_cost is selected
    //     )
    //     ->groupBy('products.name', 'products.barcode', 'products.selling_price', 'cattegories.cattegory_name')
    //     ->get();

    //     $inventoryValuationReport = [];
    //     $totalInventoryValue = 0;
    //     $totalRetailValue = 0;

    //     foreach ($stocks as $stock) {
    //         $inventoryValue = round($stock->selling_price * $stock->total_quantity, 3);
    //         $totalInventoryValue += $inventoryValue;
            
    //         // Additional calculations
    //         $inHandStock = $stock->total_quantity;
    //         //$averageCost = round($stock->average_cost, 3); 
    //         $averageCost = round($stock->total_cost/$stock->total_quantity, 2);
    //         $retailPrice = round($stock->selling_price, 3); // Rounded to 3 decimal places
    //         $retailValue = round($retailPrice * $inHandStock, 3); // Rounded to 3 decimal places
    //         $potentialProfit = round(($retailPrice - $averageCost) * $inHandStock, 3); // Rounded to 3 decimal places
    //         //$margin = round(($potentialProfit / $retailValue) * 100, 3); // Rounded to 3 decimal places
    //         $margin = 0; // Default value

    //         if ($retailValue != 0) {
    //         $margin = round(($potentialProfit / $retailValue) * 100, 3); // Calculate margin if retail value is non-zero
    //         }

    //         $inventoryValuationReport[] = [
    //             'Product Name' => $stock->product_name,
    //             'Category' => $stock->category_name,
    //             'Barcode' => $stock->barcode,
    //             'Selling Price' => $retailPrice, // Using retail price instead of selling price
    //             'In Hand Stock' => $inHandStock,
    //             'Average Cost' => $averageCost,
    //             'Retail Price' => $retailPrice,
    //             'Inventory Value' => $inventoryValue,
    //             'Retail Value' => $retailValue,
    //             'Potential Profit' => $potentialProfit,
    //             'Margin' => $margin,
    //         ];
    //     }

    //     return view('pages.inventoryvaluation', [
    //         'inventoryValuationReport' => $inventoryValuationReport,
    //         'totalInventoryValue' => $totalInventoryValue,
    //     ]);
        
    // }
      
    // public function viewProductRpt(){
        
    //     return view("pages.viewproduct-rpt");
    // }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //

    //     return view('pages.view-reports');
    // }

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
