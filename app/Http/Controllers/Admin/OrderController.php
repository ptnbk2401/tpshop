<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Model\Product;
use App\Model\DiachiGiaoHang;
use App\Model\Diachi;
use App\Model\Order;
use App\Http\Requests\ProductRequest;

class OrderController extends Controller
{
	public function __construct(Product $objProduct, Order $objOrder){
        $this->objProduct = $objProduct;
		$this->objOrder = $objOrder;
	}

    public function index(){
        $objItems  = $this->objOrder->getItems();
        return view('admin.order.index',compact('objItems'));
    }
    public function changeTTDH(Request $request){
    	$idOrder = $request->idOrder;
        $Val = $request->Val;
        if( Order::changeTTDH($idOrder,$Val) ){
            return 1;
        } else {
            return 0;
        }
    }
    public function delete(Request $request,$id){
        if(Order::delOrder($id)){
            $request->session()->flash('msg','Xóa thành Công!');
            return redirect()->route('admin.order.index');
        } else {
            $request->session()->flash('msg-error','Xóa Thất Bại!');
            return redirect()->route('admin.order.index');
        }
    }
    
}
