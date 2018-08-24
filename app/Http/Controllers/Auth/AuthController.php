<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getLogin(){
    	return view('auth.login');
    }
    public function postLogin(Request $request){
        $username = trim($request->username);
    	$email = trim($request->email);
    	$password = trim($request->password);
        if(isset($username)){
            if (Auth::attempt(['username' => $username, 'password' => $password])) {
                if(Auth::user()->role != 2){
                    return redirect()->route('admin.index.index');
                } 
                else {
                    return redirect()->route('tpshop.user.profile');
                }
               
            } else {
                $request->session()->flash('msg','Sai Username hoặc Password');
                return redirect()->back();
            }
        } else {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
               return redirect()->route('admin.index.index');
            } else {
                $request->session()->flash('msg','Sai Email hoặc Password');
                return redirect()->back();
            }
        }
    	
    }
    public function logout(Request $request){
        if(Auth::user()->role != 2){
            Auth::logout();
            $request->session()->flush();
            return redirect()->route('auth.login');
        } 
        else {
            Auth::logout();
            $request->session()->flush();
            return redirect()->route('tpshop.index.index');
        }
    	
    }
    
}
