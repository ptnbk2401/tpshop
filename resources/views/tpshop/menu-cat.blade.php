<ul class="nav navbar-nav">
	<li class="dropdown">
		<a href="/" >Home</a>
	</li>
	@foreach($objItemsCat as $cat)
		@if($cat->id_parent == 0)
		@php
			$arSubCat = array();
		@endphp
		@foreach($objItemsCat as $subcat)
			@if($subcat->id_parent == $cat->id_cat)
			@php
				$arSubCat[] = $subcat;
			@endphp
			@endif
		@endforeach
		@php
			$count = count($arSubCat);
			$k = CEIL($count/2);
			$id_cat = $cat->id_cat;
			$name_cat = $cat->name_cat;
		@endphp
	<li class="dropdown">
		<a href="{{route('tpshop.cat.index',['slug'=>str_slug($cat->name_cat
		),'id'=>$cat->id_cat])}}" class="dropdown-toggle" data-toggle="dropdown">{{$name_cat}} </a>
		<div class="dropdown-menu mega-menu">
			<div class="row">
				<div class="col-md-6 col-sm-6">
					<ul class="mega-menu-links">
						@for($i = 0; $i< $k ;$i++)
						@php
							$objScat = $arSubCat[$i];
						@endphp
						<li><a href="{{route('tpshop.cat.index',['slug'=>str_slug($objScat->name_cat),'id'=>$objScat->id_cat])}}">{{ $objScat->name_cat }}</a></li>
						@endfor
					</ul>
				</div>
				<div class="col-md-6 col-sm-6">
					<ul class="mega-menu-links">
						@for($i = $count-1; $i>=$k ;$i--)
						@php
							$objScat = $arSubCat[$i];
						@endphp
						<li><a href="{{route('tpshop.cat.index',['slug'=>str_slug($objScat->name_cat),'id'=>$objScat->id_cat])}}">{{ $objScat->name_cat }}</a></li>
						@endfor
					</ul>
				</div>
			</div>
		</div>
	</li>
	@endif
	@endforeach
	<li><a href="{{route('tpshop.contact.index')}}">Liên Hệ</a></li>
</ul>