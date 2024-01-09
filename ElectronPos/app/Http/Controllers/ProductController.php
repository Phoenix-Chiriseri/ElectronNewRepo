<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cattegory;
use Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    
    //view all the products
    public function viewProducts()
    {
        //$products = Product::orderBy("id", "asc")->get();
        /*$products = DB::table('cattegories')
        ->leftJoin('products', 'products.category_id', '=', 'cattegories.id')
        ->select('products.*','cattegories.cattegory_name')
        ->get();

        $productCount = DB::table('cattegories')
        ->leftJoin('products', 'products.category_id', '=', 'cattegories.id')
        ->select('*')
        ->count(); */
        $products = Product::orderBy("id", "asc")->get();
        $productCount = Product::all()->count();  
        return view('pages.view-products')->with("products",$products)->with("productCount",$productCount);
    }

    //function that will search the products
    public function searchProducts(Request $request){
       
        $searchTerm = $request->input('product_search');    
        $products = Product::where('name', 'like', "%$searchTerm%")->get(); 
        return response()->json(['products' => $products]);
        
    }

    
    public function editProduct($id){ 

        $product = Product::find($id);
        $cattegories=Cattegory::all();
        return view("pages.update-product")->with("product",$product)->with("cattegories",$cattegories);
    }

    public function getProductById($id){
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        }
        return response()->json(['error' => 'Product not found'], 404);
    }

    public function deleteProduct($id){

        $product = Product::find($id);
        $product->delete();
        return redirect('/view-products');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return the cattegories for the product to the view
        $cattegories = Cattegory::all();
        $user = Auth::user();
        return view("pages.add-product")->with("cattegories",$cattegories)->with("user",$user);
    }


    public function addToCart(Request $request,$productId){

    $product = Product::find($productId);

    if (!$product) {
        return redirect()->route('pages.sales.index')->with('error', 'Product not found.');
    }

    // Create or update the cart for the user (assuming user authentication)
    $userCart = Cart::firstOrNew(['user_id' => auth()->user()->id]);
    $cartItems = $userCart->items ?? [];

    // Check if the product is already in the cart
    $found = false;
    foreach ($cartItems as &$item) {
        if ($item['product_id'] == $product->id) {
            $item['quantity'] += 1; // Increment quantity
            $found = true;
        }
    }

    if (!$found) {
        // Add the product to the cart
        $cartItems[] = [
            'product_id' => $product->id,
            'quantity' => 1,
            'product' => $product,
        ];
    }

    $userCart->items = $cartItems;
    $userCart->save();

    return redirect()->route('pages.sales.create')->with('success', 'Product added to cart.');

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
         $product->product_status = $request->input("product_status");
         $product->save();   
         
         if ($product->save()) {
             return redirect()->route('view-products')->with('success', 'Success, your product has been created and added to stock');
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
        $product->product_status = $request->product_status;

        if (!$product->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating product.');
        }
        return redirect()->route('dashboard')->with('success', 'Success, your product have been updated.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
