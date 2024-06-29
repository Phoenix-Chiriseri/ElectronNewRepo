<?php

namespace App\Http\Controllers;

use App\Models\PaymentTypes;
use Illuminate\Http\Request;

class PaymentTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function addPaymentTypes()
    {
        //
        return view("pages.add-payment-types");
    }


    public function showPaymentTypes(){

        $numberOfPaymentTypes = PaymentTypes::all()->count();
        $paymentTypes = PaymentTypes::orderBy("id","desc")->paginate(5);
        return view("pages.view-payment-types")->with("paymentTypes",$paymentTypes)->with("numberOfPaymentTypes",$numberOfPaymentTypes);
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
        $paymentType = PaymentTypes::create([
            'payment_name' => $request->name,
        ]);
        if (!$paymentType) {
            return redirect()->back()->with('error', 'Sorry, there a problem while creating this payment type.');
        }
        return redirect()->back()->with('success', 'Payment Type Successfully Created');  
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentTypes $paymentTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentTypes $paymentTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentTypes $paymentTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentTypes $paymentTypes)
    {
        //
    }
}
