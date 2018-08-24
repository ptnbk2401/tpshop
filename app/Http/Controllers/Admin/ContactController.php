<?php

namespace App\Http\Controllers\Admin;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Contact;
use App\Mail\sendMail;

class ContactController extends Controller
{
    public function __construct(Contact $objContact){
    	$this->objContact = $objContact;
    }
    public function index(){
    	$objItems = $this->objContact->getItems();
    	return view('admin.contact.index',compact('objItems'));
    }
    public function delete(Request $request,$id){
    	if($this->objContact->deleteItem($id)){
    		$request->session()->flash('msg','Xóa thành Công!');
    		return redirect()->route('admin.contact.index');
    	} else {
    		$request->session()->flash('msg-error','Xóa Thất Bại!');
    		return redirect()->route('admin.contact.index');
    	}
    }
    public function sendMail(Request $request, $id){
    	$email 		= trim($request->email);
    	$title 		= trim($request->title);
    	$message 	= trim($request->message);
    	$content = array(
    		'email' 	=> $email,
    		'title' 	=> $title,
    		'message' 	=> $message
    	);
        $result = Mail::to($email)->send(new sendMail($content));
        $request->session()->flash('msg','Gửi Mail Thành Công');
        $this->objContact->reply($id);
        return redirect()->route('admin.contact.index');
       
    }
}
