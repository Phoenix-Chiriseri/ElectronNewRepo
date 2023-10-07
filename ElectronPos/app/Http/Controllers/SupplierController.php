<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
         //return all the suppliers to the view suppliers blade file
         $suppliers = Supplier::orderBy("id", "asc")->get();
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
        //dum the data and see if it sending to the controller
        dd($request->all());
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
