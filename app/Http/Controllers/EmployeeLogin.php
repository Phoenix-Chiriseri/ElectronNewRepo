<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EmployeeLogin extends Controller
{
    //login the employee
    public function showLoginForm(){
        return view('pages.employee-auth.employee-login');
    }
    
    public function store(Request $request){  
        $loginPin = $request->input('login_pin');
        $employee = Employee::where('login_pin', $loginPin)->first();
        if ($employee) {
            // Hash the provided PIN and compare it with the stored one
                Auth::login($employee);
                return redirect()->route('cart-index'); // Redirect to cart dashboard
        }
        // PIN authentication failed
        return redirect()->route('employee.login')->with('error', 'Invalid login PIN.');
    }
}
