<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Auth;
use App\Models\QuoteItem;
use App\Models\Customer;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //function that will display the quotations to the front end
    public function viewAllQuotations()
    {
         //quoatations, customers and the logged in user
          $quotations = Quote::leftJoin('customers', 'quotes.customer_id', '=', 'customers.id')
          ->leftJoin("users","quotes.user_id","=","users.id")
          ->select('quotes.*',"users.name as username","customers.customer_name")
          ->distinct('customers.id')
          ->orderBy('quotes.id', 'desc')
          ->paginate(5);
        $numberOfQuotes = Quote::all()->count();
        $totalQuotesValue = Quote::sum('total');
        return view("pages.view-quotations")->with("quotations",$quotations)->with("numberOfQuotes",$numberOfQuotes)->with("totalQuotesValue",$totalQuotesValue);
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
    
        $userId = Auth::user()->id;
        $quote = new Quote(); // Use the GRV model
        $quote->customer_id = $request->input("customer_id");
        $quote->user_id = $userId;
        $quote->quote_number = $request->input("quote_number");
        $quote->quote_date = $request->input("quote_date"); 
        $quote->total = $request->input("total");    
        $quote->save(); 
        // Save the purchases order items
        $tableData = $request->input('table_data');
        //dd($tableData);
        foreach ($tableData as $rowData) {    
            $quoteItem = new QuoteItem();
            $quoteItem->quote_item_id= $quote->id;
            $quoteItem->product_name = $rowData['product_name'];
            $quoteItem->measurement = $rowData['measurement'];
            $quoteItem->quantity = $rowData['quantity'];
            $quoteItem->unit_cost = $rowData['unit_cost'];
            $quoteItem->total_cost = $rowData['total_cost'];
            $quoteItem->save();
        }
        return redirect()->route('quote.show', $quote->id);
    }

    /**
     * Display the specified resource.
     */

    public function showSingleQuote($id){
        $email = auth()->user()->email;
        $quote = Quote::with(['quoteItems', 'customer'])
        ->find($id);
        $customerName = Customer::find($quote->customer_id)->customer_name;
        return view("pages.single-quote")->with("quote",$quote)->with("email",$email)->with("customer_name",$customerName);
    }

    public function show(Quote $quote)
    {
        //

        

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        //
    }
}
