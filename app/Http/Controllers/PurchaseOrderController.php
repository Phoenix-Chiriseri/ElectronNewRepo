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
        //get the suppliers and the shops and then return it to the front end
        $suppliers = Supplier::all();
        $shops = Shop::all();
        return view("pages.create-purchaseorder")->with("suppliers",$suppliers)->with("shops",$shops);
    }


    public function viewPurchasesOrders(){

        //get the purchase orders and the count of the purchase orders and return it to the front end
        $purchaseOrders = PurchaseOrder::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->select('purchase_orders.*', 'suppliers.supplier_name')
        ->orderBy("purchase_orders.id", "desc")
        ->paginate(10);

        $numberOfPurchaseOrders = PurchaseOrder::count();
        
        return view("pages.view-purchaseorders")
            ->with("purchaseOrders", $purchaseOrders)
            ->with("numberOfPurchaseOrders", $numberOfPurchaseOrders);
    }
    
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
        return view("pages.view-purchasesorder")->with("purchaseOrder",$purchaseOrder);
        // Use find directly to fetch a single record by ID
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchaseorder_date' => 'required|date',
            'expected_date' => 'required|date|after_or_equal:purchaseorder_date',
            'payment_method' => 'required|string',
            'total' => 'required|numeric|min:0',
            'table_data' => 'required|array|min:1',
            'table_data.*.product_name' => 'required|string',
            'table_data.*.quantity' => 'required|numeric|min:1',
            'table_data.*.unit_cost' => 'required|numeric|min:0',
        ]);

        try {
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->supplier_id = $request->input("supplier_id");
            $purchaseOrder->purchaseorder_date = $request->input("purchaseorder_date");
            $purchaseOrder->expected_date = $request->input("expected_date");
            $purchaseOrder->delivery_instructions = $request->input("delivery_instructions");
            $purchaseOrder->supplier_invoicenumber = $request->input("supplier_invoicenumber");
            $purchaseOrder->payment_method = $request->input("payment_method");
            $purchaseOrder->total = $request->input("total");
            $purchaseOrder->status = 'pending'; // Set default status
            $purchaseOrder->save();
            
            // Save the purchases order items
            $tableData = $request->input('table_data');
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

            return redirect()->route('purchase-order.show', $purchaseOrder->id)
                ->with('success', 'Purchase Order created successfully!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating purchase order: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showSinglePurchaseOrder($id){
        try {
            $email = auth()->user()->email;
            $purchaseOrder = PurchaseOrder::with(['purchaseOrderItems', 'supplier'])
                ->findOrFail($id);
            
            return view("pages.single-purchaseorder")
                ->with("purchaseOrder", $purchaseOrder)
                ->with("email", $email);
                
        } catch (\Exception $e) {
            return redirect()->route('view-purchaseorders')
                ->with('error', 'Purchase Order not found.');
        }
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
        try {
            // Only allow deletion if status is pending
            if ($purchaseOrder->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Cannot delete a purchase order that is not pending.');
            }

            $purchaseOrder->delete();
            return redirect()->route('view-purchaseorders')
                ->with('success', 'Purchase Order deleted successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting purchase order.');
        }
    }

    /**
     * Update purchase order status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,received,cancelled'
        ]);

        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->status = $request->status;
            $purchaseOrder->save();

            return redirect()->back()
                ->with('success', 'Purchase Order status updated successfully.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating purchase order status.');
        }
    }
}
