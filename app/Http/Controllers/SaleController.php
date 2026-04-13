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
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

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

    public function doTransaction(Request $request)
    
    {
    $userId = Auth::user()->id;
    $paymentMethod = $request->input("payment_method");
    $total = $request->input('total');
    $change = $request->input('change');
    $amountPaid = $request->input('amountPaid');
    $customerId = $request->input('customerId');
    $tableDataJson = $request->input('table_data');
    $companyDetails = CompanyData::latest()->first();
    $tableData = json_decode($tableDataJson, true);
    // ✅ Create Sale
    $sale = Sales::create([
        'total' => $total,
        'change' => $change,
        'amountPaid' => $amountPaid,
        'user_id' => $userId,
        'payment_method' => $paymentMethod
    ]);

    // ✅ Update Stock + Attach Products
    foreach ($tableData as $item) {
        $productId = $item['id'];
        $quantitySold = $item['quantity'];

        Stock::where('product_id', $productId)
            ->decrement('quantity', $quantitySold);

        $sale->products()->attach($productId, [
            'quantity' => $quantitySold
        ]);
    }

    // ✅ Prepare PDF Data
    $pdfData = [
        'sale' => $sale,
        'customer' => Customer::find($customerId),
        'items' => $tableData,
        'details' => $companyDetails,
        'amountPaid' => $amountPaid,
        'paymentMethod' => $paymentMethod
    ];
    // ✅ Generate PDF
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.salesInvoice', $pdfData);
    $directory = "C:/receipts";
    if (!is_dir($directory)) {
        mkdir($directory, 0777, true);
    }
    $receiptPath = $directory . "/ElectronReceipt_" . $sale->id . ".pdf";
    $pdf->save($receiptPath);
    try {
        // 🔥 Get configured printer
        $printerSettings = \App\Models\Printers::first();
        $printerName = $printerSettings ? trim($printerSettings->name) : null;
       
        if ($printerName) {
            // ✅ Connect to configured printer
            // if (preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $printerName)) {
            //     $connector = new \Mike42\Escpos\PrintConnectors\BluetoothPrintConnector($printerName);
            // } else {
            //     $connector = new \Mike42\Escpos\PrintConnectors\WindowsPrintConnector($printerName);
            // }

            $connector = new WindowsPrintConnector($printerName);
            $printer = new \Mike42\Escpos\Printer($connector);
            // 🧾 HEADER
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text(($companyDetails->name ?? "ELECTRON POS") . "\n");
            $printer->text("TIN: " . ($companyDetails->tinnumber ?? "N/A") . " VAT: " . ($companyDetails->vatnumber ?? "N/A") . "\n");
            $printer->text("Phone: " . ($companyDetails->phone_number ?? "N/A") . "\n");
            $printer->text("Email: " . ($companyDetails->email ?? "N/A") . "\n");
            $paymentMethodText = is_array($paymentMethod) ? collect($paymentMethod)->first() : $paymentMethod;
            $printer->text("Payment: " . ($paymentMethodText ?? 'Cash') . "\n");
            $printer->text("Invoice #: " . $sale->id . "\n");
            $printer->text("Date: " . date('d/m/y') . "\n");
            $printer->text("--------------------------------\n");
            // 🛒 ITEMS HEADER
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_LEFT);
            $printer->text(sprintf("%-16s %3s %9s\n", "Item", "Qty", "Price"));
            $printer->text("--------------------------------\n");
            foreach ($tableData as $item) {
                $price = $item['unitPrice'] ?? ($item['price'] ?? 0);
                $line = sprintf(
                    "%-16s %3d %9.2f\n",
                    substr($item['name'], 0, 16),
                    $item['quantity'],
                    $price
                );
                $printer->text($line);
            }
            $printer->text("--------------------------------\n");
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_RIGHT);
            $printer->text(sprintf("Total Ex VAT: %.2f\n", $total - ($total * 0.16)));
            $printer->text(sprintf("VAT (16%%): %.2f\n", $total * 0.16));
            $printer->text(sprintf("Sub Total: %.2f\n", $total));
            $printer->text(sprintf("Amount Paid: %.2f\n", $amountPaid));
            $printer->text(sprintf("Change: %.2f\n", $amountPaid - $total));
            $printer->text("--------------------------------\n");
            // 📌 FOOTER
            $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for shopping with us!\n");
            // ✂️ CUT
            $printer->cut();
            $printer->close();
        } else {
            \Log::error("No configured printer found.");
        }

    } catch (\Exception $e) {
        \Log::error('Printer error: ' . $e->getMessage());
    }
    return redirect()->back()->with('success', 'Sale Completed.');
    }

    // public function doTransaction(Request $request) {
    
    // $userId = Auth::user()->id;
    // $paymentMethod = $request->input("payment_method");
    // $total = $request->input('total');
    // $change = $request->input('change');
    // $amountPaid = $request->input('amountPaid');
    // $customerId = $request->input('customerId');
    // $tableDataJson = $request->input('table_data');
    // $companyDetails = CompanyData::latest()->first();
    // $tableData = json_decode($tableDataJson, true);

    // $sale = Sales::create([
    //     'total' => $total,
    //     'change' => $change,
    //     'amountPaid' => $amountPaid,
    //     'user_id' => $userId,
    //     'payment_method' => $paymentMethod
    // ]);

    // foreach ($tableData as $item) {
    //     $productId = $item['id'];
    //     $quantitySold = $item['quantity'];
    //     Stock::where('product_id', $productId)
    //         ->decrement('quantity', $quantitySold);
    //     $sale->products()->attach($productId, ['quantity' => $quantitySold]);
    // }

    // // Prepare data for PDF
    // $pdfData = [
    //     'sale' => $sale,
    //     'customer' => Customer::find($customerId),
    //     'items' => $tableData,
    //     'details' => $companyDetails,
    //     'amountPaid' => $amountPaid,
    //     'paymentMethod' => $paymentMethod
    // ];

    // // Generate PDF using Blade view
    // $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.salesInvoice', $pdfData);
    // // Save PDF to C:/receipts/ElectronReceipt_{sale_id}.pdf
    // $directory = "C:/receipts";
    // if (!is_dir($directory)) {
    //     mkdir($directory, 0777, true); // create directory if it doesn't exist
    // }
    // $receiptPath = $directory . "/ElectronReceipt_" . $sale->id . ".pdf";
    // $pdf->save($receiptPath);
    // // Direct print using Mike42/escpos-php
    // try {
    //     $printerSettings = \App\Models\Printers::first();
    //     if ($printerSettings) {
    //         $printerName = $printerSettings->name;
    //         // Check if name is a MAC address for direct Bluetooth connection
    //         if (preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $printerName)) {
    //             $connector = new \Mike42\Escpos\PrintConnectors\BluetoothPrintConnector($printerName);
    //         } else {
    //             $connector = new \Mike42\Escpos\PrintConnectors\WindowsPrintConnector($printerName);
    //         }
            
    //         $printer = new \Mike42\Escpos\Printer($connector);
            
    //         // Header
    //         $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
    //         $printer->text("Electron Point Of Sale\n");
    //         $printer->text("Receipt\n");
    //         $printer->text(date('Y-m-d H:i:s') . "\n\n");
            
    //         // Items
    //         $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_LEFT);
    //         foreach ($tableData as $item) {
    //             $line = sprintf("%-20s %d x $%.2f\n", substr($item['name'], 0, 20), $item['quantity'], $item['unitPrice'] ?? ($item['price'] ?? 0));
    //             $printer->text($line);
    //         }
    //         $printer->text("--------------------------------\n");
            
    //         // Totals
    //         $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_RIGHT);
    //         $printer->text(sprintf("Total: $%.2f\n", $total));
    //         $printer->text(sprintf("Paid: $%.2f\n", $amountPaid));
    //         $printer->text(sprintf("Change: $%.2f\n", $change));
    //         $printer->text("\n");
            
    //         // Footer
    //         $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
    //         $printer->text("Thank you for your business!\n");
            
    //         $printer->cut();
    //         $printer->close();
    //     }
    // } catch (\Exception $e) {
    //     \Illuminate\Support\Facades\Log::error('Printer error: ' . $e->getMessage());
    // }

    // return redirect()->back()->with('success', 'Sale Completed.');
    
    // }

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