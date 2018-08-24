<?php

namespace App\Http\Controllers\Tpshop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Cart;
use Auth;
class CartController extends Controller
{
    public function index(Request $request){ 
    	return view('tpshop.cart.index');
    }
    
    public function addCart(Request $request){
        $id         = $request->idProduct;
    	// $thuoctinh  = $request->thuoctinh;
        //Kiem tra Login
        if(Auth::check()) {
            $objCart = Cart::getItem(['id_user'=>Auth::user()->id, 'id_product'=>$id]);
            if($objCart){
               $soluong  = $objCart->soluong + 1 ;
               $arItem = array(
                    'id_user'       => Auth::user()->id,
                    'id_product'    => $id,
                    'soluong'       => $soluong,
                    // 'thuoctinh'     => $thuoctinh,
               ); 
               Cart::editCart($arItem);
            } else {
                $arItem = array(
                    'id_user'       => Auth::user()->id,
                    'id_product'    => $id,
                    'soluong'       => 1,
                    // 'thuoctinh'     => thuoctinh,
               ); 
            Cart::addCart($arItem);
            }
        }
     	if($request->session()->has('cart')){
     		$arCart = $request->session()->get('cart');
     	} else {
     		$arCart = array();
     	}
     	$objItem = Product::find($id);
     	if(isset($arCart[$id])){
     		$soluong = $arCart[$id]['soluong']+1;
     	} else {
     		$soluong = 1;
     	}

     	$gia = empty($objItem->price_new)? $objItem->price_old : $objItem->price_new;
     	$tongtien = $soluong*$gia;
     	$arCart[$id] = array(
     		'name'		=> $objItem->name,
     		'picture'	=> $objItem->picture,
     		'gia'		=> $gia,
     		'soluong'	=> $soluong,
     		'tongtien'	=> $tongtien,
     	);
     	$request->session()->put('cart',$arCart);
        
     	$count = count($arCart);
		echo '<a href="#" class="cart-icon">Giỏ Hàng <span class="cart_no">'.$count.'</span></a><ul class="option-cart-item">';
		$thanhtoan = 0;
		foreach($arCart as $id => $item){
			$srcImg = '/storage/app/files/upload/'.$item['picture'];
			$name 		= $item['name'];
			$gia 		= $item['gia'];
			$soluong 	= $item['soluong'];
			$tongtien 	= $item['tongtien'];
			$thanhtoan	+=$tongtien;
			// echo "<li>{$name}</li>";
			echo '<li><div class="cart-item"><div class="image"><img src="'.$srcImg.'" alt=""></div><div class="item-description"><p class="name">'.$name.'</p><p>Số lượng: <span class="light-red">'.$soluong .'</span></p></div><div class="right"><a href="" class="remove"><img src="/templates/tpshop/images/remove.png" alt="remove"></a></div></div></li>';
		}
		echo '<li><span class="total">Tổng tiền <strong>'.number_format($thanhtoan).',000đ</strong></span></li><li><a class=" checkout button" href="/Gio-hang">Đến giỏ hàng</a></li></ul>';
    }
    public function changeSluong(Request $request){
    	$id = $request->idSP;
    	$gt = $request->GTri;
     	$arCart = $request->session()->get('cart');
     	if($gt == 1) {
     		 $arCart[$id]['soluong'] ++;
     	}
     	else {
     		$arCart[$id]['soluong'] --;
     	}
		$arCart[$id]['tongtien'] = $arCart[$id]['soluong']*$arCart[$id]['gia'];
     	$request->session()->put('cart',$arCart);
        if(Auth::check()) {
            $arItem = array(
               'id_user'       => Auth::user()->id,
               'id_product'    => $id,
               'soluong'       => $arCart[$id]['soluong'],
            ); 
           Cart::editCart($arItem);
        }
     	return redirect()->back();

    }

    public function delCart($id,Request $request){
    	if($id == 0) {
    		$request->session()->forget('cart');
            
    	} else {
    		$arCart = $request->session()->get('cart');
	     	if(isset($arCart[$id])){
	     		unset($arCart[$id]);
	     	} 
	     	$request->session()->put('cart',$arCart);
    	}
        if(Auth::check()) {
            Cart::delCart(Auth::user()->id,$id);    
        }
    	return redirect()->back();
    }


}
