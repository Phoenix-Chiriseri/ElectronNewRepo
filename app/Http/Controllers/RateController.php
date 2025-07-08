<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Auth;

class RateController extends Controller
{
    
    //function that will show the rate on the front end
    public function index()
    {
        //extract the latest rate that has been set in the database
        $currentRate = Rate::latest()->first();
        //get the ratew from the currentRate object
        $rate = $currentRate["setRate"];
        return view("pages.add-rate")->with("rate",$rate);
    }

    public function getRate()
    {
        // Assuming you have a Rate model and you want to fetch the latest rate
        $rate = Rate::latest()->value('setRate');
        return response()->json(['rate' => $rate]);
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

        $userId = Auth::user()->id;
        $rate = new Rate();
        $rate->setRate = $request->input("rate");
        $rate->user_id = $userId;
        if (!$rate->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'s a problem while setting the rate.');
        }
        // Redirect to the 'view-products' route after successful update
        return redirect()->route('dashboard')->with('success', 'Success, your rate is set successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Rate $rate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rate $rate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rate $rate)
    {
        //
    }
}
