<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $sale = Sale::create(
            [
                'total'   => $request->input('total'),
                'rfc'     => $request->input('rfc'),
                'id'      => $request->input('id'),
                'created' => date('Y-m-d')
            ]
        );

         if(isset($sale)) {
            $productsArray = (array)json_decode($request->input('products'));
            $completed = [];
            //Get the products sales
            foreach ($productsArray as $index) {
                $cart = new Cart();
                $cart->sale_id = $sale->sale_id;
                $cart->product_id = $index->id;
                $cart->amount = $index->amount;
                $cart->created = date('Y-m-d');
                $cart->save();
                $completed[] = $cart;
            }

            if (count($productsArray) === count($completed)) {
                return new Response($completed, 201);
            }
        }
        return new Response('Cart was not filled', 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
