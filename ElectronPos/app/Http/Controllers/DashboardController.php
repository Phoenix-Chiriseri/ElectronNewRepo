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
        $numberOfProducts = Product::all()->count();
        $numberOfCustomers = Customer::all()->count();
        $numberOfCattegories = Cattegory::all()->count();
        $numberOfSuppliers = Supplier::all()->count();
        //$todaySales = Sale::whereDate('created_at', date('Y-m-d'))->count();
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
        ->with("users",$users)->with("numberOfCustomers",$numberOfCustomers)->with("numberOfCattegories",$numberOfCattegories)->with("numberOfSuppliers",$numberOfSuppliers)->with("user",$user)->with("monthlySales",$monthSales)->with("totalSalesPerDay",$totalSalesPerDay);
    }
}
