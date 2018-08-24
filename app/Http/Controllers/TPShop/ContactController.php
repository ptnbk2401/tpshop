<?php

namespace App\Http\Controllers\TPShop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Model\Contact;

class ContactController extends Controller
{
    public function getIndex(){
    	return view('tpshop.contact.index');
    }

    public function postIndex(ContactRequest $request){
    	$fullname 	= trim($request->fullname);
    	$email 		= trim($request->email);
    	$message 	= trim($request->message);
    	$arContact 	= array(
    		'fullname' 	=> $fullname,
    		'email' 	=> $email,
    		'message' 	=> $message
    	);
    	$objContact = new Contact();
    	if($objContact->addItem($arContact)){
    		$request->session()->flash('msg','Gửi Liên Hệ Thành Công!!!');
    		return redirect()->route('tpshop.contact.index');
    	} else {
    		$request->session()->flash('msg_er','Gửi Liên Hệ Không Thành Công?!');
    		return redirect()->back();
    	}
    }
}
