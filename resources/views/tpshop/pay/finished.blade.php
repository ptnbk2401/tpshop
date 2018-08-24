<?php 
	use App\Model\Product;
?>

@extends('templates.tpshop.master')
@section('main')
<div class="container_fullwidth">
	<div class="container shopping-cart">
		<div class="row">
			<div class="cart-finished" style="margin-bottom: 50px ;">
                <div class="items01">GIỎ HÀNG</div>
                <div class="items02"></div>
                <div class="items03">THANH TOÁN</div>
                <div class="items04"></div>
                <div class="items05">ĐƠN HÀNG ĐÃ ĐẶT</div>
            </div>
		</div>
		<div class="row">
			<h3 style="margin-bottom: 20px">Các Đơn Hàng Đã Đặt:</h3>
			<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
						<tr>
							<th style="width: 400px">Sản Phẩm</th>
							<th>Tổng tiền</th>
							<th>Ngày Đặt Hàng</th>
							<th>Trạng thái đơn hàng</th>
						</tr>
					</thead>
					<tbody>
						@foreach($objOrder as $order)
						@php
						$created_at = date("l, d-m-Y  | h:m A", strtotime($order->created_at));
						$trangthaidonhang = ($order->trangthaidonhang == -1)? 'Đang Xử Lí' : (($order->trangthaidonhang == 0)? 'Đang Vận Chuyển' : 'Đã Hoàn Thành') ;
						$arID = explode(',', $order->id_product);
						$arSL = explode(',', $order->soluong);
						$i=0;
						@endphp
						<tr>
							<td>
								@foreach($arID as $id)
								@php
									$objProduct = Product::find($id);
								@endphp
								<div class="products-div">
									<img src="/storage/app/files/upload/{{$objProduct->picture}}" alt="">
									<div class="left">
										<h6 >{{$objProduct->name}}</h6>
          								<p>Số lượng: {{ $arSL[$i++] }}</p>
									</div>
								</div>
								<hr>
								@endforeach
							</td>
							<td class="text-center">{{number_format($order->money_pay).",000đ"}}</td>
							<td>{{$created_at}}</td>
							<td>{{$trangthaidonhang}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

	<div id="aleartModel" class="modal fade" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Thông Báo</h5>
            </div>
            <div class="modal-body text-center" id="content" width="100px" style="font-size: 19px; ">
               
            </div>
            <center style="margin: 20px auto;">
            <button type="button" class="btn btn-info" data-dismiss="modal" style="margin-right: 10px ;" >OK</button>
            </center>
         </div>
      </div>
   </div>

<script>
	// function changeSoluong(id,gt) {
	// 	$val = "#soluong-"+id;
	// 	if(jQuery($val).val() == 1 && gt==-1 ){
	// 		jQuery("#aleartModel").modal("show");
	// 		jQuery("#content").html("Số lượng sản phẩm không được nhỏ hơn 1");
	// 	} else {
	// 		jQuery.ajax({
	// 	        url: '{{route('tpshop.cart.changesl')}}',
	// 	        type: 'GET',
	// 	        cache: false,
	// 	        data: {idSP: id,GTri: gt },
	// 	        success: function(data){
	// 	            //alert(data);
	// 	           // jQuery("#tpshop").html(data);
	// 	           location.reload()
	// 	        }, 
	// 	        error: function() {
	// 	           alert("Có lỗi");
	// 	        }
	// 	    }); 
	// 	}
        
 //       return false;
	// }
</script>
	
	@endsection
