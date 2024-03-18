<?php

namespace App\Http\Controllers;

use App\Models\CompanyData;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class CompanyDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view("pages.add-company");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function viewDetails()
    {
        //
        
        $companyDetails = CompanyData::latest()->first();
        // Assuming you have a relationship between CompanyData and User
        // For example, if CompanyData belongs to User
        $user = $companyDetails->user;
        // Alternatively, if User has created multiple CompanyData records and you want to fetch the user who created the latest record:
        $user = User::find($companyDetails->user_id);
        return view("pages.view-companydetails")->with("details",$companyDetails)->with("user",$user);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $id = Auth::user()->id;

        // Validate the form data
        $validatedData = $request->validate([
            'shop_name' => 'required|string|max:255',
            'tax_number' => 'required|string|max:255',
            'shop_address' => 'required|string|max:255',
            'shop_city' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        // Process the form submission, e.g., save to database
        // Assuming you have a CompanyDetails model
        $companyDetails = new CompanyData();
        $companyDetails->user_id = $id;
        $companyDetails->shop_name = $validatedData['shop_name'];
        $companyDetails->tax_number = $validatedData['tax_number'];
        $companyDetails->shop_address = $validatedData['shop_address'];
        $companyDetails->shop_city = $validatedData['shop_city'];
        $companyDetails->phone_number = $validatedData['phone_number'];
        $companyDetails->email = $validatedData['email'];
        $companyDetails->save();

        if ($companyDetails) {
            return redirect()->back()->with('success', 'Company Details Saved');
        }
        
        return redirect()->back()->with('error', 'Error Saving Details');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyData $companyData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyData $companyData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyData $companyData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyData $companyData)
    {
        //
    }
}
