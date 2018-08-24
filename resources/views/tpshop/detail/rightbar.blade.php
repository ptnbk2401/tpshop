<div class="col-md-3">
	<div class="special-deal leftbar">
		<h4 class="title">
			Sản phẩm <strong>Mới</strong>
		</h4>
		@php
		$k = 1;
		@endphp
		@foreach($objNewItems as $item)
		@php
		if($k==5) break;
		$k++;
		$offer = 100-round(($item->price_new/$item->price_old)*100); 
		$srcImg = '/storage/app/files/upload/'.$item->picture;
		$price_new = $item->price_new;
		$price_old = $item->price_old;
		@endphp
		<div class="special-item">
			<div class="product-image">
				<a href="{{route('tpshop.detail.index',['slug'=>str_slug($item->name),'id'=>$item->id])}}">
					<img src="{{$srcImg}}" alt="">
				</a>
			</div>
			<div class="product-info">
				<p>
					{{$item->name}}
				</p>
				<h5 class="price">
					{{empty($price_new) ? $price_old : $price_new }}.000đ
				</h5>
			</div>
		</div>
		@endforeach
	</div>
	<div class="clearfix"></div>
	<div class="product-tag leftbar">
		<h3 class="title">
			Products 
			<strong>
				Tags
			</strong>
		</h3>
		<ul>
			<li>
				<a href="#">
					Thời Trang
				</a>
			</li>
			<li>
				<a href="#">
					Giày Túi
				</a>
			</li>
			<li>
				<a href="#">
					Đồng hồ
				</a>
			</li>
			<li>
				<a href="#">
					Mắt Kính
				</a>
			</li>
			<li>
				<a href="#">
					Túi Sách
				</a>
			</li>
			<li>
				<a href="#">
					Balo
				</a>
			</li>
			<li>
				<a href="#">
					Vali
				</a>
			</li>
			<li>
				<a href="#">
					TPshop
				</a>
			</li>
		</ul>
	</div>
	<div class="clearfix"></div>
</div>