<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewAllCustomers()
    {
        //return the customers to the front end

        $customers = Customer::leftJoin('users', 'customers.user_id', '=', 'users.id')
        ->select('users.name', 'customers.*')
        ->orderBy('customers.id', 'desc')
        ->get();
        $numberOfCustomers = Customer::all()->count();
        return view("pages.view-customers")->with("customers",$customers)->with("numberOfCustomers",$numberOfCustomers);
    }

   public function searchCustomers(Request $request)
{
    // Your search logic here
    $searchQuery = $request->input('search');
    $customers = Customer::where('customer_name', 'like', '%' . $searchQuery . '%')->get();

    // Return the search results as JSON
    return response()->json(['customers' => $customers]);
}
    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view("pages.create-customer");
    }

    
    //save a customer to the database
    public function store(Request $request)
    {    

            $user = Auth::user()->id;
            $customer = Customer::create([
            'code' => $request->code,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_phonenumber' => $request->customer_phonenumber,
            'customer_taxnumber' => $request->customer_taxnumber,
            'customer_city' => $request->customer_city,
            'customer_address' => $request->customer_address,
            'user_id' => $user,
            'customer_status' =>$request->customer_status
        ]);
        
        if (!$customer) {
            return redirect()->back()->with('error', 'Sorry, there a problem while creating a customer.');
        }
        return redirect()->back()->with('success', 'Customer Created Successfully');
        //return redirect()->route('view-customers')->with('success', 'Success, you customer have been created.');
    }

    public function deleteCustomer($id){

        $customer = Customer::find($id);
        $customer->delete();
        return redirect('view-customers');
    
    }


    public function editCustomer($id){
        $customer = Customer::find($id);
        return view("pages.edit-customer")->with("customer",$customer);
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        $customer->customer_name = $request->customer_name;
        $customer->code = $request->code;
        $customer->customer_taxnumber= $request->customer_taxnumber;
        $customer->customer_city = $request->customer_city;
        $customer->customer_address = $request->customer_address;
        $customer->customer_phonenumber = $request->customer_phonenumber;
        $customer->customer_status = $request->customer_status;
       
        if (!$customer->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating customer.');
        }
        return redirect()->route('view-customers')->with('success', 'Success, your supplier have been customer.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }
    /*
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
