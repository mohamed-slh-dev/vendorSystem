<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function login (){

        return view('login');

    }

    public function checkLogin(Request $request) {

        // username + password
        $username = $request->username;
        $password = $request->password;

        
        // get user using username
        $user = User::where('username', $username)->first();


        // if found then check password (he pass)
        if ($user && Hash::check($password, $user->password)) {


            // put permission (session) id + profile pic
            session()->put('name', $user->name);
            session()->put('username', $user->username);
            session()->put('user_id', $user->id);

            // redirect to dashboard
            return redirect()->route('dashboard');

        } // end of password correct


        // he don't pass
        else {

            // redirect to login again
            return redirect()->route('login')->with('warning','بيانات الدخول غير صحيحة');

        } //end of wrong password or user not found


        
    } //end of checkuser login function

    public function users()
    {
        $users = User::all();
        return view('users', compact('users'));
    }


    public function updateUser(Request $request){

        $user = User::find($request->id);

        $user->password = Hash::make($request->pass);

        $user->save();

        return redirect()->back()->with('success', 'تم تغير كلمة المرور بنجاح');
        
    }

    public function logout()
    {
         // delete permission (session) id + profile pic
         session()->forget('name');

         session()->forget('user_id'); 
 
         // redirect to login
         return redirect()->route('login');
    }

}
