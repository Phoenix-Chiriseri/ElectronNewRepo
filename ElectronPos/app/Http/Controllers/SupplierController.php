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
         $suppliers = DB::table('suppliers')
         ->leftJoin('users', 'suppliers.user_id', '=', 'users.id')
         ->select('users.*','suppliers.*')
         ->get();
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
    ]);
    
    if (!$supplier) {
        return redirect()->back()->with('error', 'Sorry, there a problem while creating a supplier.');
    }
    return redirect()->route('dashboard')->with('success', 'Success, your supplier have been created.');
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
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
