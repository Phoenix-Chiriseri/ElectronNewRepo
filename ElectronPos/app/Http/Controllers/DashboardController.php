<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Product;
use App\Models\Cattegory;
use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //return the welcome.blade view which is the main file
    public function welcome(){
        return view("welcome");
    }
    //return the numbefoproducts, number of customers and number of cattegories and all the users
    public function index()
    { 
        $topSellingProducts = DB::table('product_sale')
        ->select('products.name as product_name', 'product_sale.product_id', DB::raw('SUM(product_sale.quantity) as total_quantity_sold'))
        ->join('products', 'products.id', '=', 'product_sale.product_id')
        ->groupBy('product_sale.product_id', 'products.name')
        ->orderByDesc('total_quantity_sold')
        ->paginate(2);

        $topCustomers = DB::table('sales')
       ->select('customers.customer_name as customer_name', DB::raw('SUM(sales.total) as total_purchase'))
       ->join('customers', 'sales.customer_id', '=', 'customers.id')
        ->groupBy('sales.customer_id', 'customers.customer_name')
        ->orderByDesc('total_purchase')
        ->paginate(3); // You can adjust the number of items per page as needed


        $totalSales = Sale::sum('total');
        $numberOfProducts = Product::all()->count();
        $numberOfCustomers = Customer::all()->count();
        $numberOfCattegories = Cattegory::all()->count();
        $numberOfSuppliers = Supplier::all()->count(); 
        $users = User::all()->count();
        $user = Auth::user();
        return view('dashboard.index')->with("numberOfProducts",$numberOfProducts)
        ->with("users",$users)->with("numberOfCustomers",$numberOfCustomers)->with("numberOfCattegories",$numberOfCattegories)->with("numberOfSuppliers",$numberOfSuppliers)->with("user",$user)->with("topSellingProducts",$topSellingProducts)->with("totalSales",$totalSales)->with("topCustomers",$topCustomers);
    }
}
