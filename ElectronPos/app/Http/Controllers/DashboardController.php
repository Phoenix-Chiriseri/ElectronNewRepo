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
        ->paginate(10); // You can adjust the number of items per page as needed

        $numberOfProducts = Product::all()->count();
        $numberOfCustomers = Customer::all()->count();
        $numberOfCattegories = Cattegory::all()->count();
        $numberOfSuppliers = Supplier::all()->count(); 
        
        //calculate the total sales per each and every day;
        $totalSalesPerDay = 0;
        $salesToday = Sale::select('total')->where('created_at', date('Y-m-d'))
            ->get();
        
        //add the number to the total amount and return to the blade view
        foreach ($salesToday as $sale) {
            $totalSalesPerDay += $sale->total;
        }
        $monthSales = Sale::whereMonth('created_at', date('m'))->count();
        $todayRevenue = Sale::whereDate('created_at', date('Y-m-d'))->sum('total');
        $monthRevenue = Sale::whereMonth('created_at', date('m'))->sum('total');
        $users = User::all()->count();
        $user = Auth::user();
        return view('dashboard.index')->with("numberOfProducts",$numberOfProducts)
        ->with("users",$users)->with("numberOfCustomers",$numberOfCustomers)->with("numberOfCattegories",$numberOfCattegories)->with("numberOfSuppliers",$numberOfSuppliers)->with("user",$user)->with("monthlySales",$monthSales)->with("totalSalesPerDay",$totalSalesPerDay)->with("topSellingProducts",$topSellingProducts);
    }
}
