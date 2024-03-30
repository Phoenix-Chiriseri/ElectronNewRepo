<?php

namespace App\Http\Controllers;

use App\Models\GRV;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use PDF;
use Auth;

class GRVController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createGRN(){
        
        //fetch the grvs and then return the data to the front end
        $grvs = GRV::leftJoin('suppliers', 'g_r_v_s.supplier_id', '=', 'suppliers.id')
        ->leftJoin('stocks', 'g_r_v_s.id', '=', 'stocks.grv_id')
        ->select('g_r_v_s.*', 'suppliers.supplier_name', 'stocks.product_name')
        ->distinct("g_r_v_s.id")
        ->orderBy("g_r_v_s.id", "desc")
        ->paginate(5);   
        //return the grvs to the front end and populate a table
        return view("pages.create-grn")->with("grvs",$grvs);
    }

    public function generateGrv(){
    {
        //load the pdf view....
        $pdf = PDF::loadView('pages.generate_grv');
        return $pdf->download('receipt.pdf');  
       
        }
    }

    public function viewById($id){

        $email = auth()->user()->email;
        $grv = GRV::leftJoin('suppliers', 'g_r_v_s.supplier_id', '=', 'suppliers.id')
        ->leftJoin('stocks', 'g_r_v_s.id', '=', 'stocks.grv_id')
        ->select('g_r_v_s.*', 'suppliers.supplier_name','suppliers.supplier_address','suppliers.supplier_phonenumber','suppliers.supplier_contactperson','suppliers.supplier_contactpersonnumber','suppliers.supplier_address')
        ->find($id);
        return view("pages.view-grv")->with("grv",$grv)->with("email",$email);
    }

     public function downloadPdf($id)
     {
        $grv = Grv::find($id);
        if (!$grv) {
            abort(404); // Or handle the case when the GRV is not found
        }
        // Fetch the user's email using the Auth facade
        $email = Auth::user()->email;
        // Generate PDF using Dompdf
        $pdf = PDF::loadView('pages.view-grv', ['grv' => $grv, 'email' => $email]);
        // Set the file name for the downloaded PDF
        $fileName = 'grv_' . $grv->id . '.pdf';
        // Stream the file to the browser with appropriate headers for download
        return $pdf->download($fileName);
     
     }
     
     //create the grv and all the details along with it
    public function submitGrv(Request $request)
    {
        $grv = new GRV(); // Use the GRV model
        //$grv->grvNumber = $this->generateGRNNumber();
        $grv->total = $request->input("total");
        $grv->supplier_id = $request->input('supplier_id');
        $grv->grn_date = $request->input('grn_date');
        $grv->payment_method = $request->input('payment_method');
        $grv->additional_information = $request->input('additional_information');
        $grv->supplier_invoicenumber = $request->input('supplier_invoicenumber');        
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
            // Find or create the product based on the product_name
            $product = Product::firstOrCreate(['name' => $rowData['product_name']]);
            $tableRow->product_id = $product->id;
            $tableRow->grv_id = $grv->id;
            $tableRow->save(); 
        }
        
        return redirect()->route('create-grn')->with("success","GRV Saved Successfully");
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
