<?php

namespace App\Http\Controllers\back_end;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function loginView()
    {

        if (auth()->guard("admin")->check()){
          return  redirect("/admin");
        }
        return view("back_end.auth.login");
    }
    public function homePage()
    {

        return view("back_end.home");
    }
    public function login(Request $request)
   {

           $this->validate($request , [

         	    	 'email'   => 'required|email',
                    'password' => 'required',

           ]);

    

    			if (auth()->guard("admin")->attempt( ['email' => request('email') , 'password' => request('password') ]) ) {

                    return redirect("admin");

                }else{

                    return redirect("admin/login")->with('message_error','Invalid Email Or Password');
    			}
    		}



}
