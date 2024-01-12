<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Customer;
use Auth;

class CartController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy("id","desc");
        $products = Product::all();
        return view('cart.index')->with("customers",$customers)->with("products",$products);
    }

    public function addToCart($cartId){
            // Get the authenticated user
   
           // Get the authenticated user
        $user = auth()->user();

        // Find or create the user's cart
        $userCart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if the product is already in the cart
        $cartItem = $userCart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // If the product is already in the cart, increment the quantity
            $cartItem->increment('quantity');
        } else {
            // If the product is not in the cart, create a new cart item
            $userCart->items()->create([
                'product_id' => $product->id,
                'quantity'   => 1, // Assuming the initial quantity is 1
            ]);
        }

        // Redirect back to the product page or any other page
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }
      
}

