<?php

namespace App\Http\Controllers;

use App\Models\SetStockLevels;
use Illuminate\Http\Request;

class SetStockLevelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lowestStockLevel = SetStockLevels::latest()->first();
        $intLevel=$lowestStockLevel['stock_levels'];
        if(!$intLevel){
            $message = "No Value Set In The System";
            return view("pages.set-stock-levels")->with("message",$message);
        }
        return view("pages.set-stock-levels")->with("stockLevel",$intLevel);
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
        $stockLevel = SetStockLevels::create([
            'stock_levels' => $request->stock_level,
        ]);
        
        if (!$stockLevel) {
            return redirect()->back()->with('error', 'Sorry, there a problem while saving value');
        }
        return redirect()->back()->with('success', 'Value Successfully Set');
    }
    /**
     * Display the specified resource.
     */
    public function show(SetStockLevels $setStockLevels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SetStockLevels $setStockLevels)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SetStockLevels $setStockLevels)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SetStockLevels $setStockLevels)
    {
        //
    }
}
