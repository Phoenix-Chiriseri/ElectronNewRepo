<?php

namespace App\Http\Controllers;

use App\Models\PaymentTypes;
use Illuminate\Http\Request;
use Auth;

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
        //$paymentTypes = PaymentTypes::orderBy("id","desc")->paginate(5);
        $paymentTypes = PaymentTypes::all();
        return view("pages.view-payment-types")->with("paymentTypes",$paymentTypes)->with("numberOfPaymentTypes",$numberOfPaymentTypes);
    }
    /**
     * Show the form for creating a new resource.
     */

     public function editPaymentType($id){

        $paymentType = PaymentTypes::find($id);
        return view("pages.editPaymentTypes")->with("paymentType",$paymentType);
     }

     public function sendUpdate(Request $request, PaymentTypes $paymentType)
    {
        //dd($request->all());
        $paymentType->update([
            'payment_name' => $request->input('payment_type'),
        ]);
        if (!$paymentType->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while saving this payment type');
        }
        return redirect()->route('list-payment-types')->with('success', 'Your payment type has been updated');
    
    }


     //function that will delete the cattegory
     public function deletePaymentType($id){
        $id = intval($id); // Ensure $id is an integer
        //Check if the product exists
        $paymentType = PaymentTypes::find($id);
        if (!$paymentType) {
       // Product not found, return a 404 response or handle the error appropriately
       return response()->json(['error' => 'Payment Type'], 404);
       
       }
       //delete the cattegory
       try {
       // Attempt to delete the product
       $paymentType->delete();
       return redirect()->back()->with('success', 'Payment Type Deleted Successfully');
       } catch (\Exception $e) {
       // Error occurred during deletion, handle the error gracefully
       return redirect()->back()->with('error', 'Payment Type Not Deleted');
       }
   }


     



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
