<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Product;
use App\Models\CompanyData;
use App\Models\Invoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Models\Stock;
use App\Models\User;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\BluetoothPrintConnector;
use Illuminate\Support\Facades\Session;

class SaleController extends Controller
{
    
     public function index()
     {
        //return the sales to the view-sales blade file
        $sales = Sales::leftJoin('users', 'sales.user_id', '=', 'users.id')
        ->select('users.name', 'sales.*')
        ->orderBy('sales.id', 'desc')
        ->paginate(5);
        $numberOfSales = Sales::all()->count();
        return view("pages.view-sales")->with("sales",$sales)->with("numberOfSales",$numberOfSales);
    }


    public function doTransaction(Request $request) {
    
    $userId = Auth::user()->id;
    $paymentMethod = $request->input("payment_method");
    $total = $request->input('total');
    $change = $request->input('change');
    $amountPaid = $request->input('amountPaid');
    $customerId = $request->input('customerId');
    $tableDataJson = $request->input('table_data');
    $companyDetails = CompanyData::latest()->first();
    $tableData = json_decode($tableDataJson, true);

    $sale = Sales::create([
        'total' => $total,
        'change' => $change,
        'amountPaid' => $amountPaid,
        'user_id' => $userId,
        'payment_method' => $paymentMethod
    ]);

    foreach ($tableData as $item) {
        $productId = $item['id'];
        $quantitySold = $item['quantity'];
        Stock::where('product_id', $productId)
            ->decrement('quantity', $quantitySold);
        $sale->products()->attach($productId, ['quantity' => $quantitySold]);
    }

    // Prepare data for PDF
    $pdfData = [
        'sale' => $sale,
        'customer' => Customer::find($customerId),
        'items' => $tableData,
        'details' => $companyDetails,
        'amountPaid' => $amountPaid,
        'paymentMethod' => $paymentMethod
    ];

    // Generate PDF using Blade view
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.salesInvoice', $pdfData);
    // Save PDF to C:/receipts/ElectronReceipt_{sale_id}.pdf
    $directory = "C:/receipts";
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true); // create directory if it doesn't exist
    }
    $receiptPath = $directory . "/ElectronReceipt_" . $sale->id . ".pdf";
    $pdf->save($receiptPath);

    // Silent print using SumatraPDF
    $sumatraPath = 'C:\\Users\\itai\\AppData\\Local\\SumatraPDF\\SumatraPDF.exe';
    $printerName = 'POS-80'; // Change to your printer name
    $cmd = "\"$sumatraPath\" -print-to \"$printerName\" -silent \"$receiptPath\"";
    exec($cmd, $output, $resultCode);
    return redirect()->back()->with('success', 'Sale Complete, PDF exported and sent to printer.');
    
    }

    public function create()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}