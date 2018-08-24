<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Http\Requests\UserRequset;
use Auth;
class UserController extends Controller
{
    public function __construct(User $objUser){
    	$this->objUser = $objUser;
    }
    public function index(){	
    	$objItems = $this->objUser->getItems();
    	return view('admin.user.index',compact('objItems'));
    } 
    public function getAdd(){	
    	return view('admin.user.add');
    } 
    public function postAdd(UserRequset $request){	
    	$username = trim($request->username);
    	$password = bcrypt(trim($request->password));
    	$fullname = trim($request->fullname);
    	$role 	= $request->role;
    	$arUser = array(
    		'username' 	=> $username,
    		'password' 	=> $password,
    		'fullname' 	=> $fullname,
    		'role'		=> $role,
    	);
    	// dd($arUser);
    	if($this->objUser->addItem($arUser)){
    		$request->session()->flash('msg','Thêm thành Công!');
    		return redirect()->route('admin.user.index');
    	} else {
    		$request->session()->flash('msg','Thêm Thất Bại!');
    		return redirect()->back();
    	}
    } 
    public function getEdit(Request $request,$id){
        $objUser = User::find($id);
        $username = Auth::user()->username;
        if($username != 'admin' && $username != $objUser->username){
            $request->session()->flash('msg-error','Không có quyền Sửa thông tin Người dùng khác!');
            return redirect()->route('admin.user.index');
        }
    	$objItem = $this->objUser->getItemByID($id);
    	return view('admin.user.edit',compact('objItem'));
    }
    public function postEdit(Request $request,$id){
    	if(isset($request->password)){
    		$password = bcrypt(trim($request->password));
    	}
    	else {
    		$password = User::find($id)->password;
    		if($request->fullname == User::find($id)->fullname && $request->role == User::find($id)->role ){
    			return redirect()->route('admin.user.index');
    		}
    	}
    	$username = $request->username;
    	$fullname = trim($request->fullname);
    	$role 	= $request->role;
    	$arUser = array(
    		'username' => $username,
    		'password' => $password,
    		'fullname' => $fullname,
    		'role'		=> $role,
    	);
    	if($this->objUser->editItem($arUser,$id)){
    		$request->session()->flash('msg','Sửa thành Công!');
    		return redirect()->route('admin.user.index');
    	} else {
    		$request->session()->flash('msg-error','Sửa Thất Bại!');
    		return redirect()->back();
    	}
    }
    public function delete(Request $request,$id){
        $objUser = User::find($id);
        if($objUser->username === 'admin'){
            $request->session()->flash('msg-error','Tài khoản Admin không thể Xóa!');
            return redirect()->route('admin.user.index');
        }
    	if($this->objUser->deleteItem($id)){
    		$request->session()->flash('msg','Xóa thành Công!');
    		return redirect()->route('admin.user.index');
    	} else {
    		$request->session()->flash('msg-error','Xóa Thất Bại!');
    		return redirect()->route('admin.user.index');
    	}
    }
    public function profile(){    
        $user = Auth::user();
        return view('admin.user.profile',compact('user'));
    } 
}
