<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Shop;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $suppliers = Supplier::all();
        $shops = Shop::all();
        return view("pages.create-purchaseorder")->with("suppliers",$suppliers)->with("shops",$shops);
    }


    public function viewPurchasesOrders(){

        //$purchasesOrders = PurchaseOrder::all();
        return view("pages.view-purchaseorders");
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
        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->supplier_id = $request->input("supplier_id");
        $purchaseOrder->shop_id = $request->input("shop_id");
        $purchaseOrder->purchaseorder_date = $request->input("purchaseorder_date");
        $purchaseOrder->payment_method = $request->input("paayment_method");
        $purchaseOrder->expected_date = $request->input("expected_date");
        $purchaseOrder->delivery_instructions = $request->input("delivery_instructions");
        $purchaseOrder->supplier_invoicenumber = $request->input("supplier_invoicenumber");
        $purchaseOrder->save();
        
        // Save the purchases order items
        $tableData = $request->input('table_data');
        foreach ($tableData as $rowData) {
            $purchaseOrderItem = new PurchaseOrderItem($rowData);
            $purchaseOrderItem->purchase_order_id = $purchaseOrder->id;
            $purchaseOrderItem->save();
        }
        return redirect()->route('view-purchaseorders')->with('success', 'Purchase Order created successfully.');
  
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        //
    }
}
