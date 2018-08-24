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
						<div class="ContactForm">
							<h5 class="h5" style="margin: 10px" >QUẢN LÝ TÀI KHOẢN</h5>
							<form method="post" action="{{route('tpshop.user.edit',$user->id)}}">
								@csrf
								<table class="table table-hover">
									<tbody>
										<tr>
											<td>Họ Tên:</td>
											<td><input type="text" name="fullname" tabindex="1" class="form-control" value="{{$user->fullname}}"  ></td>
											<td></td>
										</tr>
										<tr>
											<td>Email:</td>
											<td><input type="email" name="email" tabindex="1" class="form-control" value="{{$user->email}}" ></td>
											<td></td>
										</tr>
										<tr>
											<td>Tên Đăng Nhập:</td>
											<td><input type="text" name="username" disabled class="form-control" placeholder="Username" value="{{$user->username}}"></td>
											<td></td>
										</tr>
										<tr>
											<td>Mật khẩu:</td>
											<td><input type="password" name="password" class="form-control" disabled placeholder="Password" value="{{$user->password}} }}"></td>
											<td><a href="javascript:void(0)" class="btn btn-danger" data-toggle="modal" data-target="#changePass" >Đổi Mật Khẩu</a></td>
										</tr>
									</tbody>
								</table>
								<center style="margin: 20px auto;">
					            <input type="submit" class="btn btn-success" value="Lưu thông tin" />
					            </center>
							</form>
						</div>
						<div class="clearfix"></div>
						<div class="ContactForm">
							<h5 class="h5" style="margin: 10px" >ĐỊA CHỈ GIAO HÀNG</h5>
							<form class="form-horizontal" method="post" action="{{route('tpshop.user.diachi',$user->id)}}">
								@csrf
							  <div class="form-group">
							    <label class="control-label col-sm-3" >Họ tên:</label>
							    <div class="col-offset-sm-3 col-sm-6">
							      <input type="text" class="form-control"  name="fullname" value="{{ isset($objAddress)? $objAddress->fullname : old('fullname') }}">
							    </div>
							    <label class="error-address">{{$errors->first('fullname')}}</label>
							  </div>
							  <div class="form-group">
							    <label class="control-label col-sm-3" >Điện thoại:</label>
							    <div class="col-offset-sm-3 col-sm-6">
							      <input type="number" name="phone" class="form-control" value="{{ isset($objAddress)? $objAddress->phone : old('phone') }}" >
							    </div>
							    <label class="error-address">{{$errors->first('phone')}}</label>
							  </div>
							  <div class="form-group">
							    <label class="control-label col-sm-3" >Địa chỉ:</label>
							    <div class="col-offset-sm-3 col-sm-6">
							      <input type="text" name="address" placeholder="Số nhà, tên đường,.." class="form-control" value="{{ isset($objAddress)? $objAddress->address : old('address') }} ">
							    </div>
							    <label class="error-address">{{$errors->first('address')}}</label>
							  </div>
							  <div class="form-group">
							    <label class="control-label col-sm-3" >TP/Tỉnh:</label>
							    <div class="col-offset-sm-3 col-sm-6">
							     	<select class="form-control select2" onchange="return changeQuan()" name="tinh" id="tinh">
							     		@foreach($objTinh as $tinh)
							     		@php 
							     		if(isset($objAddress)) {
							     			$selected = ($objAddress->tinh == $tinh->provinceid )? 'selected' : '';
							     		}
							     		else {
							     			$selected = '';
							     		}
							     		@endphp
			                            <option {{$selected}} value="{{$tinh->provinceid}}">{{$tinh->name}}</option>
			                            @endforeach
			                        </select>
							    </div>
							  </div>
							  <div class="form-group">
							    <label class="control-label col-sm-3" for="fullname">Quận/Huyện:</label>
							    <div class="col-offset-sm-3 col-sm-6">
							    	<select class="form-control select2"  onchange=" return changePhuong()"  name="quan" id="quan">
							    		@if(!isset($objAddress))
				                            @foreach($objQuan as $quan)
				                            @if($quan->provinceid==01)
				                            <option value="{{$quan->districtid}}">{{$quan->type}} {{$quan->name}}</option>
				                            @endif
				                            @endforeach
			                            @else
				                            @foreach($objQuan as $quan)
				                            @if($quan->provinceid==$objAddress->tinh)
				                            @php 
							     			$selected = ($objAddress->quan == $quan->provinceid )? 'selected' : '';
							     			@endphp
				                            <option {{$selected}} value="{{$quan->districtid}}">{{$quan->type}} {{$quan->name}}</option>
				                            @endif
				                            @endforeach
			                            @endif
			                        </select>
							    </div>
							  </div>
							  <div class="form-group">
							    <label class="control-label col-sm-3" for="fullname">Phường/Xã</label>
							    <div class="col-offset-sm-3 col-sm-6">
								    <select class="form-control select2" name="phuong" id="phuong">
			                            @if(!isset($objAddress))
				                            @foreach($objPhuong as $phuong)
					                        @if($phuong->districtid==001)
				                            <option value="{{$phuong->wardid}}">{{$phuong->type}} {{$phuong->name}}</option>
				                            @endif
				                            @endforeach
			                            @else
				                            @foreach($objPhuong as $phuong)
					                        @if($phuong->districtid==$objAddress->quan)
				                            @php 
							     			$selected = ($objAddress->phuong == $phuong->wardid )? 'selected' : '';
							     			@endphp
				                            <option {{$selected}} value="{{$phuong->wardid}}">{{$phuong->type}} {{$phuong->name}}</option>
				                            @endif
				                            @endforeach
			                            @endif
				                    </select>
							    </div>
							  </div>

							  <center style="margin: 20px auto;">
					            <input type="submit" class="btn btn-danger" value="Hoàn tất" />
					            </center>
							</form>
						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="clearfix">
		</div>
	</div>
</div>
<div id="changePass" class="modal fade" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Đổi Mật Khẩu</h5>
            </div>
            <div class="modal-body" width="100px" style="font-size: 15px; " >
                <form method="post" action="{{route('tpshop.user.editpass',$user->id)}}" class="form-horizontal">
                	@csrf
					<div class="form-group">
					    <label class="control-label col-sm-4" for="pwd">Mật khẩu hiện tại:</label>
					    <div class="col-sm-6"> 
					      <input type="password" name="oldpass" class="form-control" id="pwd" />
					    </div>
					 </div>
					 <div class="form-group">
					    <label class="control-label col-sm-4" for="pwd">Mật khẩu mới:</label>
					    <div class="col-sm-6"> 
					      <input type="password"  name="newpass" class="form-control" />
					    </div>
					 </div>
					<center style="margin: 20px auto;">
		            <button type="button" class="btn btn-info" data-dismiss="modal" style="margin-right: 10px ;" >Hủy</button>
		            <input type="submit" class="btn btn-success" value="Xác Nhận" />
		            </center>
				</form>
            </div>
            
         </div>
      </div>
   </div>
@if(Session::has('msg'))
<div id="alertMsg" class="modal fade in" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-sm" >
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header" style="background-color: #ededed ; color: #003322  ">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h5 class="modal-title">Thông Báo</h5>
            </div>
            <div class="modal-body text-center" width="100px" style="font-size: 19px; ">
                @if(Session::get('msg') === 'infosuccess' )
                {{"Sửa thông tin thành công! Ok để tiếp tục..."}}
                @elseif(Session::get('msg') === 'addresssuccess' )
                {{"Đã lưu địa chỉ giao hàng"}}
                @elseif(Session::get('msg') === 'passsuccess')
				{{"Đổi Mật Khẩu thành công! Ok để tiếp tục..."}}
				@elseif(Session::get('msg') === 'passerror')
				{{"Nhập Mật Khẩu chưa đúng"}}
                @else
                {{"Có lỗi xảy ra, Vui lòng thử lại sau.." }}
                @endif
            </div>
            <center style="margin: 20px auto;">
            <button type="button" class="btn btn-info" data-dismiss="modal" style="margin-right: 10px ;" >OK</button>
            </center>
         </div>
      </div>
   </div>
@endif
<script>
	jQuery("#alertMsg").modal("show");
	function changeQuan() {
		var Id_Tinh = jQuery("#tinh").val();
		//alert(Id_Tinh);
        jQuery.ajax({
        url: '{{route('tpshop.address.changeQuan')}}',
        type: 'GET',
        cache: false,
        data: {Id_Tinh: Id_Tinh },
        success: function(data){
            // alert(data);
           jQuery("#quan").html(data);
        }, 
        error: function() {
           alert("Có lỗi");
        }
      }); 
       return false;
	}
	function changePhuong() {
		var Id_Quan = jQuery("#quan").val();
		//alert(Id_Tinh);
        jQuery.ajax({
        url: '{{route('tpshop.address.changePhuong')}}',
        type: 'GET',
        cache: false,
        data: {Id_Quan: Id_Quan },
        success: function(data){
            //alert(data);
           jQuery("#phuong").html(data);
        }, 
        error: function() {
           alert("Có lỗi");
        }
      }); 
       return false;
	}
	jQuery(document).ready(function() {
	    jQuery('.select2').select2()
	})
</script>
	
@endsection
