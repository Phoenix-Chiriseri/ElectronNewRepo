<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\CreditNote;
use App\Models\CompanyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //view the list of invoices
    public function viewInvoices()
    {
        $invoices = Invoice::join('sales', 'sales.invoice_id', '=', 'invoices.id')
        ->select('invoices.id as invoice_id', 'invoices.*', 'sales.*') // Select all columns from both tables
        ->orderBy('invoices.id', 'desc')
        ->paginate(5);
        $numberOfInvoices = Invoice::all()->count();
        return view('pages.view-invoices', ['invoices' => $invoices])->with("numberOfInvoices",$numberOfInvoices);
    }

    public function viewinvoiceById($id){
        //view ithe company information
        $details = CompanyData::latest()->first();
        $invoice = Invoice::with('sale')->findOrFail($id);
        if ($invoice) {
            echo $invoice->html;
        }else{
            return view('pages.invoice-not-found');
        }
    }
    
    public function summariseInvoice($id)
    {
        $invoice = Invoice::with('sale')->findOrFail($id);
        $htmlContent = $invoice->html;
    
        $dompdf = new Dompdf();
        $dompdf->loadHtml($htmlContent);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $pdfOutput = $dompdf->output();
    
        $filename = 'invoice_' . $invoice->id . '.pdf';
        Storage::put('public/pdf/' . $filename, $pdfOutput);
    
        $pdfUrl = asset('storage/pdf/' . $filename);
    
        $apiKey = 'sec_CGaPUgYM5WTSQAaECiOPRF1VCRbIYUcd';
        $fileContent = file_get_contents($pdfUrl);
    
    
        $response = Http::withHeaders([
            'x-api-key' => $apiKey,
        ])->attach('file', $fileContent, basename($filename), ['Content-Type' => 'application/octet-stream'])
            ->post('https://api.chatpdf.com/v1/sources/add-file');
    
        if ($response->successful()) {
            $sourceId = $response->json()['sourceId'];
            
            $response = Http::withHeaders([
                'x-api-key' => $apiKey,
            ])->post('https://api.chatpdf.com/v1/chats/message', [
                'sourceId' => $sourceId,
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => 'summarise the pdf document',
                    ],
                ],
            ]);
    
            if ($response->successful()) {
                $out = $response->json()['content'];
                $out = json_decode($out, true);
                echo 'Result: ' . PHP_EOL;
                print_r($out);
            } else {
                echo 'Status: ' . $response->status() . PHP_EOL;
                echo 'Error: ' . $response->body() . PHP_EOL;
            }
        } else {
            echo 'Status: ' . $response->status() . PHP_EOL;
            echo 'Error: ' . $response->body() . PHP_EOL;
        }
    }
    

    public function deleteInvoice($id){
        //dd($id);
        $invoice = Invoice::with('sale')->findOrFail($id);
        // Check if the invoice exists
        if ($invoice) {
            // Create a credit note
            $creditNote = new CreditNote();
            $creditNote->invoice_id = $invoice->id;
            $creditNote->amount = $invoice->total_amount;
            // You may need to set additional fields based on your database schema and business logic
            $creditNote->save();
            // Deduct product quantities from stock
            foreach ($invoice->sale->products as $productSale) {
                $product = Product::findOrFail($productSale->product_id);
                $product->total_stock_quantity += $productSale->quantity; // Add the quantity back to stock
                $product->save();
            }
            // Update the invoice to mark it as credited
            $invoice->credited = true;
            $invoice->save();
            // Return a response or perform additional actions as needed
            return response()->json(['message' => 'Credit note created successfully'], 200);
        } else {
            // If the invoice is not found, return an error response or redirect to a relevant page
            return view('pages.invoice-not-found');
        }
      }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
