<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function viewSuppliers()
    {
        $suppliers = Supplier::leftJoin('users', 'suppliers.user_id', '=', 'users.id')
        ->select('users.name', 'suppliers.*')
        ->orderBy('suppliers.id', 'desc')
        ->get();
        //dd($suppliers);
        //return the number of suppliers to the suppliers view
        //$numberOfSuppliers = Supplier::all()->count();
         return view('pages.view-suppliers')->with("suppliers",$suppliers);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('pages.create-suppliers');
    }


    //delete the supplier from the database
    public function deleteSupplier($id){
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect('/view-suppliers');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dump the data and see if it sending to the controller
        $user = Auth::user()->id;
        $supplier = Supplier::create([
        'code' => $request->code,
        'supplier_name' => $request->supplier_name,
        'supplier_address' => $request->supplier_address,
        'supplier_phonenumber' => $request->supplier_phonenumber,
        'supplier_taxnumber' => $request->supplier_taxnumber,
        'supplier_city' => $request->supplier_city,
        'customer_address' => $request->supplier_address,
        'user_id' => $user,
        'supplier_status'=>$request->supplier_status
    ]);
    
    if (!$supplier) {
        return redirect()->back()->with('error', 'Sorry, there a problem while creating a supplier.');
    }
    return redirect()->route('view-suppliers')->with('success', 'Success, your supplier have been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editSupplier($id)
    {
        $supplier = Supplier::find($id);
        return view("pages.edit-supplier")->with("supplier",$supplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSupplier(Request $request, Supplier $supplier)
    {
        $supplier->supplier_name = $request->supplier_name;
        $supplier->code = $request->code;
        $supplier->supplier_taxnumber= $request->supplier_taxnumber;
        $supplier->supplier_city = $request->supplier_city;
        $supplier->supplier_address = $request->supplier_address;
        $supplier->supplier_phonenumber = $request->supplier_phonenumber;
        $supplier->supplier_status = $request->supplier_status;
       
        if (!$supplier->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating supplier.');
        }
        return redirect()->route('view-suppliers')->with('success', 'Success, your supplier have been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
