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
        //return the employees to the front end
        $employees = Employee::orderBy("id","desc")->paginate(5);
        $employeesCount = Employee::all()->count();
        return view("pages.view-employees")->with("employees",$employees)->with("employeesCount",$employeesCount);
    }

    public function accessRights(){

        //this is the part that will show the access rights for eah and every member
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
        $employee = Employee::create([
            'name' => $request->input('name'),
            'role' => $request->input('role'),
            'access_level' => $request->input('access_level'),
            'user_id'=>$userId,
            'password' => Hash::make($request->input('password')),
            'confirm_password' => Hash::make($request->input('confirm_password')),
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
