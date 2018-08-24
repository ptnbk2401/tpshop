<div class="category leftbar">
	<h3 class="title">
		Danh mục chính
	</h3>
	<ul>
		@foreach($objItemsCat as $catt)
		@if($catt->id_parent == 0)
		<li>
			<a href="{{route('tpshop.cat.index',['slug'=>str_slug($catt->name_cat
		),'id'=>$catt->id_cat])}}">{{$catt->name_cat}}</a>
		</li>
		@endif
		@endforeach
	</ul>
</div>
<div class="clearfix"></div>
<div class="branch leftbar">
	<h3 class="title">
		Danh mục Ngẫu Nhiên
	</h3>
	<ul>
		@foreach($objItemsRandCat as $rcat)
		<li>
			<a href="{{route('tpshop.cat.index',['slug'=>str_slug($rcat->name_cat
		),'id'=>$rcat->id_cat])}}">{{$rcat->name_cat}}</a>
		</li>
		@endforeach
	</ul>
</div>
<div class="clearfix"></div>
<div class="price-filter leftbar">
	<h3 class="title">
		Lọc theo Giá
	</h3>
	<form class="pricing">
		<label>
			<input type="number">
		</label>
		<span class="separate">
			- 
		</span>
		<label>
			<input type="number">
		</label>
		<input type="submit" value="Lọc">
	</form>
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
<div class="leftbanner">
	<img src="images/banner-small-01.png" alt="">
</div>