<?php

namespace App\Http\Controllers\Tpshop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Diachi;
use App\Model\Code;
use App\Model\DiachiGiaoHang;
use App\Model\Thanhtoan;
use App\Model\Order;
use App\Model\Cart;
use Auth;
class PayController extends Controller
{
    public function index(Request $request){ 
    	$user = Auth::user();
    	$objAddress = DiachiGiaoHang::getItem($user->id);
        $objVanchuyen = Thanhtoan::getVanchuyen();
        $objPayMethod = Thanhtoan::getPayMethod();
        if($objAddress){
            $arDC = Diachi::getInfo($objAddress->tinh,$objAddress->quan,$objAddress->phuong);
            $diachi = $arDC[0];
            return view('tpshop.pay.index',compact('user','objAddress','diachi','objVanchuyen','objPayMethod'));
        } else {
             return view('tpshop.pay.index',compact('user','objVanchuyen','objPayMethod'));
        }
    }
    
    public function paypal(){
        return view('tpshop.pay.paypal');
    }
    public function finish(){
        $user = Auth::user();
        $objOrder = Order::getOrder($user->id);
    	return view('tpshop.pay.finished',compact('objOrder'));
    }
    public function getItems(Request $request){ 
    	$arItems = $request->arID;
    	$request->session()->put('arPayItems',$arItems);
    	return $arItems;
    } 
    public function thongtinThanhToan(Request $request){ 
        $dongia = $request->dongia;
        $vanchuyen = $request->vanchuyen;
        $giamgia = $request->giamgia;
        $tongtien = $dongia + $vanchuyen - $giamgia;

        echo number_format($tongtien).",000đ";
        
    }
    public function checkcode(Request $request){ 
        $magiamgia = $request->magiamgia;
    	$dongia = $request->dongia;
        $objCode = Code::getItemByname($magiamgia);
        if($objCode) {
            if($dongia >= $objCode->don_hang_toi_thieu ){
                echo $objCode->value;
            }
            else {
                echo "0";
            }
        } else {
            echo "error";
        }
    }
    
    public function addOrder(Request $request){
        $id_user    = $request->user_id;
        $strID      = $request->strID;
        $strSL      = $request->strSL;
        $strTT      = $request->strTT;
        $thanhtoan  = $request->thanhtoan;
        $Vanchuyen  = $request->Vanchuyen;
        $MaCode     = $request->MaCode;
        $Paymethod  = $request->Paymethod;
        $status     = ($Paymethod ==1 ) ? 0 : 1;
        $arOrder = array(
            'id_user'       => $id_user , 
            'id_product'    => $strID , 
            'soluong'       => $strSL , 
            'thuoctinh'     => $strTT, 
            'money_pay'     => $thanhtoan, 
            'pay_method'    => $Paymethod, 
            'vanchuyen'     => $Vanchuyen, 
            'macode'        => $MaCode,
            'status'        => $status ,
        );
        if(Order::addOrder($arOrder)){
            $request->session()->flash('msg','Thêm Thanh Công!');
            $request->session()->forget('cart');
            if(Auth::check()) {
                Cart::delCart(Auth::user()->id,0);    
            }
            return 1;
        } else {
            $request->session()->flash('msg','Thêm Thất Bại!');
            return 0;
        }

    }


}
