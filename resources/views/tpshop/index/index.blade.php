@extends('templates.tpshop.master')
@section('main')
@include('templates.tpshop.home-slider')
<div class="container_fullwidth">
	<div class="container">
		<div class="hot-products">
			<h3 class="title">Sản Phẩm <strong>Bán Chạy</strong> </h3>
			<div class="control"><a id="prev_hot" class="prev" href="#">&lt;</a><a id="next_hot" class="next" href="#">&gt;</a></div>
			<ul id="hot">
				<li>
					<div class="row">
						@php
						$k = 1;
						@endphp
						@foreach($objHotItems as $hotitem)
						@php
						if($k==5) break;
						$k++;
						$offer = 100-round(($hotitem->price_new/$hotitem->price_old)*100); 
						$srcImg = '/storage/app/files/upload/'.$hotitem->picture;
						$price_new = $hotitem->price_new;
						$price_old = $hotitem->price_old;
						@endphp
						<div class="col-md-3 col-sm-6">
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
									<a class="button add-cart" type="button" onclick="return addCart({{$hotitem->id}})" href="javascript:void(0)" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a>
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
						$k++;
						$offer = 100-round(($hotitem->price_new/$hotitem->price_old)*100); 
						$srcImg = '/storage/app/files/upload/'.$hotitem->picture;
						$price_new = $hotitem->price_new;
						$price_old = $hotitem->price_old;
						@endphp
						@if($k>5)
						<div class="col-md-3 col-sm-6">
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
									<a class="button add-cart" type="button" onclick="return addCart({{$hotitem->id}})" href="javascript:void(0)" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a>
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
		<div class="featured-products">
			<h3 class="title">Sản Phẩm <strong>Mới Nhất </strong> </h3>
			<div class="control"><a id="prev_featured" class="prev" href="#">&lt;</a><a id="next_featured" class="next" href="#">&gt;</a></div>
			<ul id="featured">
				<li>
					<div class="row">
						@php
						$k = 1;
						@endphp
						@foreach($objNewItems as $newitem)
						@php
						if($k==5) break;
						$k++;
						$offer = 100-round(($newitem->price_new/$newitem->price_old)*100); 
						$srcImg = '/storage/app/files/upload/'.$newitem->picture;
						$price_new = $newitem->price_new;
						$price_old = $newitem->price_old;
						@endphp
						<div class="col-md-3 col-sm-6">
							<div class="products">
								
								<div class="thumbnail" style="margin: 15px 0;">
									<a href="{{route('tpshop.detail.index',['slug'=>str_slug($newitem->name),'id'=>$newitem->id])}}"><img style="width: auto; height: 220px;" src="{{$srcImg}}" alt="Product Name"></a>
								</div>
								<div class="productname">{{$newitem->name}}</div>
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
										<a href="{{route('tpshop.detail.index',['slug'=>str_slug($newitem->name),'id'=>$newitem->id])}}" class="button view-detail" type="button">Chi tiết</a>
									</div>
									<a class="button add-cart" type="button" onclick="return addCart({{$newitem->id}})" href="javascript:void(0)" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a>
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
						@foreach($objNewItems as $newitem)
						@php
						$k++;
						$offer = 100-round(($newitem->price_new/$newitem->price_old)*100); 
						$srcImg = '/storage/app/files/upload/'.$newitem->picture;
						$price_new = $newitem->price_new;
						$price_old = $newitem->price_old;
						@endphp
						@if($k>5)
						<div class="col-md-3 col-sm-6">
							<div class="products">
								
								<div class="thumbnail" style="margin: 15px 0;">
									<a href="{{route('tpshop.detail.index',['slug'=>str_slug($newitem->name),'id'=>$newitem->id])}}"><img style="width: auto; height: 220px;" src="{{$srcImg}}" alt="Product Name"></a>
								</div>
								<div class="productname">{{$newitem->name}}</div>
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
										<a href="{{route('tpshop.detail.index',['slug'=>str_slug($newitem->name),'id'=>$newitem->id])}}" class="button view-detail" type="button">Chi tiết</a>
									</div>
									<a class="button add-cart" type="button" onclick="return addCart({{$newitem->id}})" href="javascript:void(0)" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a>
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
        jQuery.ajax({
        url: '{{route('tpshop.cart.addcart')}}',
        type: 'GET',
        cache: false,
        data: {idProduct: id },
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
</script>
@endsection
