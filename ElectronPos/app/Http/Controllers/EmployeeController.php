<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewEmployees()
    {
        //

        return view("pages.view-employees");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("pages.create-employee");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:manager,cashier',
            'access_level' => 'required|numeric',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ];

        // Validate the request
        $request->validate($rules);
        // Create a new user
        $employee = Employee::create([
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'access_level' => $request->input('acces_level'),
            'password' => Hash::make($request->input('password')),
            'confirm_password' => Hash::make($request->input('confirm_password')),
        ]);
        
        // Redirect back with a success message
        return redirect()->route('dashboard')->with('status', 'User created successfully.');
    } 
    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
