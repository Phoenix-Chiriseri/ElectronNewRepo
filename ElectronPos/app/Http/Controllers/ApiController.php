<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rate;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Cattegory;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Stock;
use App\Models\GRV;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    //function for all products
    public function viewAllProducts(){
        $products=Product::orderBy('id','desc')->get();
        return response()->json(['products' => $products]);
    }

    public function showResult(){
        return view("pages.test");
    }
    //function for all top slling products
   public function topSellingProducts(){
    $topSellingProducts = DB::table('sales')
    ->join('product_sale', 'sales.id', '=', 'product_sale.sales_id')
    ->join('products', 'product_sale.product_id', '=', 'products.id')
    ->select('products.name as product_name', 'product_sale.product_id', DB::raw('SUM(product_sale.quantity) as total_quantity_sold'))
    ->whereYear('sales.created_at', '=', Carbon::now()->year)
    ->whereMonth('sales.created_at', '=', Carbon::now()->month)
    ->groupBy('product_sale.product_id', 'products.name')
    ->get(); // Execute the query to retrieve results
    // dd($topSellingProducts); // Uncomment this line if you want to debug with dd()
     return response()->json(['topSellingProducts' => $topSellingProducts]);
    }
    
    public function getStatistics()
    {
    $numberOfSales = Sale::count();
    $totalSales = Sale::sum('total');
    $numberOfProducts = Product::count();
    $numberOfCustomers = Customer::count();
    $numberOfCategories = Cattegory::count();
    $numberOfSuppliers = Supplier::count();
    $numberOfUsers = User::count();

    $statistics = [
        'numberOfSales' => $numberOfSales,
        'totalSales' => $totalSales,
        'numberOfProducts' => $numberOfProducts,
        'numberOfCustomers' => $numberOfCustomers,
        'numberOfCategories' => $numberOfCategories,
        'numberOfSuppliers' => $numberOfSuppliers,
        'numberOfUsers' => $numberOfUsers
    ];

    return response()->json($statistics);
    }


    //function that will return all the stock information
    public function getStockInformation()
    {
    
            $stocks = Stock::leftJoin('products', 'stocks.product_id', '=', 'products.id')
            ->leftJoin('cattegories', 'products.category_id', '=', 'cattegories.id')
            ->select('products.name as product_name', 'cattegories.cattegory_name','products.barcode as barcode', 'products.selling_price as selling_price', DB::raw('SUM(stocks.quantity) as total_quantity'))
            ->groupBy('products.name', 'products.barcode', 'products.selling_price','cattegories.cattegory_name')
            ->get();

    $totalValueOfStock = Stock::sum('total_cost');

    $responseData = [
        'stocks' => $stocks,
        'totalValueOfStock' => $totalValueOfStock
    ];

    return response()->json($responseData);
    }

    //function that will return all the customers
    public function getAllCustomers(){
        $customers=Customer::orderBy('id','desc')->get();
        return response()->json(['customers' => $customers]);
    }

    //function that will return all the suppliers
    public function getAllSuppliers(){
        $suppliers=Supplier::orderBy('id','desc')->get();
        return response()->json(['suppliers' => $suppliers]);
    }

    //function that will return all the grvs to the api
    public function getAllGRVS(){
        $grvs = GRV::orderBy("id","desc")->get();
        return response()->json(['grvs'=>$grvs]);
    }

    //function that will fetch all the employees
    public function getAllEmployees(){

        $employees = Employee::orderBy("id","desc")->get();
        return response()->json(['employees'=>$employees]);

    }

    public function getRate(){

        $rate = Rate::latest()->first();
        return response()->json(['rate'=>$rate]);
        
    }

    public function getTotalSales(){
        $totalSales = Sale::sum('total');
        return response()->json(['totalSales'=>$totalSales]);
    }
}
