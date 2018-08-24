@extends('templates.tpshop.master')
@section('main')
<div class="container_fullwidth">
	@php
	if(Session::has('cart')){
		$arCart = Session::get('cart');
	}
	@endphp
	<div class="container shopping-cart">
		<div class="row">
			<div class="cart-direct" style="margin-bottom: 50px ;">
				<div class="items01">GIỎ HÀNG</div>
				<div class="items02"></div>
				<div class="items03">THANH TOÁN</div>
				<div class="items04"></div>
				<div class="items05">ĐƠN HÀNG ĐÃ ĐẶT</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="shop-table">
					<thead>
						<tr>
							<th><input type="checkbox"  value="1" id="checkall" /></th>
							<th>Hình Ảnh</th>
							<th>Sản phẩm</th>
							<th>Đơn Giá</th>
							<th>Số lượng</th>
							<th>Thành Tiền </th>
							<th>Hủy Đơn Hàng</th>
						</tr>
					</thead>
					<tbody>
						@php
						$thanhtoan = 0;
						$arID = "";
						@endphp
						@if(isset($arCart))
						@foreach($arCart as $id => $item)
						@php
						$srcImg = '/storage/app/files/upload/'.$item['picture'];
						$name 		= $item['name'];
						$gia 		= $item['gia'];
						$soluong 	= $item['soluong'];
						$tongtien 	= $item['tongtien'];
						$thanhtoan	+=$tongtien; 
						$arID 		.= $id.'-';
						$objProductItem = App\Model\Product::find($id);
						$Size = (!empty($objProductItem->id_size)) ? explode(',',$objProductItem->id_size) : "";
						$Color = (!empty($objProductItem->color)) ? explode(',',$objProductItem->color) : "";
						
						@endphp
						<tr>
							<td>
								<input type="checkbox" name="sanpham" value="{{$id}}" checked class="checked" id="sanpham-{{$id}}">
							</td>
							<td>
								<img src="{{$srcImg}}" alt="">
							</td>
							<td style="text-align: left; padding-left: 30px; ">
								<div class="shop-details">
									<div class="productname">{{$name}}</div>
								</div>
								<div id="thuoctinh-{{$id}}" class="thuoctinh">
									<div class="size">
					               		<h4 class="h4" style="display: inline; margin-right: 15px">Size: </h4>
			        					<ul class="ul-size-{{$id}}" style="display: inline;">
						                @php 
						                $i=0;
						                @endphp
						                @if(!empty($Size))
						                @foreach($Size as $size)
						                	<?php
						                		$itemSize = App\Model\Size::getItemByID($size) ;
						                		$i++;
						                	?>
						                  <li class="{{($i==1) ? 'active' : '' }} size-li-{{$id}}" id="size-{{$id}}-{{$itemSize->id}}" onclick="return setActiveSize({{$itemSize->id}},{{$id}})" data-value="{{$itemSize->id}}" ><a href="javascript:void(0)">{{$itemSize->value}}</a></li>
						                @endforeach  
						                @endif
						                </ul>	
			              			</div>
									<div class="clolr-filter color">
										<h4 class="h4" style="margin: 15px 0; " >Màu sắc: </h4>
			        					<ul class="ul-color-{{$id}}">
			        					@php 
						                $i=0;
						                @endphp
						                @if(!empty($objProductItem->color))
						                @foreach($Color as $color)
						                	<?php
						                		$i++;
						                	?>
						                  <li class="{{($i==1) ? 'active' : '' }} color-li-{{$id}} " id="color-{{$color}}" onclick="return setActiveColor('{{$color}}',{{$id}})" data-value="{{$color}}"  ><a href="javascript:void(0)" style="background-color: {{$color}}; border: 1px solid #000"></a></li>
						                @endforeach
						                @else
						                <li class="color-li no-color active" data-value="0" >Như hình</li>
						                @endif  
						                </ul>	
			              			</div>
								</div>	
							</td>
							<td>
								<h5>{{number_format($gia)}},000đ</h5>
							</td>
							<td >
								<div class="items04">
									<button onclick="changeSoluong({{$id}},-1)" style="font-size: 10px;padding: 3px 6px;"><i class="fa fa-minus"></i></button>
									<input type="text" readonly name="soluong-{{$id}}" id="soluong-{{$id}}" value="{{$soluong}}" maxlength="3" style="width: 30px;padding: 3px 6px" />
									<button onclick="changeSoluong({{$id}},1)"  style="font-size: 10px;padding: 3px 6px;"><i class="fa fa-plus"></i>
								</div>
							</td>
							<td>
								<h5><strong class="red">{{number_format($tongtien)}},000đ</strong></h5>
							</td>
							<td>
								<a href="{{ route('tpshop.cart.delcart',$id) }}">
									<img src="{{$urlTpshop}}/images/remove.png" alt="">
								</a>
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
					<tfoot>
						<tr style="background-color: #ededed; font-size: 17px; height: 50px; line-height: 50px">
							<td colspan="5" style="padding-left: 20px; font-size: 13px; ">
								<a href="{{ route('tpshop.cart.delcart',0) }}" >Hủy Giỏ Hàng</a>
							</td>
							<td style="padding-left: 410px; font-weight: bold; " >Tổng Cộng: <b style="color: #0283B9">{{ number_format($thanhtoan)}},000đ</b></td>
						</tr>
						<tr>
							<td colspan="6">
								@if(isset($objUser))
								<a class="pull-right button" id="pay" onclick="return getCartPay('{{$arID}}')" href="javascript:void(0) ">ĐẶT HÀNG</a> 
								@else
								<a class="pull-right button"  href="javascript:void(0)" data-toggle="modal" data-target="#singin" >ĐẶT HÀNG</a> 
								@endif
								<a class="pull-right button "  href="{{route('tpshop.index.index')}} ">TIẾP TỤC MUA HÀNG</a>
							</td>
						</tr>
					</tfoot>
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

			jQuery("#checkall").click(function(){
				var val = jQuery("#checkall").val();
				if(val == 1){
					jQuery(".checked").prop('checked', true);
					jQuery("#checkall").attr('value','0');
				} else {
					jQuery(".checked").prop('checked', false);
					jQuery("#checkall").attr('value','1');
				}
			});	

			function getCartPay(strID) {
				var arId = (strID.split("-"));
				var arIDchecked = new Array();
				var dem = 0;
				arId.forEach(function(element){
					if(element){
						var id = "#sanpham-"+element;
						if(jQuery(id).prop('checked')){
							var value_size = jQuery('ul.ul-size-'+element).find('li.active').data('value');
							var value_color = jQuery('ul.ul-color-'+element).find('li.active').data('value');
							var value = value_color+'/'+value_size;
							arIDchecked[dem++] = element+'-'+value;
						}
					}
				});
				jQuery.ajax({
					url: '{{route('tpshop.pay.getItems')}}',
					type: 'GET',
					cache: false,
					data: { arID: arIDchecked},
					success: function(data){
			           //alert(data);
			           // jQuery("#tpshop").html(data);
			           location.replace('/thanh-toan'); 
			       }, 
			       error: function() {
			       	alert("Có lỗi");
			       }
			   }); 
				
			}
			function changeSoluong(id,gt) {
				$val = "#soluong-"+id;
				if(jQuery($val).val() == 1 && gt==-1 ){
					jQuery("#aleartModel").modal("show");
					jQuery("#content").html("Số lượng sản phẩm không được nhỏ hơn 1");
				} else {
					jQuery.ajax({
						url: '{{route('tpshop.cart.changesl')}}',
						type: 'GET',
						cache: false,
						data: {idSP: id,GTri: gt },
						success: function(data){
				            //alert(data);
				           // jQuery("#tpshop").html(data);
				           location.reload()
				       }, 
				       error: function() {
				       	alert("Có lỗi");
				       }
				   }); 
				}

				return false;
			}

			function setActiveSize(id,idPro) {
				var li = "#size-"+idPro+"-"+id;
				var active = "active size-li-"+idPro;
				var size_li = "size-li-"+idPro;
				jQuery('.size-li-'+idPro).attr('class',size_li);
				jQuery(li).attr('class',active);
				var interest = jQuery('ul.ul-size-'+idPro).find('li.active').data('value');
    			// alert(interest);
			}
			function setActiveColor(color,idPro) {
				var li = "#color-"+idPro+"-"+color;
				var active = "active color-li-"+idPro;
				var color_li = "color-li-"+idPro;
				jQuery('.color-li-'+idPro).attr('class',color_li);
				jQuery('.'+color_li+'[data-value="'+color+'"').attr('class',active);
				var interest = jQuery('ul.ul-color-'+idPro).find('li.active').data('value');
    			// alert(interest);
			}
			

			
		</script>

		@endsection
