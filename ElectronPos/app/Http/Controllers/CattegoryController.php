<?php

namespace App\Http\Controllers;

use App\Models\Cattegory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use Illuminate\Support\Facades\DB;

class CattegoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewCattegories()
    {
        $cattegories = Cattegory::all();
        //$cattegories = DB::table('cattegories')
        //>leftJoin('products', 'cattegories.id', '=', 'products.category_id')
        //->leftJoin('users','products.user_id','=','users.id')
        //->select('cattegories.cattegory_name as catname','users.name as username')
        //->get();
        return view("pages.view-cattegories")->with("cattegories",$cattegories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view("pages.add-cattegory");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //store the cattegory name
        $cattegory = Cattegory::create([
            'cattegory_name' => $request->name,
        ]);
        if (!$cattegory) {
            return redirect()->back()->with('error', 'Sorry, there a problem while creating product.');
        }
        return redirect()->route('dashboard')->with('success', 'Success, you cattegory have been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cattegory $cattegory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cattegory $cattegory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cattegory $cattegory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cattegory $cattegory)
    {
        //
    }
}
