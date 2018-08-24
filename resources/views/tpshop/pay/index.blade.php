@extends('templates.tpshop.master')
@section('main')
@php
if(Session::has('cart')){
	$arCart = Session::get('cart');
}
@endphp
<div class="container_fullwidth">
	<div class="container shopping-cart">
		<div class="row">
			<div class="cart-info" style="margin-bottom: 50px ;">
                <div class="items01">GIỎ HÀNG</div>
                <div class="items02"></div>
                <div class="items03">THANH TOÁN</div>
                <div class="items04"></div>
                <div class="items05">ĐƠN HÀNG ĐÃ ĐẶT</div>
            </div>
		</div>
		
		<div class="row " style="margin: 20px" >
			<div class="col-md-offset-3 col-md-6 ">
				<div style=" font-size: 14px">
					<h4 class="h4" style="margin: 10px" >Địa chỉ nhận hàng của bạn: <strong>{{$user->username}}</strong> </h4>
					<div class="well">
						<table class="table">
						<tbody>
							<tr>
								<td class="col-md-4">Họ Tên:</td>
								<td class="col-md-8">{{isset($objAddress) ? $objAddress->fullname : ""}}</td>
							</tr>
							<tr>
								<td class="col-md-4">Email:</td>
								<td class="col-md-8">{{$user->email}}</td>
							</tr>
							<tr>
								<td class="col-md-4">Số điện thoại:</td>
								<td class="col-md-8">{{isset($objAddress) ? $objAddress->phone : ""}}</td>
							</tr>
							<tr>
								<td class="col-md-4">Địa chỉ:</td>
								<td class="col-md-8"> 
									@if(isset($objAddress))
									{{$objAddress->address}}, {{$diachi->ptype}} {{$diachi->pname}} - {{$diachi->qtype}} {{$diachi->qname}} - {{$diachi->ttype}} {{$diachi->tname}} 
									@endif
								</td>
							</tr>
						</tbody>
					</table>
					<a href="{{route('tpshop.user.edit',$user->id)}}">Cập nhật thông tin</a>
					</div>
					
				</div>
			</div>
		</div>
		<div class="row ">
			<div class="col-md-offset-3 col-md-6 ">
			<div style="background: #fff; font-size: 18px">
				<h4 class="h4" style="margin: 10px" >Phương Thức Thanh Toán: </h4>
				@php $i = 0 ; @endphp
				@foreach($objPayMethod as $method)				
				<div class="col-md-offset-3 col-md-6 " id="paymethod">
					<label><input type="radio" name="paymethod"  value="{{$method->id}}"  {{ ($i == 0) ? 'checked' : '' }} > {{ucwords($method->name)}}</label>
				</div>
				<input type="hidden" name="methodpay" id="methodpay"   value="" >
				@php $i++ @endphp
				@endforeach
				{{-- <div  class="col-md-offset-3 col-md-6 ">
					<label ><input type="radio" name="paymethod" value="1" > Thanh Toán Trực Tuyến</label>
				</div> --}}
			</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div style=" font-size: 14px">
					<h5 class="h5" style="margin: 10px" >Sản Phẩm Cần Thanh Toán</h5>
					
					<table class="table table-bordered  table-hover">
						<tr >

							<th class="text-center">Hình Ảnh</th>
							<th class="text-center">Sản phẩm</th>
							<th class="text-center">Thuộc tính</th>
							<th class="text-center">Đơn Giá</th>
							<th class="text-center">Số lượng</th>
							<th class="text-center">Thành Tiền </th>
						</tr>
						<tbody>
							@php
								$thanhtoan = 0;
								$arSL = array();
							@endphp
						@if(Session::has('arPayItems'))
							@php
							$arPayItems = Session::get('arPayItems');
							foreach ($arPayItems as $value) {
								$tmp = explode('-', $value);
								$arID[] = $tmp[0];
								$arTT[$tmp[0]] = $tmp[1];
								$strID = implode(',', $arID);
								$strTT = implode(',', $arTT);
								
							}
							// dd($arID);
							// dd($strID.'='.$strTT);
							@endphp
							
							@if(isset($arCart))
							@foreach($arCart as $id => $item)
							@if( in_array($id, $arID) )
								@php
								$srcImg = '/storage/app/files/upload/'.$item['picture'];
								$name 		= $item['name'];
								$gia 		= $item['gia'];
								$soluong 	= $item['soluong'];
								$tongtien 	= $item['tongtien'];
								$thanhtoan	+=$tongtien; 
								$arSL[]		= $soluong;
								@endphp
							<tr>
								<td>
									<img src="{{$srcImg}}" alt="" style="width: 50px;">
								</td>
								<td  >
									<div class="shop-details">
										<div class="productname">{{$name}}</div>
									</div>	
								</td>
								<td class="text-center">
									@foreach($arTT as $tid => $tt)
									@if($tid == $id)
									@php
									$tmp = explode('/', $tt);
									$color = $tmp[0];
									$size = (!empty($tmp[1]))? $tmp[1] : 0;
									@endphp

									<div>
										@php 
										$itemSize = App\Model\Size::find($size) ;
										@endphp
										<p>Màu: <a style="margin: 0 5px; padding:7px 15px 0 7px; background: {{$color}}"></a></p>
										<p>Size: <strong>{{$itemSize->value }}</strong></p>
									</div>	
									@endif
									@endforeach
								</td>
								<td class="text-center">
									<h5>{{number_format($gia)}},000đ</h5>
								</td >
								<td class="text-center">{{$soluong }}</td>
								<td class="text-center">
									<h5><strong class="red">{{number_format($tongtien)}},000đ</strong></h5>
								</td>
							</tr>
							@endif
							@endforeach
							@endif
							@php
								$strSL = implode(',', $arSL);
								$arOrder = array(
									'id_user' 		=> $user->id,
									'id_product' 	=> $strID,
									'soluong' 		=> $strSL ,
									'thuoctinh' 	=> $strTT,
								);
							@endphp
						@endif	
						</tbody>
						<tfoot>
							<tr style="background-color: #ededed; font-size: 17px; height: 50px; line-height: 50px">
								<td colspan="6" class="text-center">Tổng Thanh Toán: <strong class="red">{{ number_format($thanhtoan)}},000đ</strong>
								</td>
							</tr>
						</tfoot>
					</table>
					@if(isset($arOrder))
					<center><a class="btn btn-danger"  href="javascript:void(0)"  data-toggle="modal" data-target="#payCart" id="dathang">Đặt Hàng</a></center>
					@else 
					<center><a class="btn btn-danger"  href="javascript:void(0)" data-toggle="modal" data-target="#aleartModel2"  id="dathang">Đặt Hàng</a></center>
					@endif 
				</div>
			</div>
		</div>
		
	</div>
	<div class="clearfix"></div>
</div>

	<div id="payCart" class="modal fade" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Thông Tin Thanh Toán</h5>
            </div>
            <div class="modal-body" style="font-size: 15px; ">
            	<div class="row">
            		<div class="form-group">
					    <label class="control-label col-sm-3" >Mã Giảm Giá:</label>
					    <div class="col-sm-6"> 
					      <input type="text" style="margin-top: -1px;margin-left: 10px; border-radius: 3px;height: 25px " name="magiamgia" class="form-control" id="magiamgia" />
					      <input type="hidden" id="tiengiamgia" name="tiengiamgia" value="0">
					    </div>
					    <button type="button" class="btn btn-success btn-xs" onclick="return checkMa({{$thanhtoan}})" >Sử dụng</button>
					</div>
					<div class="form-group" style="margin: 20px 0 ">
					    <label class="control-label col-sm-3" >Vận chuyển:</label>
					    <div class="col-sm-6"> 
					        <select class="form-control" id="vanchuyen" name="vanchuyen" onchange="return vanchuyen({{$thanhtoan}})" >
					        	@foreach( $objVanchuyen as $vanchuyen )
	                            <option value="{{$vanchuyen->id}}">Giao Hàng {{$vanchuyen->name}}</option>
	                            @endforeach
                            </select>
                            <label style="margin: 20px 10px " id="thongtin" >Nhận hàng từ 5 đến 7 ngày: 30.000đ</label>
					    </div>
					</div>

            	</div>
            	
            	<div class="row" style="margin: 30px 20px">
            		<h5 style="padding: 10px">SỐ TIỀN THANH TOÁN</h5>
            		<div class="table-responsive">
            			<table class="table ">
            				<tbody>
            					<tr>
            						<td>Đơn giá</td>
            						<td>{{ number_format($thanhtoan)}},000đ</td>
            					</tr>
            					<tr>
            						<td>Giảm giá</td>
            						<td id="giamgia">-0.000đ</td>
            					</tr>
            					<tr>
            						<td>Phí giao hàng</td>
            						<td id="phigiaohang">+30.000đ</td>
            					</tr>
            					<tr style="background: #C0DDE3; color: #1C0AA5; ">
            						<td>Tổng Cộng:</td>
            						<td id="tongcong"  style="color: #C9230D; font-size: 18px; font-weight: bold; " >{{ number_format($thanhtoan + 30)}},000đ</td>
            					</tr>
            				</tbody>
            			</table>
            		</div>
            	</div>
            </div>
            <center style="margin-bottom: 20px;" id="btn-paypal" >
            	<h4 style="margin-bottom: 20px;">Thanh toán bằng Paypal</h4>
            	<div id="paypal-button"></div>
            </center>
            <center style="margin: 20px auto;" id="btn-pay" >
            	<button type="button" class="btn btn-danger" onclick="return payOrder( {{$user->id}},'{{$strID}}','{{$strSL}}','{{$strTT}}',{{$thanhtoan}} )"  style="margin-right: 10px ;" >Hoàn Tất</button>
            </center>
         </div>
      </div>
   </div>

	@if(!isset($objUser))
	<div id="aleartModel" class="modal fade in" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Thông Báo</h5>
            </div>
            <div class="modal-body text-center" id="content" width="100px" style="font-size: 19px; ">
              Trước khi Thanh toán, Bạn cần phải Đăng Nhập,...
            </div>
            <center style="margin: 20px auto;">
            <button type="button" class="btn btn-danger" onclick="return login()" data-dismiss="modal" style="margin-right: 10px ;" >Đăng Nhập Ngay</button>
            </center>
         </div>
      </div>
   </div>
   @endif

	@if(!isset($objAddress))
	<div id="aleartModel1" class="modal fade in" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Thông Báo</h5>
            </div>
            <div class="modal-body text-center" id="content" width="100px" style="font-size: 19px; ">
              Bạn cần thêm ĐỊA CHỈ GIAO HÀNG..
            </div>
            <center style="margin: 20px auto;">
           <a class="btn btn-danger"  href="{{route('tpshop.user.edit',$user->id)}}">Cập nhật ngay</a>

            </center>
         </div>
      </div>
   </div>
   @endif
   <div id="aleartModel2" class="modal fade in" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Thông Báo</h5>
            </div>
            <div class="modal-body text-center" id="content" width="100px" style="font-size: 19px; ">
              Đơn hàng rỗng
            </div>
            <center style="margin: 20px auto;">
           <a class="btn btn-danger"  href="{{route('tpshop.index.index')}}">Mua thêm hàng</a>
            </center>
         </div>
      </div>
   </div>

<script>

	jQuery("#aleartModel").modal("show");
	jQuery("#aleartModel1").modal("show");
	function login(){
		jQuery("#singin").modal("show");
	}
	jQuery("#dathang").click(function(){
		getPayMethod();
	});
	function getPayMethod(){
		var Paymethod = jQuery('input[name=paymethod]:checked').val();
		//alert(Paymethod);
		if(Paymethod == 2) {
			jQuery("#btn-pay").hide();
			jQuery("#btn-paypal").show();
		} else {
			jQuery("#btn-pay").show();
			jQuery("#btn-paypal").hide();
		}
	}

	function payOrder(user_id,strID,strSL,strTT){
		var Vanchuyen = jQuery("#vanchuyen").val();
		var MaCode = jQuery("#magiamgia").val();
		var Paymethod = jQuery('input[name=paymethod]:checked').val();
		var tongtien = jQuery('#tongcong').text();
		var tmp = tongtien.split(",000đ");
		var thanhtoan = tmp[0];
		thanhtoan = thanhtoan.replace(',','');
		jQuery.ajax({
	        url: '{{route('tpshop.pay.addorder')}}',
	        type: 'GET',
	        cache: false,
	        data: {user_id : user_id  ,strID : strID,strSL : strSL,strTT : strTT ,thanhtoan : thanhtoan, Vanchuyen: Vanchuyen , MaCode: MaCode , Paymethod: Paymethod },
	        success: function(data){
	        	if(data) {
	        		location.replace('/don-hang'); 
	        	} else {
	        		alert('Có lỗi khi thanh toán! Vui lòng thử lại sau');
	        		location.reload()
	        	}
	        }, 
	        error: function() {
	           alert("Có lỗi");
	        }
	    }); 


	}
	function checkMa(dongia){
		var magiamgia = jQuery("#magiamgia").val();
		var vanchuyen = jQuery("#vanchuyen").val();
		var phigiaohang;
		if(vanchuyen == 1 ) {
			phigiaohang = 30;
		} else {
			phigiaohang = 50;
		}
		jQuery.ajax({
	        url: '{{route('tpshop.pay.checkcode')}}',
	        type: 'GET',
	        cache: false,
	        data: {dongia: dongia,magiamgia: magiamgia },
	        success: function(data){
	        	if(data == 'error'){
	        		alert("Mã giảm giá không hợp lệ!");
	        	} else if(data == '0') {
	        		alert("Đơn hàng chưa đủ điều kiện nhận mã giảm giá");
	        	} else {
	        		alert("Nhập mã giảm giá thành công, Đơn hàng được giảm "+data+",000đ" );
	        		jQuery("#giamgia").html("-"+data+",000đ");
	        		jQuery("#tongcong").html(dongia-data+phigiaohang+",000đ");
	        		jQuery("#tiengiamgia").val(data);
	        	}
	          
	        }, 
	        error: function() {
	           alert("Có lỗi");
	        }
	    }); 
	}
	function vanchuyen(dongia){
		var vanchuyen = jQuery("#vanchuyen").val();
		var giamgia = jQuery("#tiengiamgia").val();
		if(vanchuyen==1) {
			jQuery("#thongtin").html("Nhận hàng từ 5 đến 7 ngày: 30.000đ");
			jQuery("#phigiaohang").html("+30.000đ");
			var phigiaohang = 30;

		} else {
			jQuery("#thongtin").html("Nhận hàng từ 3 đến 5 ngày: 50.000đ");
			jQuery("#phigiaohang").html("+50.000đ");
			var phigiaohang = 50;
		}

		jQuery.ajax({
	        url: '{{route('tpshop.pay.tinhtien')}}',
	        type: 'GET',
	        cache: false,
	        data: {dongia: dongia,vanchuyen: phigiaohang,giamgia: giamgia },
	        success: function(data){
	           // alert(data);
	           jQuery("#tongcong").html(data);
	        }, 
	        error: function() {
	           alert("Có lỗi");
	        }
	    }); 
	}

	var tongtien = jQuery('#tongcong').text();
	var tmp = tongtien.split(",000đ");
	var thanhtoan = tmp[0];
	thanhtoan = thanhtoan.replace(',','');
	var dolar = thanhtoan/22;
	dolar = parseFloat(dolar).toFixed(2);
	//alert(dolar);
	paypal.Button.render({
	  // Configure environment
	  env: 'sandbox',
	  client: {
	    sandbox: 'AUSeLXb5nVADSj91f6IOhGa-y3Fs_vNnDg7jd8bBbKiz3OmeRgoAKi0YXjD_ESK-97LmoBOIXG8U3NZ8',
	    production: 'demo_production_client_id'
	  },
	  // Customize button (optional)
	  locale: 'en_US',
	  style: {
	    size: 'small',
	    color: 'gold',
	    shape: 'pill',
	  },
	  // Set up a payment
	  payment: function (data, actions) {
	    return actions.payment.create({
	      transactions: [{
	        amount: {
	          total: dolar,
	          currency: 'USD'
	        }
	      }]
	    });
	  },
	  // Execute the payment
	  onAuthorize: function (data, actions) {
	    return actions.payment.execute()
	      .then(function () {
	        // Show a confirmation message to the buyer
	        alert('Thanh toán thành công, Đơn hàng sẽ sớm được gửi đến bạn..');
	        jQuery("#btn-pay").show();
	      });

	  }
	}, '#paypal-button');
	
</script>

	@endsection
