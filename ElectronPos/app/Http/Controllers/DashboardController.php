<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Cattegory;
use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\SetStockLevels;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //return the welcome.blade view which is the main file
    public function welcome(){
        return view("welcome");
    }

    //return the numbefoproducts, number of customers and number of cattegories and all the users
    public function index()
    { 
        
     // Get the current month
    $currentMonth = Carbon::now()->format('Y-m');
    $topSellingProducts = DB::table('sales')
    ->join('product_sale', 'sales.id', '=', 'product_sale.sales_id')
    ->join('products', 'product_sale.product_id', '=', 'products.id')
    ->select('products.name as product_name', 'product_sale.product_id', DB::raw('SUM(product_sale.quantity) as total_quantity_sold'))
    ->whereYear('sales.created_at', '=', Carbon::now()->year)
    ->whereMonth('sales.created_at', '=', Carbon::now()->month)
    ->groupBy('product_sale.product_id', 'products.name')
    ->orderByDesc('total_quantity_sold')
    ->paginate(10); // Set the number of records per page

        $topCustomers = DB::table('sales')
       ->select('customers.customer_name as customer_name', DB::raw('SUM(sales.total) as total_purchase'))
       ->join('customers', 'sales.customer_id', '=', 'customers.id')
        ->groupBy('sales.customer_id', 'customers.customer_name')
        ->orderByDesc('total_purchase')
        ->paginate(3); // You can adjust the number of items per page as needed

        //set the stock levels 
        $lowestStockLevel = SetStockLevels::latest()->first();
        // Validate $lowestStockLevel
        if (!$lowestStockLevel || !isset($lowestStockLevel['stock_levels']) || !is_numeric($lowestStockLevel['stock_levels'])) {
        //Handle invalid or missing lowest stock level
        return response()->json(['error' => 'Invalid or missing lowest stock level'], 400);
        //return view('dashboard.index')->with("message","the lowest stock level has not been set");
        }
        //this will test the levels of the stock and check what is the lowest value that is in the stock
        $intLevel = (int)$lowestStockLevel['stock_levels'];
        $lowestStockProducts = DB::table('stocks')
        ->leftJoin('products', 'stocks.product_id', '=', 'products.id')
        ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
        ->select('products.name as product_name', 'cattegories.cattegory_name', 'products.barcode as barcode', 'products.selling_price as selling_price', DB::raw('SUM(stocks.quantity) as total_quantity'))
        ->groupBy('products.name', 'products.barcode', 'products.selling_price', 'cattegories.cattegory_name')
        ->havingRaw("total_quantity <= $intLevel")
        ->orderBy('total_quantity')
        ->limit(5)
        ->get();

        //number of sales that have been done
        $numberOfSales = Sale::all()->count();
        //total sales in the database
        $totalSales = Sale::sum('total');
        $numberOfProducts = Product::all()->count();
        $numberOfCustomers = Customer::all()->count();
        $numberOfCattegories = Cattegory::all()->count();
        $numberOfSuppliers = Supplier::all()->count(); 
        $users = User::all()->count();
        //this is the authenticated user
        $user = Auth::user();
        return view('dashboard.index')->with("numberOfProducts",$numberOfProducts)
        ->with("users",$users)->with("numberOfCustomers",$numberOfCustomers)->with("numberOfCattegories",$numberOfCattegories)->with("numberOfSuppliers",$numberOfSuppliers)
        ->with("user",$user)->with("topSellingProducts",$topSellingProducts)
        ->with("totalSales",$totalSales)->with("topCustomers",$topCustomers)->with("numberOfSales",$numberOfSales)->with("lowestStockProducts",$lowestStockProducts)->with("stockLevel",$intLevel);
    }
}
