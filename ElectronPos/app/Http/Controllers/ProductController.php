<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cattegory;
use App\Models\Supplier;
use App\Models\CompanyData;
use Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    //view all the products
    public function viewProducts()
    {
        
        $productCount = Product::all()->count();
        $products = Product::leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
        ->select('products.id', 'products.name','products.barcode','products.created_at','products.description','products.price','products.selling_price','products.unit_of_measurement', DB::raw('SUM(stocks.quantity) as total_stock_quantity'))
        ->groupBy('products.id', 'products.name','products.barcode','products.description','products.price','products.selling_price','products.unit_of_measurement','products.created_at')
        ->get();
        return view('pages.view-products')->with("products",$products)->with("productCount",$productCount);
    }

    //search by name on the cart
    public function searchByName($productName)
    {
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        return response()->json(['products' => $products]);
    }

    //search product on the cart on grv
    public function searchProduct($productName)
    {
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        return response()->json(['products' => $products]);
    }

    public function getProductsJson(){
       $products = DB::table('products')
        ->leftJoin('stocks', 'stocks.product_id', '=', 'products.id')
        ->select('products.id', 'products.name', 'products.price', DB::raw('SUM(stocks.quantity) as stock'))
        ->groupBy('products.id', 'products.name', 'products.price') // Include 'stock' in the GROUP BY
        ->get();
        return response()->json(["products" => $products]);
    }

    public function searchProducts($productName)
    {
        // Perform the product search based on the $productName
        $products = Product::where('name', 'like', '%' . $productName . '%')->get();
        // Return the products as JSON response
        return response()->json(["products" => $products]);
    }

    public function searchByCode($code)
    {
        // Perform the product search based on the $productName
        $products = Product::where('barcode', 'like', '%' . $code . '%')->get();
        // Return the products as JSON response
        return response()->json(["products" => $products]);
    }


    //function that will search the products    
    public function editProduct($id){ 
        $product = Product::find($id);
        $cattegories=Cattegory::all();
        $suppliers = Supplier::all();
        return view("pages.update-product")->with("product",$product)->with("cattegories",$cattegories)->with("suppliers",$suppliers);
    }

    
    public function getProductById($id){
        
        //get the prduct by the id
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function deleteProduct(Request $request, $id)
    {
    // Validate and sanitize the product ID
    $id = intval($id); // Ensure $id is an integer
    // Check if the product exists
    $product = Product::find($id);

    if (!$product) {
        // Product not found, return a 404 response or handle the error appropriately
        return response()->json(['error' => 'Product not found'], 404);
    }

    // Check if the user is authorized to delete the product (implement your authorization logic here)

    try {
        // Attempt to delete the product
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted Successfully');
    } catch (\Exception $e) {
        // Error occurred during deletion, handle the error gracefully
        return redirect()->back()->with('error', 'Product Not Deleted');
    }
}


    public function create()
    {
        //return the cattegories for the product to the view
        $cattegories = Cattegory::orderBy("id","desc")->get();
        $suppliers = Supplier::orderBy("id","desc")->get();
        $user = Auth::user();
        return view("pages.add-product")->with("cattegories",$cattegories)->with("user",$user)->with("suppliers",$suppliers);
    }

    /**
     * Store a newly created resource in storage.
     */
   
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

     public function salesInvoice(){
        $companyDetails = CompanyData::latest()->first();
        return view("pages.salesInvoice")->with("details",$companyDetails);
     }

     //create a new product and save it to the database
     public function store(Request $request)
     {
         $product = new Product();
         $product->name = $request->input("name");
         $product->barcode = $request->input("barcode");
         $product->description = $request->input("description");
         $product->price = $request->input("price");
         $product->selling_price = $request->input("selling_price");
         $product->unit_of_measurement = $request->input("unit_of_measurement");
         $product->category_id = $request->input("category_id");
         $product->tax = $request->input("tax");
         $product->save();   
         
         if ($product->save()) {
            return redirect()->back()->with('success', 'Product Added Successfully');
         } else {
             return redirect()->back()->with('error', 'Sorry, there was a problem while saving your product');
          }    
    }

    public function updateProduct(Request $request, Product $product)
    {
        $product->name = $request->name;
        $product->barcode = $request->barcode;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->selling_price = $request->selling_price;
        $product->unit_of_measurement = $request->unit_of_measurement;
        $product->category_id = $request->category_id;
        $product->tax = $request->input("tax");
    
        if ($request->has('category_id')) {
            $category = Cattegory::findOrFail($request->category_id);
            $product->category()->associate($category);
        }
    
        if (!$product->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'s a problem while updating the product.');
        }
        // Redirect to the 'view-products' route after successful update
        return redirect()->route('view-products')->with('success', 'Success, your product has been updated.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
