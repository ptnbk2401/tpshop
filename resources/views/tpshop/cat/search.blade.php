@extends('templates.tpshop.master')
@section('main')
<div class="container_fullwidth">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				@include('tpshop.cat.leftbar')
			</div>
			<div class="col-md-9">
				<div class="banner">
					<div class="bannerslide" id="bannerslide">
						<ul class="slides">
							<li>
								<a href="#"><img src="/storage/app/files/slider/1.jpg" alt=""  style="width: 100% ; height: 100%"/></a>
							</li>
							<li>
								<a href="#"><img src="/storage/app/files/slider/2.jpg" alt=""  style="width: 100% ; height: 100%"/></a>
							</li>
							<li>
								<a href="#"><img src="/storage/app/files/slider/4.jpg" alt="" style="width: 100% ; height: 100%" /></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="clearfix">
				</div>
				<div class="products-grid">
					<div class="toolbar">
						<h3 class="h3">Tìm thấy <b>{{$count}}</b> kết quả cho " <b>{{$search_content}}</b>" </h3>
					</div>
					<div class="clearfix"></div>
					<div class="row">
						@foreach($objProductItems as $item)
						@php
						$offer = 100-round(($item->price_new/$item->price_old)*100); 
						$srcImg = '/storage/app/files/upload/'.$item->picture;
						$price_new = $item->price_new;
						$price_old = $item->price_old;
						@endphp
						<div class="col-md-4 col-sm-6">
							<div class="products">
								<div class="thumbnail" style="margin: 15px 0;">
									<a href="{{route('tpshop.detail.index',['slug'=>str_slug($item->name),'id'=>$item->id])}}"><img style="width: auto; height: 220px;" src="{{$srcImg}}" alt="Product Name"></a>
								</div>
								<div class="productname">{{$item->name}}</div>
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
										<a href="{{route('tpshop.detail.index',['slug'=>str_slug($item->name),'id'=>$item->id])}}" class="button view-detail" type="button">Chi tiết</a>
									</div>
									<a class="button add-cart" type="button" onclick="return addCart({{$item->id}})" href="javascript:void(0)" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a>
								</div>
							</div>
						</div>
						@endforeach
					</div>
					<div class="clearfix"></div>
					
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</div>
<div class="clearfix"></div>

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
