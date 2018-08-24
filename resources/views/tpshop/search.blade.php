<form method="post" action="{{route('tpshop.cat.search')}}">
	@csrf
	<input class="search-submit" type="submit" value="">
	<input class="search-input" placeholder="Tên sản phẩm muốn tìm" type="text" value="" name="search">
</form>