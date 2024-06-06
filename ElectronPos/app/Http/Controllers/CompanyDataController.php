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
        $companyDetails = new CompanyData();
        $companyDetails->user_id = $id;
        $companyDetails->name = $request->input("name");
        $companyDetails->bank_details = $request->input("bank_details");
        $companyDetails->bank_account_number = $request->input("bank_account_number");
        $companyDetails->tinnumber = $request->input('tinnumber');
        $companyDetails->vatnumber = $request->input('vatnumber');
        $companyDetails->shop_address = $request->input('shop_address');
        $companyDetails->phone_number = $request->input('phone_number');
        $companyDetails->email = $request->input('email');
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
