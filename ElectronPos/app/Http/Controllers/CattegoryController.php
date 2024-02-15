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
        $cattegories = Cattegory::orderBy("id", "desc")->paginate(5);
        $numberOfCattegories = Cattegory::all()->count();
        return view("pages.view-cattegories")->with("cattegories",$cattegories)->with("numberOfCattegories",$numberOfCattegories);
    }
    
     public function editGroup($id){

        $cattegory = Cattegory::find($id);
        return view("pages.edit-group")->with("cattegory",$cattegory);
     }


     public function deleteCattegory($id){

        $id = intval($id); // Ensure $id is an integer
    // Check if the product exists
    $cattegory = Cattegory::find($id);

    if (!$cattegory) {
        // Product not found, return a 404 response or handle the error appropriately
        return response()->json(['error' => 'Cattegory'], 404);
    }

    // Check if the user is authorized to delete the product (implement your authorization logic here)

    try {
        // Attempt to delete the product
        $cattegory->delete();
        return redirect()->back()->with('success', 'Cattegory Deleted Successfully');
    } catch (\Exception $e) {
        // Error occurred during deletion, handle the error gracefully
        return redirect()->back()->with('error', 'Cattegory Not Deleted');
    }
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
        return redirect()->back()->with('success', 'Cattegory Successfully Created');
      
        
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
