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
    //view the list of invoices
    public function viewInvoices()
    {
        //return the invoices to the front end
        $invoices = Invoice::whereNotNull('id')->orderBy('id', 'desc')->paginate(5);
        $numberOfInvoices = Invoice::count();
        return view('pages.view-invoices', ['invoices' => $invoices])->with("numberOfInvoices",$numberOfInvoices);
    }

    public function viewinvoiceById($id){

        $details = CompanyData::latest()->first();
        $invoice = Invoice::with('sale')->findOrFail($id);
        if ($invoice) {
            echo $invoice->html;
        }else{
            return view('pages.invoice-not-found');
        }
    }

    public function deleteInvoice($id){

        //dd($id);
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
