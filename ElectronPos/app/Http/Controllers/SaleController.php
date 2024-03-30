<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use App\Models\Stock;

class SaleController extends Controller
{
    
     public function index()
    {
        //return the akes to the front end
        $sales = Sales::leftJoin('customers', 'sales.customer_id', '=', 'customers.id')
        ->select(
        'sales.*',
        'customers.*',
        )
        ->orderBy('sales.id', 'desc')
        ->paginate(3);
        
        return view("pages.view-sales")->with("sales",$sales);
    }

    public function finaliseSale(Request $request)
    {
        $customerId = $request->input('customer_id');
        $saleItemsJson = $request->input('sale_items');
        $saleItemsArray = json_decode($saleItemsJson, true); // Decode JSON string to array
        $token = $request->input('_token');
        $customerName = Customer::find($customerId)->customer_name;
        //$customerId = Customer::find($customerId)->id;
        // Access the decoded saleItemsArray
        $saleItems = $saleItemsArray['saleItems'];
        $total = $saleItemsArray['total'];
        // Redirect to the confirmation-screen route with data
        return redirect()->route('confirmation-screen')->with([
            'customerName' => $customerName,
            'saleItems' => $saleItems,
            'total'=>$total,
            'customerId'=>$customerId
        ]);
    }

    public function confirmationScreen()
    {
       //Retrieve data from the session
        $customerId = session('customerId');
        $saleItems = session('saleItems');
        $customerName = session("customerName");
        $total = session("total");

        // Check if all required session data is available
        if (!$customerId || !$saleItems || !$customerName || !$total) {
        // Redirect or handle the case where session data is missing
        return view('pages.error-page');
        }
        
        // Display a view with the data
        return view('pages.confirmation-screen', compact('customerId', 'saleItems', 'customerName', 'total'));
    }

    public function doTransaction(Request $request){
    
    dd($request->all());

    $total = $request->input('total');
    $change = $request->input('change');
    $customerId = $request->input('customerId');
    $tableDataJson = $request->input('tableData');
    // Decode the JSON string into a PHP array
    $tableData = json_decode($tableDataJson, true);
    // Create a new sale record
    $sale = Sales::create([
        'customer_id' => $customerId, // Replace with the actual customer ID
        'total' => $total,
        'change' => $change,
    ]);
    
    //Iterate through each item in the sale and associate it with the sale record
    foreach ($tableData as $item) {
        $productId = $item['product_id'];
        $quantitySold = $item['quantity'];
        // Update the available quantity in the stocks table
        Stock::where('product_id', $productId)
            ->decrement('quantity', $quantitySold);
        // Associate the sold product with the sale
        $sale->products()->attach($productId, ['quantity' => $quantitySold]);
    }

    if ($sale->save()) {
        return redirect()->route('cart-index')->with('success', 'Sale Completed Successfully');
     } else {
         return redirect()->back()->with('error', 'Sorry, there was a problem doing the sale');
      }   
    
    }

    public function create()
    {
        //
    }

    
    public function store(Request $request) 
    {
    $saleItems = $request->all();
    $request->session()->put('saleItems', $saleItems);
    $customers = Customer::all();
    return redirect()->route('select-customer-view')->with("allCustomers", $customers);
}

    public function viewCustomerView()
{

    $name = Auth::user()->name;
    $saleItems = session('saleItems', []);
    $customers = Customer::orderBy("id", "desc")->get(); // Assuming you want to get the customers as a collection
    //Convert PHP variables to JSON
    $saleItemsJson = json_encode($saleItems);
    $customersJson = $customers->toJson();

    // Return the view with the JSON data
    return view('pages.choose_customer_view')->with([
        'name' => $name,
        'saleItemsJson' => $saleItemsJson,
        'customersJson' => $customersJson,
    ]);
}
        public function show(Sale $sale)
        {
            
            //
        
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}