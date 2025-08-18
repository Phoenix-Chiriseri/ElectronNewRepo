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
        // Decode the JSON string into a PHP array
        $tableData = json_decode($tableDataJson, true);
        
        // Create a new sale record
        $sale = Sales::create([
            'total' => $total,
            'change' => $change,
            'amountPaid' => $amountPaid,
            'user_id' => $userId,
            'payment_method' => $paymentMethod
        ]);
        // Iterate through each item in the sale and associate it with the sale record
        foreach ($tableData as $item) {
            $productId = $item['id'];
            $quantitySold = $item['quantity'];
            Stock::where('product_id', $productId)
                ->decrement('quantity', $quantitySold);
            $sale->products()->attach($productId, ['quantity' => $quantitySold]);
        }
        // Save the invoice HTML
        // $invoiceHtml = view('pages.salesInvoice', [
        //     'sale' => $sale,
        //     'customer' => Customer::find($customerId),
        //     'items' => $tableData,
        //     'details' => $companyDetails,
        //     'amountPaid' => $amountPaid,
        //     'paymentMethod' => $paymentMethod
        // ])->render();
        // $invoice = Invoice::create([
        //     'html' => $invoiceHtml,
        //     'user_id' => $userId
        // ]);
        
        // $sale->invoice_id = $invoice->id;
        // $sale->save();
        // Direct printing using mike42/escpos-php
        
        // Fetch saved printer name from config or database
        $printerName = config('pos.printer_name', 'POS-80'); // fallback to POS-80 if not set
        try {
            $connector = new \Mike42\Escpos\PrintConnectors\WindowsPrintConnector($printerName);
            $printer = new \Mike42\Escpos\Printer($connector);
            // Header with company name
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text(strtoupper($companyDetails->name) . "\n");
            $printer->setEmphasis(false);
            $printer->text("TIN: " . $companyDetails->tinnumber . "   VAT: " . $companyDetails->vatnumber . "\n");
            $printer->text("Phone: " . $companyDetails->phone_number . "\n");
            $printer->text("Email: " . $companyDetails->email . "\n");
            $printer->text("Payment: " . $paymentMethod . "\n");
            $printer->text("Invoice #: " . $sale->id . "\n");
            $printer->text("Date: " . date('d/m/y') . "\n");
            $printer->text(str_repeat("-", 32) . "\n");
            // Items table
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_LEFT);
            $printer->text("Item        Qty   Price   Total\n");
            $printer->text(str_repeat("-", 32) . "\n");
            foreach ($tableData as $item) {
                $line = sprintf("%-10s %3d %7.2f %7.2f\n",
                    $item['name'],
                    $item['quantity'],
                    $item['unitPrice'],
                    $item['total']
                );
                $printer->text($line);
            }
            
            $printer->text(str_repeat("-", 32) . "\n");
            // Totals
            $vat = $total * 0.16;
            $totalExVat = $total - $vat;
            $printer->text(sprintf("Total Ex VAT:   %7.2f\n", $totalExVat));
            $printer->text(sprintf("VAT (16%%):     %7.2f\n", $vat));
            $printer->text(sprintf("Sub Total:      %7.2f\n", $total));
            $printer->text(sprintf("Amount Paid:    %7.2f\n", $amountPaid));
            $printer->text(sprintf("Change:         %7.2f\n", $change));
            $printer->text(str_repeat("-", 32) . "\n");
            // Footer
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for shopping with us!\n");
            $printer->cut();
            $printer->close();
        } catch (\Exception $e) {
            \Log::error('Print error: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Sale completed and receipt printed.');
    }

    public function create()
    {
        //
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