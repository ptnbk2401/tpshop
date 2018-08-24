@extends('adminlte::page')

@section('title', 'Quản lí Users')

@section('css')
<style>
  .error-form {
    color: red;
    font-size: 12px; 
    margin-left: 192px; 
    margin-top: 10px; 
  }
</style>
@stop

@section('content_header')
<h1>Quản lí Users </h1>
@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Thêm Mới</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @php
              $id       = $objItem->id;
              $username = $objItem->username;
              $fullname = $objItem->fullname;
              $role     = $objItem->role;
              @endphp
              <form class="form-horizontal" method="post" action="{{route('admin.user.edit',$id)}}">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Username</label>
                  <div class="col-sm-10">
                    <input type="text" name="username" disabled class="form-control" placeholder="Username" value="{{ $username }}">
                  </div>
                 
                  <label class="error-form">{{$errors->first('username')}}</label>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Password:</label>
                  <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}">
                  </div>
                  <label class="error-form">{{$errors->first('password')}}</label>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Họ Tên:</label>

                  <div class="col-sm-10">
                    <input type="text" name="fullname" class="form-control" placeholder="Fullname" value="{{ !empty( old('fullname') )? old('fullname') : $fullname }}">
                  </div>
                  <label class="error-form">{{$errors->first('fullname')}}</label>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Cấp bậc:</label>
                  <div class="col-sm-10">
                        <select class="form-control" name="role">
                          @if($role == 1) 
                            <option selected value="1">Admin</option>
                            <option value="0">Mod</option>
                          @else 
                            <option  value="1">Admin</option>
                            <option selected value="0">Mod</option>
                          @endif  
                        </select>
                  </div>
                </div>

                <a class="btn btn-danger" href="{{route('admin.user.index')}}" role="button" style="margin-left: 50px" onclick="return confirm('Dữ liệu chưa được Lưu! Tiếp tục?') ">Cancel</a>
                <button type="submit" name="submit" class="btn btn-info ">Save</button>
                @if(Session::has('msg'))
                  <label style="color: red; font-size: 12px;">{{Session::get('msg')}}</label>
                @endif
              </div>
                
            </form>
                </div>
                
            </div> 
           
        </div>
    </div>
</section>

@stop

@push('css')

@push('js')
@section('js')
    <script>
      $(function () {
        $('#user').DataTable();
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
      })
    </script>
@stop

