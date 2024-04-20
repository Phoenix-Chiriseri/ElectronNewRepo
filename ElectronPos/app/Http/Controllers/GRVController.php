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
use Illuminate\Support\Facades\DB;

class GRVController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function createGRN(){
        //managed to fix error for the grvs where it was pulling double records
        $grvs = GRV::leftJoin('suppliers', 'g_r_v_s.supplier_id', '=', 'suppliers.id')
        ->leftJoin('stocks', function ($join) {
        $join->on('g_r_v_s.id', '=', 'stocks.grv_id')
             ->where('stocks.id', '=', DB::raw('(SELECT MAX(id) FROM stocks WHERE stocks.grv_id = g_r_v_s.id)'));
         })
         ->select('g_r_v_s.*', 'suppliers.supplier_name', 'stocks.product_name')
        ->distinct('g_r_v_s.id')
        ->orderBy('g_r_v_s.id', 'desc')
        ->paginate(5);
        $numberOfGrvs = GRV::all()->count();
        //return the grvs to the front end and populate a table
        return view("pages.create-grn")->with("grvs",$grvs)->with("numberOfGrvs",$numberOfGrvs);
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


    

    public function updateById($id)
    {
    
        //$grv = GRV::find($id);
        $suppliers = Supplier::orderBy("id","desc")->get();
        $grv = GRV::with('stocks')->findOrFail($id);
        $stocks = $grv->stocks;
        return view("pages.update-grv")->with("grv",$grv)->with("suppliers",$suppliers)->with("stocks",$stocks);

    }

    public function sendUpdate(Request $request, $id)
    {

        //dd($request->all());
        // Validate the form data
        $validatedData = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'grn_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,credit',
            'additional_information' => 'required|string',
            'supplier_invoicenumber' => 'required|string',
            // Add validation rules for table_data if necessary
        ]);
        // Find the GRV by ID
        $grv = GRV::findOrFail($id);
        $tableData = json_decode($request->input('table_data'), true);
        // Update the GRV with the validated data
        $grv->update([
            'supplier_id' => $validatedData['supplier_id'],
            'grn_date' => $validatedData['grn_date'],
            'payment_method' => $validatedData['payment_method'],
            'additional_information' => $validatedData['additional_information'],
            'supplier_invoicenumber' => $validatedData['supplier_invoicenumber'],
        ]);

        foreach ($tableData as $data) {
            // Retrieve the associated stock record based on the product name and the GRV ID
            $stock = Stock::where('product_name', $data['product_name'])
                          ->where('grv_id', $grv->id)
                          ->first();

            dd($stock);
        
            if ($stock) {
                // Update existing stock
                $stock->quantity += $data['quantity'];
                $stock->unit_cost = $data['unit_cost'];
                $stock->total_cost += $data['total_cost'];
                $stock->save();
            } else {
                // Create new stock if it doesn't exist
                Stock::create([
                    'grv_id' => $grv->id, // Assuming 'grv_id' is the foreign key linking Stock to GRV
                    'product_name' => $data['product_name'],
                    'measurement' => $data['measurement'],
                    'quantity' => $data['quantity'],
                    'unit_cost' => $data['unit_cost'],
                    'total_cost' => $data['total_cost'],
                ]);
            }
        }    
        return redirect()->route('create-grn')->with("success","GRV Updated Successfully");
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
