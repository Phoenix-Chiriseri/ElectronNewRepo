<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Auth;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("pages.create-shop");
    }

    /**
     * Show the form for creating a new resource.
     */

     public function deleteShop(Request $request, $id)
     {
     // Validate and sanitize the product ID
     $id = intval($id); // Ensure $id is an integer
     // Check if the product exists
     $shop = Shop::find($id);
 
     if (!$shop) {
         // Product not found, return a 404 response or handle the error appropriately
         return response()->json(['error' => 'Shop not found'], 404);
     }
     try {
         // Attempt to delete the product
         $shop->delete();
         return redirect()->back()->with('success', 'Shop Deleted Successfully');
     } catch (\Exception $e) {
         // Error occurred during deletion, handle the error gracefully
         return redirect()->back()->with('error', 'Shop Not Deleted');
     }
 }

    public function viewShopList()
    {
        //return all the shops to the front end
        //$shops = Shop::orderBy("id", "desc")->paginate(10);
        $shops = Shop::leftJoin('users', 'shops.user_id', '=', 'users.id')
        ->select('users.*', 'shops.*')
        ->orderBy('shops.id', 'desc')
        ->paginate(10);
        $numberOfShops = Shop::all()->count();
        return view("pages.shop-list")->with("shops",$shops)->with("numberOfShops",$numberOfShops);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $userId = Auth::user()->id;
        //save the shop details
        $shop = Shop::create([
            'shop_name' => $request->shop_name,
            'email' => $request->shop_email,
            'user_id'=>$userId,
            'shop_address' => $request->shop_address,
            'phone_number' => $request->phonenumber,
            'shop_city' => $request->shop_city,
        ]);

        if(!$shop){

            return redirect()->back()->with('error', 'Sorry, there a problem while creating a shop.');

        }else{

            return redirect()->back()->with('success', 'Shop Created Successfully');

        }
       
        return redirect("/dashboard");
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        //
    }
}
