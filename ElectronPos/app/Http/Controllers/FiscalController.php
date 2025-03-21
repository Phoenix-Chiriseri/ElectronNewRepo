<?php

namespace App\Http\Controllers;

use App\Models\Fiscal;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use PDF;
use Auth;
use Illuminate\Support\Facades\DB;

class FiscalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function registerDevice()
    {
        //

        return view("pages.fiscal.registerDevice");

    }

    /**
     * Show the form for creating a new resource.
     */
    public function submitDevice(Request $request)
    {
        //

        dd($request->all());
        die;
        
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
    public function show(Fiscal $fiscal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fiscal $fiscal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fiscal $fiscal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fiscal $fiscal)
    {
        //
    }
}
