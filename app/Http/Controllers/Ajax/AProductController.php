<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cat;
use App\Model\Product;
use App\Model\Size;
use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Pagination\LengthAwarePaginator;
use Storage;


class AProductController extends Controller
{
	public function __construct(Product $objProduct,Size $objSize){
        $this->objProduct = $objProduct;
		$this->objSize    = $objSize;
	}
	public function CheckedHot(Request $request){
    	$id = $request->idPost;
    	$objSP = Product::find($id);
    	$hot = $objSP->hot;
    	if($hot == 0) {
    		$this->objProduct->editHot($id,1);
    		return '<input onchange="return changeHot('.$id.')" type="checkbox" checked >';
    	} else {
    		$this->objProduct->editHot($id,0);
    		return '<input onchange="return changeHot('.$id.')" type="checkbox"  >';
    	}
    	
    }
    public function CheckedSale(Request $request){
        $id = $request->idPost;
        $objSP = Product::find($id);
        $sale = $objSP->sale;
        if($sale == 0) {
            $this->objProduct->editSale($id,1);
            return '<input onchange="return changeSale('.$id.')" type="checkbox" checked >';
        } else {
            $this->objProduct->editSale($id,0);
            return '<input onchange="return changeSale('.$id.')" type="checkbox"  >';
        }
    }
    public function changeSize(Request $request){
        $type = $request->type;
        //echo $type;
        $objSize = $this->objSize->getItemByType($type);        
        foreach ($objSize as  $size) {
            echo '<option value="'.$size->id.'">'.$size->value.'</option>';
        }
    }   
	public function selectColor(Request $request){
    	$color = $request->color;
        if($request->session()->has('Color')){
            $arColor = $request->session()->get('Color');
        } else {
            $arColor = array();
        }
        $arColor[] = $color;
        $request->session()->flash('Color',$arColor);
    	foreach ($arColor as  $color) {
            echo '<option selected value="'.$color.'" >'.$color.'</option>';
        }
    }	
}

