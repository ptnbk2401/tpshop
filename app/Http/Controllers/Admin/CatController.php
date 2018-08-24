<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cat;

class CatController extends Controller
{
    
    public function index(){
    	$objCat = new Cat();
    	$objItems  = $objCat->getItems();
    	return view('admin.categories.index',compact('objItems'));
    }
    public function getAdd(){
    	$objCat = new Cat();
    	$objItems = $objCat->getItems();
    	return view('admin.categories.add',compact('objItems'));
    }
    public function postAdd(Request $request){
    	if(empty($request->name)){
    		$request->session()->flash('erorr-name','Tên Danh Mục Không Để Rỗng');
    		return redirect()->back();
    	}
    	$name = $request->name;
        if(Cat::checkName($name)){
            $request->session()->flash('erorr-name','Tên Danh Mục Đã tồn tại');
            return redirect()->back();
        }
        $id_parent = $request->idparent;
        $arCat = array(
            'name_cat'  => $name,
            'id_parent' => $id_parent,
        );
        $objCat = new Cat();
        if($objCat->addCat($arCat)){
            $request->session()->flash('msg','Thêm Thành Công');
            return redirect()->route('admin.cat.index');
        } else {
            $request->session()->flash('msg','Thêm Thất Bại');
            return redirect()->back();
        }

    }
	public function moveTrash(Request $request,$id){
    	$objCat = new Cat();
    	if($records = $objCat->moveTrash($id)){
    		$request->session()->flash('msg','Đã chuyển '.$records.' Danh mục vào Thùng Rác');
    		return redirect()->route('admin.cat.index');
    	} else {
    		$request->session()->flash('msg','Chuyển Danh mục vào Thùng Rác Thất Bại');
    		return redirect()->route('admin.cat.index');
    	}
    }
    

    public function getEdit($id){
    	$objCat = new Cat();
    	$objItem = $objCat->getItem($id);
        $objItems = $objCat->getItemsWithoutId($id);
    	return view('admin.categories.edit',compact('objItem','objItems'));
    }
    public function postEdit(Request $request,$id){
    	if(empty($request->name)){
    		$request->session()->flash('erorr-name','Tên Danh Mục Không Để Rỗng');
    		return redirect()->back();
    	}
    	$name = $request->name;
    	$id_parent = $request->idparent;
    	$arCat = array(
    		'name_cat'	=> $name,
    		'id_parent'	=> $id_parent,
    	);
    	$objCat = new Cat();
    	if($objCat->editCat($id,$arCat)){
    		$request->session()->flash('msg','Sửa Thành Công');
    		return redirect()->route('admin.cat.index');
    	} else {
    		$request->session()->flash('msg','Sửa Thất Bại');
    		return redirect()->back();
    	}

    }
    public function getTrash(){
    	$objCat = new Cat();
    	$objTrash  = $objCat->getTrash();
    	return view('admin.categories.trash',compact('objTrash'));
    }
    public function recycle(Request $request,$id){
    	$objCat = new Cat();
    	if($records = $objCat->recycleTrash($id)){
    		$request->session()->flash('msg','Đã khôi phục '.$records.' Danh mục');
    		return redirect()->route('admin.cat.trash');
    	} else {
    		$request->session()->flash('msg','Khôi phục Danh mục Thất Bại');
    		return redirect()->route('admin.cat.trash');
    	}
    }
    public function delete(Request $request,$id){
    	$objCat = Cat::find($id);
        if( $objCat->count_post > 0 ) {
            $request->session()->flash('msg','Danh mục còn chứa Bài viết! Vui lòng chọn Xóa bài viết trước.');
            return redirect()->route('admin.cat.trash');
        } else {
            if($records = $objCat->deleteTrash($id)){
                $request->session()->flash('msg','Đã xóa Vĩnh Viễn '.$records.' Danh mục');
                return redirect()->route('admin.cat.trash');
            } 
            else {
                $request->session()->flash('msg','Xóa Vĩnh Viễn Danh mục Thất Bại');
                return redirect()->route('admin.cat.trash');
            }
        } 
    	
    }

    public function allTrash(Request $request,$luachon){
    	$objCat = new Cat();
    	if($records = $objCat->allTrash($luachon)){
    		$msg = ($luachon=='delete')? 'Đã xóa Vĩnh Viễn '.$records.' Danh mục' : 'Đã khôi phục '.$records.' Danh mục';
    		$request->session()->flash('msg',$msg);
    		return redirect()->route('admin.cat.trash');
    	} else {
    		$request->session()->flash('msg','Thao tác thực hiện Thất Bại');
    		return redirect()->route('admin.cat.trash');
    	}
    }
}
