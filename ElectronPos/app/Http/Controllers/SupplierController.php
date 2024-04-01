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
        ->paginate(3);
        $numberOfSuppliers = Supplier::all()->count();
        return view('pages.view-suppliers')->with("suppliers",$suppliers)->with("numberOfSuppliers",$numberOfSuppliers);
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
        //dd($id);
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect('/view-suppliers');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       
        $userId = Auth::user()->id;
        $supplier = Supplier::create([
        'code' => $request->code,
        'supplier_name' => $request->supplier_name,
        'supplier_tinnumber'=>$request->supplier_tinnumber,
        'supplier_vatnumber'=>$request->supplier_vatnumber,
        'supplier_address' => $request->supplier_address,
        'supplier_phonenumber' => $request->supplier_phonenumber,
        'customer_address' => $request->supplier_address,
        'user_id' => $userId,
        'supplier_status'=>$request->supplier_status,
        'supplier_contactperson'=>$request->supplier_contactperson,
        'supplier_contactpersonnumber'=>$request->supplier_contactpersonnumber,
        'type'=>$request->supplier_type,
        
        ]);
    
         if ($supplier) {
          return redirect()->back()->with('success', 'Supplier created successfully');
        }else{

            return redirect()->back()->with('error', 'Supplier could not be created');
        }
        
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

        $supplier = Supplier::create([
            'code' => $request->code,
            'supplier_name' => $request->supplier_name,
            'supplier_tinnumber'=>$request->supplier_tinnumber,
            'supplier_vatnumber'=>$request->supplier_vatnumber,
            'supplier_address' => $request->supplier_address,
            'supplier_phonenumber' => $request->supplier_phonenumber,
            'customer_address' => $request->supplier_address,
            'user_id' => $userId,
            'supplier_status'=>$request->supplier_status,
            'supplier_contactperson'=>$request->supplier_contactperson,
            'supplier_contactpersonnumber'=>$request->supplier_contactpersonnumber,
            'type'=>$request->supplier_type,
            
            ]);

        $supplier->supplier_name = $request->supplier_name;
        //$supplier->code = $request->code;
        $supplier->supplier_tinnumber= $request->supplier_tinnumber;
        $supplier->supplier_taxnumber= $request->supplier_vatnumber;
        $supplier->supplier_address = $request->supplier_address;
        $supplier->supplier_phonenumber = $request->supplier_phonenumber;
        $supplier->supplier_status = $request->supplier_status;
        $supplier->supplier_contactperson = $request->supplier_contactperson;
        $supplier->supplier_contactpersonnumber = $request->supplier_contactpersonnumber;
       
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
