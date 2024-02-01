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
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        //return the akes to the front end
        $sales = Sales::leftJoin('users', 'users.id', '=', 'sales.user_id')
        ->leftJoin('customers', 'sales.customer_id', '=', 'customers.id') // Corrected condition
        ->select(
            'sales.*',
            'users.*',
            'customers.*',
        )
        ->orderBy('sales.id', 'desc')
        ->paginate(5);
        return view("pages.view-sales")->with("sales",$sales);
    }

    public function finaliseSale(Request $request)
    {
        $customerId = $request->input('customer_id');
        $saleItemsJson = $request->input('sale_items');
        $saleItemsArray = json_decode($saleItemsJson, true); // Decode JSON string to array
        $token = $request->input('_token');
        $customerName = Customer::find($customerId)->customer_name;
        // Access the decoded saleItemsArray
        $saleItems = $saleItemsArray['saleItems'];
        $total = $saleItemsArray['total'];
        // Redirect to the confirmation-screen route with data
        return redirect()->route('confirmation-screen')->with([
            'customerName' => $customerName,
            'saleItems' => $saleItems,
            'total'=>$total
        ]);
    }

    public function confirmationScreen()
    {
        // Retrieve data from the session
        $customerId = session('customerId');
        $saleItems = session('saleItems');
        $customerName = session("customerName");
        $total = session("total");
        // Display a view with the data
        return view('pages.confirmation-screen', compact('customerId', 'saleItems','customerName','total'));
    }

    public function doTransaction(Request $request){
        $total = $request->input('total');
        $change = $request->input('change');
        $tableDataJson = $request->input('tableData');
        // Decode the JSON string into a PHP array
        $tableData = json_decode($tableDataJson, true);
        dd($tableData);
        return response()->json(['success' => true]);
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

            //return view("pages.choose_customer_view")->with("allCustomers",$customers);

            //Validate the incoming data
            /*$request->validate([
                'customerName' => 'required|string',
                'total' => 'required|numeric',
                'saleItems' => 'required|array',
                'saleItems.*.product_id' => 'required|exists:products,id',
                'saleItems.*.quantity' => 'required|integer|min:1',
            ]);*/
            
            //dd($request->all());

            //$id = Auth::user()->id;;
            // Create a new Sale instance
            /*$sale = new Sales();
            $sale->user_id = $id;
            $sale->customer_id = 1;
            $sale->total = $request->input('total');
            $sale->received_amount = $request->input("receivedAmount");
            $sale->change = $request->input("change");
            $sale->save();
            //saving the sale
            // Deduct items from stock
            foreach ($request->input('saleItems') as $item) {
                $product = Product::findOrFail($item['product_id']);
                $stock = Stock::where('product_id', $item['product_id'])->firstOrFail();
                // Check if there's enough stock before deducting
                if ($stock->quantity >= $item['quantity']) {
                    // Deduct stock
                    $stock->quantity -= $item['quantity'];
                    $stock->save();
                } else {
                    // Handle insufficient stock (you may throw an exception or return an error response)
                    //return response()->json(['error' => 'Insufficient Stock For Product ' . $product->name], 422);
                    return redirect()->back()->with('error', 'Insufficient Stock For Product ' . $product->name);
                }
                // Attach sale items to the sale
                /*$sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);*/
            // You can return a response as needed (e.g., success message or the created sale)
            //return redirect()->back()->with('message', 'Sale created successfully');
        

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