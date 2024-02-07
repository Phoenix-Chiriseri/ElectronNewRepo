<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Session;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $suppliers = Supplier::all();
        $shops = Shop::all();
        return view("pages.create-purchaseorder")->with("suppliers",$suppliers)->with("shops",$shops);
    }


    public function viewPurchasesOrders(){

        $purchaseOrders = PurchaseOrder::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->leftJoin('shops', 'purchase_orders.shop_id', '=', 'shops.id')
        ->select('purchase_orders.*', 'suppliers.supplier_name', 'shops.shop_name')
        ->distinct("purchase_orders.id")
        ->orderBy("purchase_orders.id", "desc")
        ->paginate(3);

        $numberOfPurchaseOrders = PurchaseOrder::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->leftJoin('shops', 'purchase_orders.shop_id', '=', 'shops.id')
        ->select('purchase_orders.*', 'suppliers.supplier_name', 'shops.shop_name')
        ->distinct("purchase_orders.id")
        ->orderBy("purchase_orders.id", "asc")
        ->count();

      //dd($purchaseOrders);
        return view("pages.view-purchaseorders")->with("purchaseOrders",$purchaseOrders)->with("numberOfPurchaseOrders",$numberOfPurchaseOrders);
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
     public function viewById($id){
        $email = auth()->user()->email;
        $purchaseOrder = PurchaseOrder::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->leftJoin('shops', 'purchase_orders.shop_id', '=', 'shops.id')
        ->select('purchase_orders.*', 'suppliers.supplier_name', 'shops.shop_name')
        ->find($id);  
        //dd($purchaseOrder);
        return view("pages.view-purchasesorder")->with("purchaseOrder",$purchaseOrder);
        // Use find directly to fetch a single record by ID
    }

    public function store(Request $request)
    {

        $purchaseOrder = new PurchaseOrder();
        $purchaseOrder->po_number = $this->generatePONumber();
        $purchaseOrder->supplier_id = $request->input("supplier_id");
        $purchaseOrder->shop_id = $request->input("shop_id");
        $purchaseOrder->purchaseorder_date = $request->input("purchaseorder_date");
        $purchaseOrder->expected_date = $request->input("expected_date");
        $purchaseOrder->delivery_instructions = $request->input("delivery_instructions");
        $purchaseOrder->supplier_invoicenumber = $request->input("supplier_invoicenumber");
        $purchaseOrder->payment_method = $request->input("payment_method");
        $purchaseOrder->total = $request->input("total");
        $purchaseOrder->save();
        
        // Save the purchases order items
        $tableData = $request->input('table_data');
        //dd($tableData);
        foreach ($tableData as $rowData) {
            
            $purchaseOrderItem = new PurchaseOrderItem();
            $purchaseOrderItem->purchase_order_id = $purchaseOrder->id;
            $purchaseOrderItem->product_name = $rowData['product_name'];
            $purchaseOrderItem->measurement = $rowData['measurement'];
            $purchaseOrderItem->quantity = $rowData['quantity'];
            $purchaseOrderItem->unit_cost = $rowData['unit_cost'];
            $purchaseOrderItem->total_cost = $rowData['total_cost'];
            $purchaseOrderItem->save();
        }

    
        return redirect()->route('purchase-order.show', $purchaseOrder->id);
    }

    public function showSinglePurchaseOrder($id){
        //$purchaseOrder = PurchaseOrder::findOrFail($id);
        $email = auth()->user()->email;
        /*$purchaseOrder = PurchaseOrder::with(['purchaseOrderItems', 'supplier', 'shop'])
        ->leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->leftJoin('shops', 'purchase_orders.shop_id', '=', 'shops.id')
        ->find($id);*/
        $purchaseOrder = PurchaseOrder::with(['purchaseOrderItems', 'supplier', 'shop'])
        ->find($id);
        //dd($purchaseOrder);
        return view("pages.single-purchaseorder")->with("purchaseOrder",$purchaseOrder)->with("email",$email);
    }

    public function generatePONumber()
    
    {
    // Check if the counter is already set in the session, if not, initialize it
    if (!Session::has('po_counter')) {
        Session::put('po_counter', 1);
    } else {
        // Increment the counter
        Session::put('po_counter', Session::get('po_counter') + 1);
    }
    // Format the counter with leading zeros
    $formattedCounter = str_pad(Session::get('po_number'), 4, '0', STR_PAD_LEFT);
    // Concatenate the parts to create the GRN number
    $poNumber = 'PO -' . $formattedCounter;
    return $poNumber;

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
