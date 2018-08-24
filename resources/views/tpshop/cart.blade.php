@php
if(Session::has('cart')){
	$arCart = Session::get('cart');
}
@endphp
<div id="cartshop">
@if(isset($arCart))
@php
	$count = count($arCart);
	$thanhtoan = 0;
@endphp
<a href="{{route('tpshop.cart.index')}}" class="cart-icon">Giỏ Hàng <span class="cart_no">{{$count}}</span></a>
<ul class="option-cart-item">
@foreach($arCart as $id => $item)
@php
$srcImg = '/storage/app/files/upload/'.$item['picture'];
$name 		= $item['name'];
$gia 		= $item['gia'];
$soluong 	= $item['soluong'];
$tongtien 	= $item['tongtien'];
$thanhtoan	+=$tongtien; 
@endphp
	<li>
		<div class="cart-item">
			<div class="image"><img src="{{$srcImg}}" alt=""></div>
			<div class="item-description">
				<p class="name">{{$name}}</p>
				<p>Số lượng: <span class="light-red">{{$soluong }}</span></p>
			</div>
			<div class="right">
				<a href="{{ route('tpshop.cart.delcart',$id) }}" class="remove"><img src="{{$urlTpshop}}/images/remove.png" alt="remove"></a>
			</div>
		</div>
	</li>
@endforeach
	<li><span class="total">Tổng tiền <strong>{{number_format($thanhtoan)}},000đ</strong></span></li>
	<li><a class=" checkout button" href="{{route('tpshop.cart.index')}}">Đến giỏ hàng</a></li>
</ul>
@else
<a href="{{route('tpshop.cart.index')}}" class="cart-icon">Giỏ Hàng <span class="cart_no">0</span></a>
<ul class="option-cart-item">
	<li><span class="total">Tổng tiền <strong>0đ</strong></span></li>
	<li><a class=" checkout button" href="{{route('tpshop.cart.index')}}">Đến giỏ hàng</a></li>
</ul>
@endif
</div>
