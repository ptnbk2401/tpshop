<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Model\Product;
use App\Model\Cat;
use App\Model\Gift;
use App\Model\Size;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
	public function __construct(Product $objProduct, Cat $objCat , Size $objSize ){
		$this->objProduct = $objProduct;
        $this->objCat = $objCat;
		$this->objSize = $objSize;
	}

    public function index(){
        $objItemsCat = $this->objCat->getItems();
    	$objItems  = $this->objProduct->getItems();
    	return view('admin.product.index',compact('objItems','objItemsCat'));
    }
    public function getAdd(){
    	$objItemsCat = $this->objCat->getItems();
        $objGift = Gift::getItems();
        $objSize = $this->objSize->getItems();
    	$objSizeType = $this->objSize->getType();
    	return view('admin.product.add',compact('objItemsCat','objGift','objSize','objSizeType'));
    }
    public function postAdd(ProductRequest $request){
        $name       = trim($request->name);
        $size       = (!empty($request->size)) ? implode(',', $request->size) : '';
        $color      = (!empty($request->color)) ? implode(',', $request->color) : '';
    	$preview 	= ($request->preview);
    	$id_cat     = empty($request->idchild)? $request->idparent : $request->idchild;
    	$price_old 	= trim($request->price_old);
    	$price_new 	= (isset($request->price_new))? trim($request->price_new) : 0;
    	$idgift 	= $request->idgift;
    	$detail 	= $request->detail;
        $sale       = (empty($price_new)? 0 : 1);

    	if(!empty($request->file('picture'))){
    		$file = $request->file('picture')->store('/files/upload/');
	    	$tmp = explode('/', $file);
	    	$picture = end($tmp);
    	} else {
    		$picture = 'default.png';
    	}
    	$arProduct = array(
    		'name'		=> $name,
            'id_cat'    => $id_cat,
            'id_size'   => $size,
            'color'     => $color,
    		'preview'	=> $preview,
    		'price_old'	=> trim($price_old),
    		'price_new'	=> trim($price_new),
    		'picture'	=> $picture,
    		'id_gift'	=> $idgift,
            'detail'    => $detail,
    		'sale'	    => $sale,
    	);
        // dd($arProduct);
    	$objProduct = new Product();
    	if($objProduct->addProduct($arProduct)){
    		$request->session()->flash('msg','Thêm Thành Công');
    		return redirect()->route('admin.product.index');
    	} else {
    		$request->session()->flash('msg','Thêm Thất Bại');
    		return redirect()->back();
    	}

    }
	public function moveTrash(Request $request,$id){
    	$objProduct = new Product();
    	if($records = $objProduct->moveTrash($id)){
    		$request->session()->flash('msg','Đã chuyển '.$records.' Sản phẩm vào Thùng Rác');
    		return redirect()->route('admin.product.index');
    	} else {
    		$request->session()->flash('msg','Chuyển Sản phẩm vào Thùng Rác Thất Bại');
    		return redirect()->route('admin.product.index');
    	}
    }
    

    public function getEdit($id){
    	$objItem = $this->objProduct->getItem($id);
        $objItemsCat = $this->objCat->getItems();
    	$objGift = Gift::getItems();
        $objSize = $this->objSize->getItems();
        $objSizeType = $this->objSize->getType();
    	return view('admin.product.edit',compact('objItem','objItemsCat','objGift','objSize','objSizeType'));
    }
    public function postEdit(ProductRequest $request,$id){
    	$this->objProduct = Product::find($id);
    	$name 		= trim($request->name);
    	$id_cat 	= empty($request->idchild)? $request->idparent : $request->idchild;
    	$price_old 	= trim($request->price_old);
    	$price_new 	= (isset($request->price_new))? trim($request->price_new) : 0;
    	$idgift 	= $request->idgift;
    	$detail 	= $request->detail;
        $size       = (!empty($request->size)) ? implode(',', $request->size) : '';
        $color      = (!empty($request->color)) ? implode(',', $request->color) : '';
        $preview    = ($request->preview);

    	if(!empty($request->file('picture'))){
    		$file = $request->file('picture')->store('/files/upload/');
	    	$tmp = explode('/', $file);
	    	$picture = end($tmp);
	    	Storage::delete('/files/upload/'.$this->objProduct->picture);
    	} else {
    		$picture = $this->objProduct->picture;
    	}
    	
    	$arProduct = array(
    		'name'		=> $name,
    		'id_cat'	=> $id_cat,
            'id_size'   => $size,
            'color'     => $color,
            'preview'   => $preview,
    		'price_old'	=> $price_old,
    		'price_new'	=> $price_new,
    		'picture'	=> $picture,
    		'id_gift'	=> $idgift,
    		'detail'	=> $detail,
    	);

    	if($this->objProduct->editProduct($id,$arProduct)){
    		$request->session()->flash('msg','Sửa Thành Công');
    		return redirect()->route('admin.product.index');
    	} else {
    		$request->session()->flash('msg','Sửa Thất Bại');
    		return redirect()->back();
    	}

    }
    public function getTrash(){
    	$objProduct = new Product();
    	$objTrash  = $objProduct->getTrash();
    	return view('admin.product.trash',compact('objTrash'));
    }
    public function recycle(Request $request,$id){
    	$objProduct = new Product();
    	if($records = $objProduct->recycleTrash($id)){
    		$request->session()->flash('msg','Đã khôi phục '.$records.' Sản phẩm');
    		return redirect()->route('admin.product.trash');
    	} else {
    		$request->session()->flash('msg','Khôi phục Sản phẩm Thất Bại');
    		return redirect()->route('admin.product.trash');
    	}
    }
    public function delete(Request $request,$id){
    	$objProduct = new Product();
    	if($records = $objProduct->deleteTrash($id)){
    		$request->session()->flash('msg','Đã xóa Vĩnh Viễn '.$records.' Sản phẩm');
    		return redirect()->route('admin.product.trash');
    	} else {
    		$request->session()->flash('msg','Xóa Vĩnh Viễn Sản phẩm Thất Bại');
    		return redirect()->route('admin.product.trash');
    	}
    }

    public function allTrash(Request $request,$luachon){
    	$objProduct = new Product();
    	if($records = $objProduct->allTrash($luachon)){
    		$msg = ($luachon=='delete')? 'Đã xóa Vĩnh Viễn '.$records.' Sản phẩm' : 'Đã khôi phục '.$records.' Sản phẩm';
    		$request->session()->flash('msg',$msg);
    		return redirect()->route('admin.product.trash');
    	} else {
    		$request->session()->flash('msg','Thao tác thực hiện Thất Bại');
    		return redirect()->route('admin.product.trash');
    	}
    }

    
}
