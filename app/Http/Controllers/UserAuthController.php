<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;

class UserAuthController extends Controller
{
    function adminLogin(){
        return view("auth.adminLogin");
    }

    function adminRegister(){
        return view("auth.adminRegister");
    }

    function adminCreate(Request $request){
        //validate $request

        $request->validate([
            "name"=>"required",
            "email"=>"required|email|unique:admins",
            "password"=>"required|min:6|max:12"
        ]);

        //if validate successfuly, save data to database

        $user = new Admin;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $query = $user->save();

        

        if($query){
            return back()->with("success", "You have been successfuly registrated!");
        }
        else{
            return back()->with("fail", "Somthing went wrong!");
        }
    }

    function adminCheck(Request $request){
        //validate $request

        $request->validate([
            "email"=>"required|email",
            "password"=>"required|min:6|max:12"
        ]);

        //if validate successfuly

        $user = Admin::where("email", "=", $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $request->session()->put("Admintoltotkaposzta", $user->id);
                return redirect("admin/profile");
            }
            else{
                return back()->with("fail", "Invalid password!");
            }
        }
        else{
            return back()->with("fail", "No account found on this Email!");
        }
    }

    function adminProfile(){
        if(session()->has("Admintoltotkaposzta")){
            $user = Admin::where("id", "=", session("Admintoltotkaposzta"))->first();
            $data = [
                "LoggedUserInfo"=>$user
            ];

        }
        return view("admin.profile", $data);
    }

    function adminLogout(){

        if(session()->has("Admintoltotkaposzta")){
            session()->pull("Admintoltotkaposzta");
            return redirect("admin/login");
        }
    }

    /* User registrer and login */

    function login(){
        return view("userAuth.login");
    }

    function register(){
        return view("userAuth.register");
    }

    function create(Request $request){
        //validate $request

        $request->validate([
            "first_name"=>"required",
            "last_name"=>"required",
            "email"=>"required|email|unique:users",
            "password"=>"required|min:6|max:12",
            "password_replay"=>"required|min:6|max:12"
        ]);

        //if validate successfuly, save data to database
        //Mail::to($request->email)->send(new WelcomeMail($request));
        if($request->password == $request->password_replay){
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $query = $user->save();
        }
        if($query){
            
            return back()->with("success", "You have been successfuly registrated!");
        }
        else{
            return back()->with("fail", "Somthing went wrong!");
        }
    }

    function check(Request $request){
        //validate $request

        $request->validate([
            "email"=>"required|email",
            "password"=>"required|min:6|max:12"
        ]);

        //if validate successfuly

        $user = User::where("email", "=", $request->email)->first();

        if($user){
            if(Hash::check($request->password, $user->password)){
                $request->session()->put("LoggedUser", $user->id);
                return redirect("/");
            }
            else{
                return back("/")->with("fail", "Invalid password!");
            }
        }
        else{
            return back()->with("fail", "No account found on this Email!");
        }
    }

    function profile(){

        if(session()->has("LoggedUser")){
            $user = User::where("id", "=", session("LoggedUser"))->first();
            $data = [
                "LoggedUserInfo"=>$user
            ];
        }
        return view("/", $data);
    }

    function logout(){

        if(session()->has("LoggedUser")){
            session()->pull("LoggedUser");
            return redirect("/");
        }
    }
}
