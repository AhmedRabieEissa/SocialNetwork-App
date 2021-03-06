<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //

    public function postSignUp(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email|unique:users',
            'name'=>'required|max:120',
            'password'=>'required|min:4'
        ]);
        $email = $request['email'];
        $name = $request['name'];
        $pass = bcrypt($request['password']);

        $User = new User();

        $User->email=$email;
        $User->name=$name;
        $User->password=$pass;

        $User->save();
        Auth::login($User);

        return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request)
    {
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required'
        ]);
        if (Auth::attempt(['email'=>$request['email'],'password'=>$request['password']])){
            return redirect()->route('dashboard');
        }
        return redirect()->back();
    }

}
