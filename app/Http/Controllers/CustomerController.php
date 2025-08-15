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
        //returnb the citomer to the ront en
        $customers = Customer::leftJoin('users', 'customers.user_id', '=', 'users.id')
        ->select('users.name', 'customers.*')
        ->orderBy('customers.id', 'desc')
        ->paginate(5);
        $numberOfCustomers = Customer::all()->count();
        return view("pages.view-customers")->with("customers",$customers)->with("numberOfCustomers",$numberOfCustomers);
    }

    public function quoteCustomers(){

        $customers = Customer::orderBy("id","desc")->get();
        return view("pages.quote-customers")->with("customers",$customers);
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
            'customer_tinnumber' => $request->customer_tinnumber,
            'customer_vatnumber' => $request->customer_vatnumber,
            'customer_address' => $request->customer_address,
            'customer_phonenumber' => $request->customer_phonenumber,
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

        // Validate and sanitize the product ID
    $id = intval($id); // Ensure $id is an integer
    // Check if the product exists
    $customer = Customer::find($id);

    if (!$customer) {
        // Product not found, return a 404 response or handle the error appropriately
        return response()->json(['error' => 'Customer not found'], 404);
    }

    // Check if the user is authorized to delete the product (implement your authorization logic here)

    try {
        // Attempt to delete the product
        $customer->delete();
        return redirect()->back()->with('success', 'Customer Deleted Successfully');
    } catch (\Exception $e) {
        // Error occurred during deletion, handle the error gracefully
        return redirect()->back()->with('error', 'Customer Not Deleted');
    }
    
    }

    public function editCustomer($id){
        $customer = Customer::find($id);
        return view("pages.edit-customer")->with("customer",$customer);
    }

    public function updateCustomer(Request $request, Customer $customer)
    {
        $customer->customer_name = $request->customer_name;
        $customer->code = $request->code;
        $customer->customer_address = $request->customer_address;
        $customer->customer_phonenumber = $request->customer_phonenumber;
        $customer->customer_vatnumber = $request->customer_vatnumber;
        $customer->customer_tinnumber = $request->customer_tinnumber;
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
