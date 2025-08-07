<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\PaymentTypes;
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
        $paymentMethods = PaymentTypes::orderBy("id","desc")->get();
        return view("pages.reports")->with("paymentMethods", $paymentMethods);
    }

    public function dailySales(Request $request) {
        $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));
        $paymentMethod = $request->get('payment_method');
        
        $salesQuery = Sales::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($paymentMethod) {
            $salesQuery->where('payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
            ->get();
        
        $totalSales = $sales->sum('total');
        $totalTransactions = $sales->sum('count');
        
        $reportTitle = 'Daily Sales Report - ' . $startDate . ' to ' . $endDate;
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }
        
        return view('pages.reports', [
            'reportData' => compact('sales', 'totalSales', 'totalTransactions', 'startDate', 'endDate', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'daily',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function weeklySales(Request $request) {
        $startDate = $request->get('start_date', Carbon::now()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfWeek()->format('Y-m-d'));
        $paymentMethod = $request->get('payment_method');
        
        $salesQuery = Sales::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($paymentMethod) {
            $salesQuery->where('payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
        
        $totalWeeklySales = $sales->sum('total');
        
        $reportTitle = 'Weekly Sales Report - ' . $startDate . ' to ' . $endDate;
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }
        
        return view('pages.reports', [
            'reportData' => compact('sales', 'totalWeeklySales', 'startDate', 'endDate', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'weekly',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function yearlySales(Request $request) {
        $currentYear = Carbon::now()->year;
        $year = $request->get('year', $currentYear);
        $startDate = $request->get('start_date', $year . '-01-01');
        $endDate = $request->get('end_date', $year . '-12-31');
        $paymentMethod = $request->get('payment_method');
        
        $salesQuery = Sales::leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->select('users.name as cashier_name', 'sales.*')
            ->whereBetween('sales.created_at', [$startDate, $endDate]);
            
        if ($paymentMethod) {
            $salesQuery->where('sales.payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->orderBy('sales.created_at', 'desc')->get();
        
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
        
        $reportTitle = 'Yearly Sales Report - ' . $startDate . ' to ' . $endDate;
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }
        
        return view('pages.reports', [
            'reportData' => compact('sales', 'year', 'startDate', 'endDate', 'totalSales', 'totalTransactions', 'averageTransaction', 'monthlySales', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'yearly',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function quarterlySales(Request $request) {
        $quarter = $request->get('quarter', Carbon::now()->quarter);
        $year = $request->get('year', Carbon::now()->year);
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $paymentMethod = $request->get('payment_method');
        
        // If custom date range is provided, use it; otherwise use quarter dates
        if (!$startDate || !$endDate) {
            $startDate = Carbon::createFromDate($year, ($quarter - 1) * 3 + 1, 1)->startOfMonth()->format('Y-m-d');
            $endDate = Carbon::createFromDate($year, $quarter * 3, 1)->endOfMonth()->format('Y-m-d');
        }
        
        $salesQuery = Sales::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($paymentMethod) {
            $salesQuery->where('payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->get();
        
        $totalSales = $sales->sum('total');
        $totalTransactions = $sales->count();
        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        
        // Group sales by month within the quarter
        $monthlySales = $sales->groupBy(function($sale) {
            return Carbon::parse($sale->created_at)->format('M');
        })->map(function($monthSales) {
            return [
                'total' => $monthSales->sum('total'),
                'count' => $monthSales->count()
            ];
        });
        
        // Get quarter name
        $quarterNames = [1 => 'Q1 (Jan-Mar)', 2 => 'Q2 (Apr-Jun)', 3 => 'Q3 (Jul-Sep)', 4 => 'Q4 (Oct-Dec)'];
        $quarterName = $quarterNames[$quarter];
        
        $reportTitle = 'Quarterly Sales Report - ' . $quarterName . ' ' . $year;
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }
        
        return view('pages.reports', [
            'reportData' => compact('sales', 'quarter', 'year', 'quarterName', 'startDate', 'endDate', 'totalSales', 'totalTransactions', 'averageTransaction', 'monthlySales', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'quarterly',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function zReport(Request $request) {
        $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));
        $paymentMethod = $request->get('payment_method');
        
        $salesQuery = Sales::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($paymentMethod) {
            $salesQuery->where('payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->get();
        
        $cashSales = $sales->where('payment_method', 'Cash')->sum('total');
        $cardSales = $sales->where('payment_method', 'Card')->sum('total');
        $totalSales = $sales->sum('total');
        $transactionCount = $sales->count();
        
        $reportTitle = 'Z Report - ' . $startDate . ' to ' . $endDate;
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }
        
        return view('pages.reports', [
            'reportData' => compact('cashSales', 'cardSales', 'totalSales', 'transactionCount', 'startDate', 'endDate', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'z-report',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function taxReport(Request $request) {
        $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));
        $paymentMethod = $request->get('payment_method');
        
        $salesQuery = Sales::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($paymentMethod) {
            $salesQuery->where('payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->get();
        
        $totalSales = $sales->sum('total');
        $totalTax = $sales->sum('tax');
        $salesBeforeTax = $totalSales - $totalTax;
        
        $reportTitle = 'Tax Report - ' . $startDate . ' to ' . $endDate;
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }
        
        return view('pages.reports', [
            'reportData' => compact('totalSales', 'totalTax', 'salesBeforeTax', 'startDate', 'endDate', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'tax-report',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function employeeShift(Request $request) {
        $startDate = $request->get('start_date', Carbon::today()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::today()->format('Y-m-d'));
        $paymentMethod = $request->get('payment_method');
        
        $salesQuery = Sales::with('user')
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        if ($paymentMethod) {
            $salesQuery->where('payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->get();
        
        $employeeData = $sales->groupBy('user.name')->map(function ($group) {
            return [
                'sales_count' => $group->count(),
                'total_sales' => $group->sum('total'),
                'total_tax' => $group->sum('tax')
            ];
        });
        
        $reportTitle = 'Employee Shift Report - ' . $startDate . ' to ' . $endDate;
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }
        
        return view('pages.reports', [
            'reportData' => compact('employeeData', 'startDate', 'endDate', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'employee-shift',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function inventoryValuation(Request $request) {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $paymentMethod = $request->get('payment_method');
        
        $stocksQuery = DB::table('stocks')
            ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
            ->select(
                'products.name as product_name',
                'cattegories.cattegory_name as category_name',
                'products.barcode',
                'products.selling_price',
                DB::raw('SUM(stocks.quantity) as total_quantity'),
                DB::raw('SUM(stocks.total_cost) as total_cost')
            );
            
        if ($startDate && $endDate) {
            $stocksQuery->whereBetween('stocks.created_at', [$startDate, $endDate]);
        }
        
        $stocks = $stocksQuery->groupBy('products.name', 'products.barcode', 'products.selling_price', 'cattegories.cattegory_name')
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

        $reportTitle = 'Inventory Valuation Report' . ($startDate && $endDate ? ' - ' . $startDate . ' to ' . $endDate : '');
        if ($paymentMethod) {
            $reportTitle .= ' (Payment Method: ' . ucfirst(str_replace('_', ' ', $paymentMethod)) . ')';
        }

        return view('pages.reports', [
            'reportData' => compact('inventoryValuationReport', 'totalInventoryValue', 'startDate', 'endDate', 'paymentMethod'),
            'reportTitle' => $reportTitle,
            'reportType' => 'inventory-valuation',
            'paymentMethods' => PaymentTypes::all()
        ]);
    }

    public function downloadReport(Request $request, $type) {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $paymentMethod = $request->get('payment_method');
        
        $filename = $type . '-report-' . date('Y-m-d');
        if ($paymentMethod) {
            $filename .= '-' . strtolower(str_replace(' ', '-', $paymentMethod));
        }
        $filename .= '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ];
        
        return response()->stream(function() use ($type, $startDate, $endDate, $paymentMethod) {
            $handle = fopen('php://output', 'w');
            
            // Add CSV headers based on report type
            switch ($type) {
                case 'daily':
                case 'weekly':
                case 'yearly':
                case 'quarterly':
                    fputcsv($handle, ['Date', 'Total Sales', 'Tax', 'Payment Method']);
                    
                    $salesQuery = Sales::query();
                    if ($startDate && $endDate) {
                        $salesQuery->whereBetween('created_at', [$startDate, $endDate]);
                    }
                    if ($paymentMethod) {
                        $salesQuery->where('payment_method', $paymentMethod);
                    }
                    
                    $sales = $salesQuery->get();
                    foreach ($sales as $sale) {
                        fputcsv($handle, [
                            $sale->created_at->format('Y-m-d'),
                            $sale->total,
                            $sale->tax,
                            $sale->payment_method
                        ]);
                    }
                    break;
                    
                default:
                    fputcsv($handle, ['Report Type', 'Data']);
                    fputcsv($handle, [$type, 'Report data would be here']);
            }
            
            fclose($handle);
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

    public function downloadPaymentReport($type, Request $request)
    {
        $paymentMethod = $request->get('payment_method');
        $date = $request->get('date');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        // Determine date range based on report type and parameters
        switch ($type) {
            case 'daily':
                $startDate = $endDate = $date ?: Carbon::today()->format('Y-m-d');
                break;
            case 'weekly':
                if (!$startDate || !$endDate) {
                    $startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
                    $endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
                }
                break;
            case 'monthly':
                if (!$startDate || !$endDate) {
                    $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
                    $endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
                }
                break;
            default:
                return abort(404, 'Invalid report type');
        }

        // Query sales based on payment method and date range
        $salesQuery = Sales::whereBetween('created_at', [$startDate, $endDate]);
        
        if ($paymentMethod && $paymentMethod !== 'all') {
            $salesQuery->where('payment_method', $paymentMethod);
        }
        
        $sales = $salesQuery->get();
        
        $totalSales = $sales->sum('total');
        $totalTransactions = $sales->count();
        $averageTransaction = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

        // Generate CSV as a fallback/alternative to PDF
        $filename = "{$type}-{$paymentMethod}-report-{$startDate}-to-{$endDate}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($sales, $paymentMethod, $type, $startDate, $endDate, $totalSales, $totalTransactions, $averageTransaction) {
            $file = fopen('php://output', 'w');
            
            // Add report header
            fputcsv($file, ['Electron POS - ' . ucfirst($type) . ' ' . ucfirst($paymentMethod) . ' Sales Report']);
            fputcsv($file, ['Report Period:', $startDate . ' to ' . $endDate]);
            fputcsv($file, ['Payment Method:', ucfirst(str_replace('_', ' ', $paymentMethod))]);
            fputcsv($file, ['Generated:', Carbon::now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []); // Empty row
            
            // Add summary
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Sales:', '$' . number_format($totalSales, 2)]);
            fputcsv($file, ['Total Transactions:', $totalTransactions]);
            fputcsv($file, ['Average Transaction:', '$' . number_format($averageTransaction, 2)]);
            fputcsv($file, []); // Empty row
            
            // Add table headers
            fputcsv($file, ['Date', 'Transaction ID', 'Payment Method', 'Amount', 'Customer', 'Employee']);
            
            // Add transaction data
            foreach ($sales as $sale) {
                fputcsv($file, [
                    Carbon::parse($sale->created_at)->format('M d, Y H:i'),
                    $sale->id,
                    ucfirst(str_replace('_', ' ', $sale->payment_method)),
                    '$' . number_format($sale->total, 2),
                    $sale->customer_name ?? 'Walk-in Customer',
                    $sale->employee_name ?? 'N/A'
                ]);
            }
            
            // Add total row
            fputcsv($file, ['', '', 'TOTAL:', '$' . number_format($totalSales, 2), '', '']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
