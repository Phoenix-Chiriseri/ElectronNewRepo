<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use App\Mail\PurchaseOrderMail;

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

     public function viewById($id){
        $email = auth()->user()->email;
        $purchaseOrder = PurchaseOrder::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
        ->leftJoin('shops', 'purchase_orders.shop_id', '=', 'shops.id')
        ->select('purchase_orders.*', 'suppliers.supplier_name', 'shops.shop_name')
        ->find($id);  
        return view("pages.view-purchasesorder")->with("purchaseOrder",$purchaseOrder);
    }

    public function store(Request $request)
    {
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
            'table_data.*.measurement' => 'required|string',]);
            
            try {
            $purchaseOrder = new PurchaseOrder();
            $purchaseOrder->supplier_id = $request->input("supplier_id");
            $purchaseOrder->purchaseorder_date = $request->input("purchaseorder_date");
            $purchaseOrder->expected_date = $request->input("expected_date");
            $purchaseOrder->delivery_instructions = $request->input("delivery_instructions");
            $purchaseOrder->supplier_invoicenumber = $request->input("supplier_invoicenumber");
            $purchaseOrder->payment_method = $request->input("payment_method");
            $purchaseOrder->total = $request->input("total");
            $purchaseOrder->status = "pending";
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
            $purchaseOrderEmail = env('PURCHASE_ORDER_EMAIL', config('mail.from.address', 'noreply@example.com'));
            $purchaseOrder = PurchaseOrder::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
                ->select('purchase_orders.*', 'suppliers.supplier_name')
                ->with(['purchaseOrderItems'])
                ->findOrFail($id);
            
            return view("pages.single-purchaseorder")
                ->with("purchaseOrder", $purchaseOrder)
                ->with("email", $email)
                ->with("purchaseOrderEmail", $purchaseOrderEmail);
                
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
     * Email purchase order to specified address
     */
    public function emailPurchaseOrder(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string|max:1000'
        ]);

        try {
            $purchaseOrder = PurchaseOrder::leftJoin('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
                ->select('purchase_orders.*', 'suppliers.supplier_name')
                ->with(['purchaseOrderItems'])
                ->findOrFail($id);
            
            $email = auth()->user()->email;
            $userMessage = $request->input('message', '');
            
            // Check if mail is configured for actual sending
            $mailDriver = config('mail.default');
            
            if ($mailDriver === 'log') {
                // Log the email instead of sending it
                \Log::info('Purchase Order Email (Development Mode)', [
                    'to' => $request->email,
                    'purchase_order_id' => $purchaseOrder->id,
                    'message' => $userMessage,
                    'sent_by' => $email
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Email logged successfully! (Development mode - check storage/logs/laravel.log)',
                    'dev_mode' => true
                ]);
            }
            
            try {
                Mail::to($request->email)->send(new PurchaseOrderMail($purchaseOrder, $email, $userMessage));

                return response()->json([
                    'success' => true,
                    'message' => 'Purchase order email sent successfully!'
                ]);
                
            } catch (\Swift_TransportException $e) {
                // Handle SMTP connection/authentication errors
                \Log::error('Email SMTP Error: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'SMTP configuration error. Please check your email settings or contact your administrator.',
                    'error_type' => 'smtp_config'
                ], 500);
                
            } catch (\Exception $e) {
                // Handle other email-related errors
                \Log::error('Email sending error: ' . $e->getMessage());
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send email: ' . $e->getMessage(),
                    'error_type' => 'general'
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Purchase Order Email Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to process email request: ' . $e->getMessage()
            ], 500);
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
