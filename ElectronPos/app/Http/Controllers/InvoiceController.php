<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\CompanyData;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewInvoices()
    {
        //
        $invoices = Invoice::whereNotNull('id')->orderBy('id', 'desc')->paginate(5);
        $numberOfInvoices = Invoice::count();
        return view('pages.view-invoices', ['invoices' => $invoices])->with("numberOfInvoices",$numberOfInvoices);
    }

    public function viewinvoiceById($id){

        $details = CompanyData::latest()->first();
        //$invoice = Invoice::findOrFail($id);
        //$invoice = Invoice::with('sale')->findOrFail($id);
        $invoice = Invoice::with('sale')->findOrFail($id);
        //dd($invoice);
        // Check if the invoice exists  
         if ($invoice) {
            echo $invoice->html;
         //$invoiceHtml = view('pages.invoice-view', [
         //'invoice' => $invoice,
         //'details' => $details,
        //])->render();
       // Render the view with the invoice and sale data
       //$invoiceHtml = View::make('pages.invoice_template', ['invoice' => $invoice])->render();
       //$invoiceHtml = view('pages.single-invoice', ['invoice' => $invoice])->render();
       // Now $invoiceHtml contains the rendered HTML for the invoice
       // You can then save the HTML to a file, return it as a response, or use it as needed    
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
