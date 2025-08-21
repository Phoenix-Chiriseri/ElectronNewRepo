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

   //please this method is the one to do the direct printing
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

    // Build receipt as plain text
    $receipt = "";
    $receipt .= strtoupper($companyDetails->name) . "\n";
    $receipt .= "TIN: " . $companyDetails->tinnumber . "   VAT: " . $companyDetails->vatnumber . "\n";
    $receipt .= "Phone: " . $companyDetails->phone_number . "\n";
    $receipt .= "Email: " . $companyDetails->email . "\n";
    $receipt .= "Payment: " . $paymentMethod . "\n";
    $receipt .= "Invoice #: " . $sale->id . "\n";
    $receipt .= "Date: " . date('d/m/y') . "\n";
    $receipt .= str_repeat("-", 32) . "\n";
    $receipt .= "Item        Qty   Price   Total\n";
    $receipt .= str_repeat("-", 32) . "\n";
    foreach ($tableData as $item) {
        $line = sprintf("%-10s %3d %7.2f %7.2f\n",
            $item['name'],
            $item['quantity'],
            $item['unitPrice'],
            $item['total']
        );
        $receipt .= $line;
    }
    $receipt .= str_repeat("-", 32) . "\n";
    $vat = $total * 0.16;
    $totalExVat = $total - $vat;
    $receipt .= sprintf("Total Ex VAT:   %7.2f\n", $totalExVat);
    $receipt .= sprintf("VAT (16%%):     %7.2f\n", $vat);
    $receipt .= sprintf("Sub Total:      %7.2f\n", $total);
    $receipt .= sprintf("Amount Paid:    %7.2f\n", $amountPaid);
    $receipt .= sprintf("Change:         %7.2f\n", $change);
    $receipt .= str_repeat("-", 32) . "\n";
    $receipt .= "Thank you for shopping with us!\n";

    // Save to text file (C:/receipts/ElectronReceipt_{sale_id}.txt)
    $directory = "C:/receipts";
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true); // create directory if it doesn't exist
    }
    $receiptPath = $directory . "/ElectronReceipt_" . $sale->id . ".txt";
    file_put_contents($receiptPath, $receipt);
    return redirect()->back()->with('success', 'Sale Complete');
   
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