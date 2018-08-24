@extends('templates.tpshop.master')
@section('main')
<div class="container_fullwidth">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-3">
						@include('tpshop.profile.left-bar')
					</div>
					<div class="col-md-9">
						<div class="ContactForm" style="font-size: 14px">
							<h5 class="h5" style="margin: 10px" >THÔNG TIN CHUNG</h5>
							<table class="table table-bordered table-hover">
								<tbody>
									<tr>
										<td>Họ Tên:</td>
										<td>{{$user->fullname}}</td>
									</tr>
									<tr>
										<td>Email:</td>
										<td>{{$user->email}}</td>
									</tr>
									<tr>
										<td>Tên Đăng Nhập:</td>
										<td>{{$user->username}}</td>
									</tr>
								</tbody>
							</table>
							<a href="{{route('tpshop.user.edit',$user->id)}}">Cập nhật thông tin</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix">
		</div>
	</div>
</div>


	
@endsection
