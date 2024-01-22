<?php

namespace App\Http\Controllers;

use App\Models\GRV;
use App\Models\Stock;
use Illuminate\Http\Request;

class GRVController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function submitGrv(Request $request)
    {
        
        $grv = new GRV(); // Use the GRV model
        $grv->supplier_id = $request->input('supplier_id');
        $grv->shop_id = $request->input('shop_id');
        $grv->grn_date = $request->input('grn_date');
        $grv->payment_method = $request->input('payment_method');
        $grv->additional_information = $request->input('additional_information');
        $grv->supplier_invoicenumber = $request->input('supplier_invoicenumber');
        $grv->additional_costs = $request->input('additional_costs');
        $grv->save();
        
        // Save the table data
        $tableData = $request->input('table_data');
        foreach ($tableData as $rowData) {
            $tableRow = new Stock(); // Use the Stock model
            $tableRow->product_name = $rowData['product_name'];
            $tableRow->measurement = $rowData['measurement'];
            $tableRow->quantity = $rowData['quantity'];
            $tableRow->unit_cost = $rowData['unit_cost'];
            $tableRow->total_cost = $rowData['total_cost'];
            $tableRow->grv_id = $grv->id; // Assuming you have a foreign key in the Stock model linking to the main GRV table
            $tableRow->save();
        }
        // Redirect or respond with success message
        return redirect()->route('/dashboard')->with('status', 'GRV submitted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(GRV $gRV)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GRV $gRV)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GRV $gRV)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GRV $gRV)
    {
        //
    }
}
