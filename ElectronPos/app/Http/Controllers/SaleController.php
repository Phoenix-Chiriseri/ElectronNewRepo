<?php

namespace App\Http\Controllers;

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
        //
        $sales = Sale::orderBy('id','desc')->get();
        return view("pages.view-sales")->with("sales",$sales);
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
            //Validate the incoming data
            /*$request->validate([
                'customerName' => 'required|string',
                'total' => 'required|numeric',
                'saleItems' => 'required|array',
                'saleItems.*.product_id' => 'required|exists:products,id',
                'saleItems.*.quantity' => 'required|integer|min:1',
            ]);*/
            $id = Auth::user()->id;;
            // Create a new Sale instance
            $sale = new Sale();
            $sale->user_id = $id;
            $sale->customer_id = $request->input('customerName');
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
                    return response()->json(['error' => 'Insufficient stock for product ID ' . $product->id], 422);
                }
                // Attach sale items to the sale
                /*$sale->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);*/
            }
            // You can return a response as needed (e.g., success message or the created sale)
            return redirect()->back()->with('message', 'Sale created successfully');
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
