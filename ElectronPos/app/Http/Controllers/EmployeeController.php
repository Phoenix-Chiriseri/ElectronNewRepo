<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewEmployees()
    {
        $employees = Employee::leftJoin('users', 'employees.user_id', '=', 'users.id')
        ->select('users.name as user', 'employees.*')
        ->orderBy('employees.id', 'desc')
        ->paginate(10);
        $employeesCount = Employee::all()->count();
        return view("pages.view-employees")->with("employees",$employees)->with("employeesCount",$employeesCount);
    }

    public function accessRights(){

        //this is the part that will show the access rights for each and every member
        return view("pages.access-rights");

    }

    //return the employee to the view, find the employee by the id
    public function editEmployee($id){

        $employee = Employee::find($id);
        
        if(!$employee){

            echo "employee does not exist";
        }

        return view("pages.edit-employee")->with("employee",$employee);
    }

    public function create()
    {
        //blade that will create the employees
        return view("pages.create-employee");
    }

       public function store(Request $request)
   
     {
        
        $userId = Auth::user()->id;
        // Create a new employee
        $employee = Employee::create([
            'user_id'=>$userId,
            'name' => $request->name,
            'login_pin' => Hash::make($request->login_pin), // Store login PIN hashed
            'pos_username' => $request->pos_username,
            'email' => $request->email,
            'role'=>$request->role
        ]);

        if($employee->save()){
            return redirect()->back()->with('success', 'Employee Saved Successfully');
        }
        // Redirect back with a success message
        return redirect()->back()->with('error', 'Employee Not Saved');
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

    public function deleteEmployee($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        return redirect('/view-employees');
    }
}
