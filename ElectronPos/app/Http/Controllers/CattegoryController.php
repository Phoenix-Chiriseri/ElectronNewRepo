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
        //$cattegories = Cattegory::all();
        $cattegories = Cattegory::orderBy("id", "desc")->paginate(10);;
        $numberOfCattegories = Cattegory::all()->count();
        return view("pages.view-cattegories")->with("cattegories",$cattegories)->with("numberOfCattegories",$numberOfCattegories);
    }

    
     public function editGroup($id){

        $cattegory = Cattegory::find($id);
        return view("pages.edit-group")->with("cattegory",$cattegory);
     }


     public function deleteCattegory($id){

        $cattegory = Cattegory::find($id);
        $cattegory->delete();
        return redirect('/view-cattegories');
    }

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

    public function updateCattegory(Request $request, Cattegory $cattegory)
    {
        $cattegory->cattegory_name = $request->cattegory_name;
        if (!$cattegory->save()) {
            return redirect()->back()->with('error', 'Sorry, there\'re a problem while updating product.');
        }
        return redirect()->route('view-cattegories')->with('success', 'Success, your product have been updated.');
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
