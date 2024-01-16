<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Customer;
use Auth;
use App\Models\Stock;

class CartController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy("id", "desc")->get(); // Retrieve customers
        $products = Product::all(); // Retrieve products
        // Assuming you have some logic to prepare the $state variable
        // Pass the variables to the view
        return view('cart.index', compact('customers', 'products'));
    
    }

    public function addToCart(Product $product)
    {
    //Retrieve the current stock quantity
    $stock = Stock::where('product_id', $product->id)->first();
    dd($stock);

    if (!$stock || $stock->quantity <= 0) {
    return response()->json(['error' => 'Product is out of stock.']);
    
    }

    //Check if the requested quantity is available in stock
    //$requestedQuantity = $request->input('quantity', 1);
    //if ($requestedQuantity > $stock->quantity) {
    // return response()->json(['error' => 'Not enough stock available.']);/
    //}
    // Add the product to the cart
    $user = Auth::user();
    Cart::create([
    'user_id' => $user->id,
    'name' => $product->name,
    'price' => $product->price,
    'quantity' => $stock->quantity,
    'attributes' => [], // You can add additional attributes if needed
    ]);

// Update the stock quantity
//$newStockQuantity = $stock->quantity - $requestedQuantity;
//$stock->update(['quantity' => $newStockQuantity]);

return response()->json(['message' => 'Product added to cart successfully']);
    }
}

