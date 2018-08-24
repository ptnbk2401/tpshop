<?php

namespace App\Http\Controllers\Tpshop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Diachi;
class AjaxController extends Controller
{
    
    public function changeQuan(Request $request){
        $Id_Tinh = $request->Id_Tinh;
        $objQuan = Diachi::getQuan();
        foreach ($objQuan as $quan) {
            if($quan->provinceid == $Id_Tinh ) {
                echo '<option value="'.$quan->districtid.'">'.$quan->type.' '.$quan->name.'</option>';
            }
        }
    }
    public function changePhuong(Request $request){
    	$Id_Quan = $request->Id_Quan;
    	$objPhuong = Diachi::getPhuong();
        foreach ($objPhuong as $phuong) {
            if($phuong->districtid == $Id_Quan ) {
                echo '<option value="'.$phuong->wardid.'">'.$phuong->type.' '.$phuong->name.'</option>';
            }
        }
    }

  


}
