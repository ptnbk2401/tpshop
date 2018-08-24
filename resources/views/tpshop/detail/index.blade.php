@extends('templates.tpshop.master')
@section('main')
<div class="container_fullwidth">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="products-details">
					@php 
					$name = $objProductItem->name;
					$srcImg = '/storage/app/files/upload/'.$objProductItem->picture;
					$offer = 100-round(($objProductItem->price_new/$objProductItem->price_old)*100); 
					$price_new = $objProductItem->price_new;
					$price_old = $objProductItem->price_old;
					$detail = $objProductItem->detail;
					$preview = $objProductItem->preview;
					$Size = explode(',',$objProductItem->id_size);
					$Color = explode(',',$objProductItem->color);
					@endphp
					<div class="preview_image">
						<div class="preview-small">
							<img id="zoom_03" src="{{$srcImg}}" data-zoom-image="{{$srcImg}}" alt="">
						</div>
						<div class="thum-image">
							<ul id="gallery_01" class="prev-thum">
								<li>
									<a href="#" data-image="images/products/medium/products-01.jpg" data-zoom-image="images/products/Large/products-01.jpg">
										<img id="zoom_03" src="{{$srcImg}}"  alt="">
									</a>
								</li>
							</ul>
							<a class="control-left" id="thum-prev" href="javascript:void(0);"><i class="fa fa-chevron-left"></i></a>
							<a class="control-right" id="thum-next" href="javascript:void(0);"><i class="fa fa-chevron-right"></i></a>
						</div>
					</div>
					<div class="products-description">
						<h5 class="name">
							{{$name}}
						</h5>
						<p>
							{!! $preview !!}
						</p>
						<hr class="border">
						<div class="thuoctinh">
							<div class="size">
			               		<h4 class="h4" style="display: inline; margin-right: 15px">Size: </h4>
	        					<ul class="ul-size" style="display: inline;">
				                @php 
				                $i=0;
				                @endphp
				                @if(!empty($Size))
				                @foreach($Size as $size)
				                	<?php
				                		$itemSize = App\Model\Size::getItemByID($size) ;
				                		$i++;
				                	?>
				                  <li class="{{($i==1) ? 'active' : '' }} size-li" id="size-{{$itemSize->id}}" onclick="return setActiveSize({{$itemSize->id}})" data-value="{{$itemSize->id}}" ><a href="javascript:void(0)">{{$itemSize->value}}</a></li>
				                @endforeach  
				                @endif
				                </ul>	
	              			</div>
							<div class="clolr-filter">
								<h4 class="h4" style="margin: 15px 0; " >Màu sắc: </h4>
	        					<ul class="ul-color">
	        					@php 
				                $i=0;
				                @endphp
				                @if(!empty($objProductItem->color))
				                @foreach($Color as $color)
				                	<?php
				                		$i++;
				                	?>
				                  <li class="{{($i==1) ? 'active' : '' }} color-li " id="color-{{$color}}" onclick="return setActiveColor('{{$color}}')" data-value="{{$color}}"  ><a href="javascript:void(0)" style="background-color: {{$color}}; border: 1px solid #000"></a></li>
				                @endforeach
				                @else
				                <li class="color-li no-color active" data-value="0" >Như hình</li>
				                @endif  
				                </ul>	
	              			</div>
						</div>
						

						<hr class="border">
						<div class="price">
							<span style="font-size: 18px; font-weight: bold;">Giá : </span>
							<span class="new_price">
								{{empty($price_new) ? $price_old : $price_new }}.000<sup>đ</sup>
							</span>
							@if(!empty($price_new))
							<span class="old_price">
								{{$price_old }}.000<sup>đ</sup>
							</span>
							@endif
						</div>
						<hr class="border">
						<div class="wided">
							<div class="button_group">
								<a class="button" onclick="addCart({{$objProductItem->id}})" href="javascript:void(0)" ><i class="fa fa-shopping-cart"></i> Thêm vào Giỏ</a>
							</div>
						</div>
						<div class="clearfix">
						</div>
						<hr class="border">
						<img src="images/share.png" alt="" class="pull-right">
					</div>
				</div>
				<div class="clearfix">
				</div>
				<div class="tab-box">
					<div id="tabnav">
						<ul>
							<li>
								<a href="#Descraption">
									THÔNG TIN SẢN PHẨM
								</a>
							</li>
						</ul>
					</div>
					<div class="tab-content-wrap">
						<div class="tab-content" id="Descraption">
							{!!$detail!!}
						</div>
					</div>
				</div>
				<div class="clearfix">
				</div>
				<div id="productsDetails" class="hot-products">
					<h3 class="title">Sản Phẩm <strong>Bán Chạy</strong> </h3>
					<div class="control">
						<a id="prev_hot" class="prev" href="#">&lt;</a>
						<a id="next_hot" class="next" href="#">&gt;</a>
					</div>
					<ul id="hot">
						<li>
							<div class="row">
								@php
								$k = 1;
								@endphp
								@foreach($objHotItems as $hotitem)
								@php
								if($k==4) break;
								$k++;
								$offer = 100-round(($hotitem->price_new/$hotitem->price_old)*100); 
								$srcImg = '/storage/app/files/upload/'.$hotitem->picture;
								$price_new = $hotitem->price_new;
								$price_old = $hotitem->price_old;
								@endphp
								<div class="col-md-4 col-sm-4">
									<div class="products">

										<div class="thumbnail" style="margin: 15px 0;">
											<a href="{{route('tpshop.detail.index',['slug'=>str_slug($hotitem->name),'id'=>$hotitem->id])}}"><img style="width: auto; height: 220px;" src="{{$srcImg}}" alt="Product Name"></a>
										</div>
										<div class="productname">{{$hotitem->name}}</div>
										<div class="pricediv">
											@if($price_new != 0)
											<span class="price-new">{{$price_new}}.000đ</span>
											<span class="price-old">{{$price_old}}.000đ</span>
											@else
											<span class="price-new">{{$price_old}}.000đ</span>
											@endif
											@if($offer < 100)
											<div class="offer-sale">-{{$offer}}%</div>
											@endif
											<div class="button_group">
												<a href="{{route('tpshop.detail.index',['slug'=>str_slug($hotitem->name),'id'=>$hotitem->id])}}" class="button view-detail" type="button">Chi tiết</a>
											</div>
											<a class="button add-cart" type="button" onclick=" addCart({{$hotitem->id}})" href="javascript:void(0)" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a>
										</div>

									</div>
								</div>
								@endforeach
							</div>
						</li>
						<li>
							<div class="row">
								@php
								$k = 1;
								@endphp
								@foreach($objHotItems as $hotitem)
								@php
								if($k==7) break;
								$k++;
								$offer = 100-round(($hotitem->price_new/$hotitem->price_old)*100); 
								$srcImg = '/storage/app/files/upload/'.$hotitem->picture;
								$price_new = $hotitem->price_new;
								$price_old = $hotitem->price_old;
								@endphp
								@if($k>4)
								<div class="col-md-4 col-sm-4">
									<div class="products">

										<div class="thumbnail" style="margin: 15px 0;">
											<a href="{{route('tpshop.detail.index',['slug'=>str_slug($hotitem->name),'id'=>$hotitem->id])}}"><img style="width: auto; height: 220px;" src="{{$srcImg}}" alt="Product Name"></a>
										</div>
										<div class="productname">{{$hotitem->name}}</div>
										<div class="pricediv">
											@if($price_new != 0)
											<span class="price-new">{{$price_new}}.000đ</span>
											<span class="price-old">{{$price_old}}.000đ</span>
											@else
											<span class="price-new">{{$price_old}}.000đ</span>
											@endif
											@if($offer < 100)
											<div class="offer-sale">-{{$offer}}%</div>
											@endif
											<div class="button_group">
												<a href="{{route('tpshop.detail.index',['slug'=>str_slug($hotitem->name),'id'=>$hotitem->id])}}" class="button view-detail" type="button">Chi tiết</a>
											</div>
											<a class="button add-cart" type="button" onclick="addCart({{$hotitem->id}})" href="javascript:void(0)" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a>
										</div>

									</div>
								</div>
								@endif
								@endforeach
							</div>
						</li>
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
			@include('tpshop.detail.rightbar')
		</div>
		<div class="clearfix"></div>
	</div>
</div>

   <div id="aleartModel" class="modal fade" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Thông Báo</h5>
            </div>
            <div class="modal-body text-center" width="100px" style="font-size: 19px; ">
                Sản phẩm đã được thêm vào giỏ hàng, bạn có muốn thanh toán ?
            </div>
            <center style="margin: 20px auto;">
            <button type="button" class="btn btn-info" data-dismiss="modal" style="margin-right: 10px ;" >Tiếp tục mua hàng</button>
            <a class="btn btn-success" href="{{route('tpshop.cart.index')}}">Đến thanh toán</a>
            </center>
         </div>
      </div>
   </div>

<script>
	function addCart(id) {
		// if(check==1){
		// 	var thuoctinh = 1;
		// } else {
		// 	var thuoctinh = 0;
		// }
		// alert(thuoctinh);
        jQuery.ajax({
	        url: '{{route('tpshop.cart.addcart')}}',
	        type: 'GET',
	        cache: false,
	        data: {idProduct: id  },
	        success: function(data){
	            //alert(data);
	            jQuery("#cartshop").html(data);
	            jQuery("#aleartModel").modal("show");
	        }, 
	        error: function() {
	           alert("Có lỗi");
	        }
	      }); 
       return false;
	}
	function setActiveSize(id) {
		var li = "#size-"+id;
		jQuery('.size-li').attr('class','size-li');
		jQuery(li).attr('class','active size-li');
	}
	function setActiveColor(color) {
		var li = "#color-"+color;
		jQuery('.color-li').attr('class','color-li');
		jQuery('li[data-value="'+color+'"').attr('class','active color-li');
		
	}
</script>
@endsection
