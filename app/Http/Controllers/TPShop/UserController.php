<?php

namespace App\Http\Controllers\TPshop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Cart;
use App\Model\Product;
use App\Model\Diachi;
use App\Model\DiachiGiaoHang;
use App\Http\Requests\UserRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(User $objUser){
    	$this->objUser = $objUser;
    }
    public function postAdd(UserRequest $request){	
    	$username = trim($request->username);
    	$password = bcrypt(trim($request->password));
        $fullname = trim($request->fullname);
    	$email    = trim($request->email);
    	$role 	  = 2;
    	$arUser = array(
    		'username' 	=> $username,
    		'password' 	=> $password,
            'fullname'  => $fullname,
    		'email' 	=> $email,
    		'role'		=> $role,
    	);
    	// dd($arUser);
    	if($this->objUser->addItem($arUser)){
    		$request->session()->flash('msg','Thêm thành Công!');
    		return redirect()->back();
    	} else {
    		$request->session()->flash('msg','Thêm Thất Bại!');
    		return redirect()->back();
    	}
    } 

    public function getEdit(){
        $user = Auth::user();
        $objAddress = DiachiGiaoHang::getItem($user->id);
        $objTinh = Diachi::getTinh();
        $objQuan = Diachi::getQuan();
        $objPhuong = Diachi::getPhuong();
        return view('tpshop.profile.edit',compact('user','objAddress','objTinh','objQuan','objPhuong'));
    	
    }
    public function postAddress(AddressRequest $request,$id_user){
        if (DiachiGiaoHang::checkUser($id_user) > 0) {
            $fullname = trim($request->fullname);
            $phone    = ($request->phone);
            $address  = trim($request->address);
            $tinh     = ($request->tinh);
            $quan     = ($request->quan);
            $phuong   = ($request->phuong);
            $arUser = array(
                'id_user'  => $id_user,
                'address'  => $address,
                'phone'    => $phone,
                'fullname' => $fullname,
                'tinh'     => $tinh,
                'quan'     => $quan,
                'phuong'   => $phuong,
            );
            if(DiachiGiaoHang::editItem($arUser,$id_user)){
                $request->session()->flash('msg','addresssuccess');
                return redirect()->back();
            } else {
                $request->session()->flash('msg','addresserror');
                return redirect()->back();
            }

        } else {
            $fullname = trim($request->fullname);
            $phone    = ($request->phone);
            $address  = trim($request->address);
            $tinh     = ($request->tinh);
            $quan     = ($request->quan);
            $phuong   = ($request->phuong);
            $arUser = array(
                'id_user'  => $id_user,
                'address'  => $address,
                'phone'    => $phone,
                'fullname' => $fullname,
                'tinh'     => $tinh,
                'quan'     => $quan,
                'phuong'   => $phuong,
            );
            if(DiachiGiaoHang::addItem($arUser)){
                $request->session()->flash('msg','addresssuccess');
                return redirect()->back();
            } else {
                $request->session()->flash('msg','addresserror');
                return redirect()->back();
            }
        }
        
    }
    public function postEdit(Request $request,$id){
        $email      = trim($request->email);
        $fullname   = trim($request->fullname);
        $arUser = array(
            'fullname' => $fullname,
            'email'    => $email,
        );
        // dd($arUser);
        if($this->objUser->editUserInfo($arUser,$id)){
            $request->session()->flash('msg','infosuccess');
            return redirect()->back();
        } else {
            $request->session()->flash('msg','error');
            return redirect()->back();
        }
    }
    public function postEditPass(Request $request,$id){
        $username   = User::find($id)->username;
        $oldpass    = trim($request->oldpass);
        $newpass    = bcrypt(trim($request->newpass));

        if(Auth::attempt( ['username' => $username, 'password' => $oldpass] )) {
            if($this->objUser->editUserPass($newpass,$id)){
                $request->session()->flash('msg','passsuccess');
                return redirect()->back();
            } else {
                $request->session()->flash('msg','error');
                return redirect()->back();
            }
        } else {
            $request->session()->flash('msg','passerror');
            return redirect()->back();
        }
    	
    	
        // dd($arUser);
    	
    }
    
    public function profile(Request $request){    
        $user = Auth::user();
        $arCart = array();
        if($request->session()->has('cart')) {
            $arCart = $request->session()->get('cart');
        }
        $objCart = Cart::getItems(Auth::user()->id);
        foreach($objCart as $item){
            $soluong = $item->soluong;
            $objItem = Product::find($item->id_product);
            $gia = empty($objItem->price_new)? $objItem->price_old : $objItem->price_new;
            $tongtien = $soluong*$gia;
            $arCart[ $item->id_product ] = array(
                'name'      => $objItem->name,
                'picture'   => $objItem->picture,
                'gia'       => $gia,
                'soluong'   => $soluong,
                'tongtien'  => $tongtien,
            );
        }
        $request->session()->put('cart',$arCart);
        return view('tpshop.profile.index',compact('user'));
    } 
}
