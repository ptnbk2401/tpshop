<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Yes24;
use App\Model\Cat;
use App\Model\Product;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Pagination\LengthAwarePaginator;
use Storage;

class AYes24Controller extends Controller
{
	public function __construct(Yes24 $objYes24,Product $objProduct){
		$this->objYes24 = $objYes24;
		$this->objProduct = $objProduct;
	}
	public function checkLink(Request $request){
    	$idcat = $request->idcat;
		if(!empty( $this->objYes24->getYes24ByIdCat($idcat)->link )){
			$msg = $this->objYes24->getYes24ByIdCat($idcat)->link;
		} else $msg = "";
		return response()->json(array('msg'=> $msg),200);       
    }

    public function getTin(Request $request){
    	$idcat = $request->idCat;
    	
    	$objItem = $this->objYes24->getYes24ByIdCat($idcat);
    	if(isset($objItem)){
    		$url = $objItem->link;
    		$html = HtmlDomParser::file_get_html($url);
	    	$arTin = $html->find('li.th-product-item-wrap');
	        $i=1;
	        $data="";
			foreach( $arTin as  $item){
			    $tensanpham    	= $item->find('div.th-product-info h3 a',0)->plaintext;
			    $urltin    		= $item->find('div.th-product-info h3 a',0)->href;
			    $Gia    		= $item->find('.th-product-price ',0)->plaintext;
			    $urlImg  		= $item->find('div.th-product-item a img.lazyload ',0)->getAttribute('data-src');
			    
			    $tmp = explode(',000đ ', $Gia);
			    $GiaSale = $tmp[0]; 
			    $GiaGoc = $tmp[1];
			    $data .="<tr><td class='text-center'>{$i}</td><td><a href='{$urltin}' target='_blank' >{$tensanpham}</a></td><td><img src='{$urlImg}' style='width: 150px;' /></td><td>{$GiaGoc}</td><td>{$GiaSale}</td></tr>";
			    if($i==15) break;
			    else $i++;

			}
    	} else {
    		$data="<h2 style='color: red'>Đang Cập nhật Link</h2>";
    	}
    	
		return $data;       
    }

    public function saveTin(Request $request){
    	$objYes24 = new Yes24();
    	$idcat = $request->idcat;
    	$objItem = $objYes24->getYes24ByIdCat($idcat);
    	if(isset($objItem)){
    		$url = $objItem->link;
    		$html = HtmlDomParser::file_get_html($url);
	    	$arTin = $html->find('li.th-product-item-wrap');
	        $i=1;
	        $msg="";
			foreach( $arTin as  $item){
			    $tensanpham    	= $item->find('div.th-product-info h3 a',0)->plaintext;
			    $urltin    		= $item->find('div.th-product-info h3 a',0)->href;
			    $Gia    		= $item->find('.th-product-price ',0)->plaintext;
			    $urlImg  		= $item->find('div.th-product-item a img.lazyload ',0)->getAttribute('data-src');
			    // $chitietsanpham = HtmlDomParser::file_get_html($urltin)->find('div.tr-prd-info-detail div.tr-prd-info-content',0)->innertext;
			   
			    $tmp = explode(',000đ ', $Gia);
			    $GiaSale = $tmp[0]; 
			    $GiaGoc = $tmp[1];

			    // // save hinh anh vào app/files
       //          $contents = file_get_contents($urlImg);
       //          $Imgname = substr($urlImg, strrpos($urlImg, '/') + 1);
                
				// if(Storage::put('/files/upload/'.$Imgname, $contents)){
				// 	$msg="Lỗi LUU Anh";
				// 	break;
				// }
			    $arPost = array(
		    		'name'		=> $tensanpham,
		    		'id_cat'	=> $idcat,
		    		'price_old'	=> trim($GiaGoc),
		    		'price_new'	=> trim($GiaSale),
		    		'picture'	=> $urlImg,
		    		'detail'	=> $urltin
		    	);
				
				
				//$this->objYes24->addPostYes24($arPost);
				$this->objProduct->addProduct($arPost);
				

			    if($i==15) {
			    	$msg="Lưu Thành Công";
			    	break;
			    }
			    else $i++;

			}
    	} else {
    		$msg="Lỗi";
    	}
		return $msg;       
    }
}

