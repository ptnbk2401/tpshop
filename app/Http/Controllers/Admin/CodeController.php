<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Code;
use App\Http\Requests\CodeRequest;
use Auth;
class CodeController extends Controller
{
    public function __construct(Code $objCode){
    	$this->objCode = $objCode;
    }
    public function index(){	
    	$objItems = $this->objCode->getItems();
    	return view('admin.code.index',compact('objItems'));
    } 
    public function getAdd(){   
        return view('admin.code.add');
    } 
    public function postAdd(CodeRequest $request){  
        $macode = trim($request->macode);
        $value = trim($request->value);
        $don_hang_toi_thieu = trim($request->don_hang_toi_thieu);
        
        $arCode = array(
            'macode'                => $macode,
            'value'                 => $value,
            'don_hang_toi_thieu'    => $don_hang_toi_thieu,
        );
        // dd($arCode);
        if($this->objCode->addItem($arCode)){
            $request->session()->flash('msg','Thêm thành Công!');
            return redirect()->route('admin.code.index');
        } else {
            $request->session()->flash('msg','Thêm Thất Bại!');
            return redirect()->back();
        }
    } 
     public function delete(Request $request,$id){
        $objCode = Code::find($id);
        if($this->objCode->deleteItem($id)){
            $request->session()->flash('msg','Xóa thành Công!');
            return redirect()->route('admin.code.index');
        } else {
            $request->session()->flash('msg-error','Xóa Thất Bại!');
            return redirect()->route('admin.code.index');
        }
    }
   
    
}
