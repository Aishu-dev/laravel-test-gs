<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Redirect;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // display signup form

    public function signup(Request $request){
        return view('signup');
    }

    //store employee details

    public function submitDetails(Request $request){

        $validated = Validator::make($request->all(),[
            'name' => 'regex:/^[a-zA-Z]+$/u',
            'email' => 'email|unique:employees',
            'password' => ['confirmed', Password::min(9)->mixedCase()->numbers()->symbols()],
        ]);

        if($validated->fails()) {
            return Redirect::back()->withErrors($validated);
        }
       

        $employee = Employee::create([
            'name' => $request->name, 
            'email' => $request->email, 
            'password' => Hash::make($request->password)
        ]);

        if(!empty($employee)){
            return redirect()->back()->with('message', 'Successfully Registered!');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong while saving details!');
        }        

    }

    //display sign in form

    public function signin(Request $request){

        return view('signin');

    }

    // after login redirect to dashboard
    
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email', 
            'password' => 'required'
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator);
        }

        $user = Employee::where('email', $request->email)->first();

        if(!$user){
            return redirect()->back()->with('error', 'Email does not exist!');
        }

        else{
            if(Hash::check($request->password, $user->password)){
                return view('dashboard', compact('user'));
            }
            else{
                return redirect()->back()->with('error', 'Password is incorrect!');
            }

        }
    }

    //admin login 

    public function adminLogin(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:employees,email', 
            'password' => 'required',
        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator);
        }

        $user = Employee::where('email', $request->email)->where('user_type', 'admin')->first(); 

        if(!$user){
            return redirect()->back()->with('error', 'Email does not exist!');
        }

        else{
            if(Hash::check($request->password, $user->password)){
                return view('dashboard', compact('user'));
            }
            else{
                return redirect()->back()->with('error', 'Password is incorrect!');
            }

        }
    }

}
