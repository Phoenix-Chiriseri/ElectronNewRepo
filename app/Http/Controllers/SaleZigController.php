<?php

namespace App\Http\Controllers;

use App\Models\SaleZig;
use App\Models\Stock;
use App\Models\CompanyData;
use App\Models\Customer;
use App\Models\InvoiceZig;
use Illuminate\Http\Request;
use Auth;

class SaleZigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    }

    public function doTransaction(Request $request) {

        $userId= Auth::user()->id;
        $total = $request->input('total');
        $change = $request->input('change');
        $amountPaid = $request->input("amountPaid");
        $customerId = $request->input('customerId');
        $tableDataJson = $request->input('table_data');
        $companyDetails = CompanyData::latest()->first();
    
        // Decode the JSON string into a PHP array
        $tableData = json_decode($tableDataJson, true);
    
        // Create a new sale record
        $saleZig = SaleZig::create([
            'total' => $total,
            'change' => $change,
            'amountPaid' => $amountPaid
        ]);
    
        // Iterate through each item in the sale and associate it with the sale record
        foreach ($tableData as $item) {
            $productId = $item['id'];
            $quantitySold = $item['quantity'];
    
            // Update the available quantity in the stocks table
            Stock::where('product_id', $productId)
                ->decrement('quantity', $quantitySold);
    
            // Associate the sold product with the sale
            $saleZig->products()->attach($productId, ['quantity' => $quantitySold]);
        }
    
        // Generate invoice HTML
        $invoiceHtml = view('pages.salesInvoice', [
            'sale' => $saleZig,
            'customer' => Customer::find($customerId), // Fetch the customer details
            'items' => $tableData // Pass the sold items for the invoice
        ])->with("details", $companyDetails)->with("amountPaid", $amountPaid)->render();
    
        // Save the invoice HTML
        $invoice = InvoiceZig::create([
            'html' => $invoiceHtml,
            'user_id'=>$userId
        ]);
    
        // Associate the invoice with the sale
        $saleZig->invoice_id = $invoice->id;
        $saleZig->save();
    
        // Direct print using Mike42/escpos-php
        try {
            $printerSettings = \App\Models\Printers::first();
            if ($printerSettings) {
                $printerName = $printerSettings->name;
                
                // Check if name is a MAC address for direct Bluetooth connection
                if (preg_match('/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/', $printerName)) {
                    $connector = new \Mike42\Escpos\PrintConnectors\BluetoothPrintConnector($printerName);
                } else {
                    $connector = new \Mike42\Escpos\PrintConnectors\WindowsPrintConnector($printerName);
                }
                
                $printer = new \Mike42\Escpos\Printer($connector);
                
                // Header
                $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
                $printer->text("Electron Point Of Sale\n");
                $printer->text("Receipt (ZIG)\n");
                $printer->text(date('Y-m-d H:i:s') . "\n\n");
                
                // Items
                $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_LEFT);
                foreach ($tableData as $item) {
                    $line = sprintf("%-20s %d x %.2f\n", substr($item['name'], 0, 20), $item['quantity'], $item['unitPrice'] ?? ($item['price'] ?? 0));
                    $printer->text($line);
                }
                $printer->text("--------------------------------\n");
                
                // Totals
                $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_RIGHT);
                $printer->text(sprintf("Total: ZIG %.2f\n", $total));
                $printer->text(sprintf("Paid: ZIG %.2f\n", $amountPaid));
                $printer->text(sprintf("Change: ZIG %.2f\n", $change));
                $printer->text("\n");
                
                // Footer
                $printer->setJustification(\Mike42\Escpos\Printer::JUSTIFY_CENTER);
                $printer->text("Thank you for your business!\n");
                
                $printer->cut();
                $printer->close();
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Printer error: ' . $e->getMessage());
        }
    
        // Return the view or redirect
        return redirect()->back()->with('success', 'Sale Completed.');
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
    public function show(SaleZig $saleZig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleZig $saleZig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleZig $saleZig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleZig $saleZig)
    {
        //
    }
}
