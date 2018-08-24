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

@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Thông tin Người Dùng</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @php
              $id       = $user->id;
              $username = $user->username;
              $fullname = $user->fullname;
              $role     = $user->role;
              @endphp
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Username</label>
                  <label class="col-sm-10">{{ $username }}</label>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Họ Tên:</label>
                  <label class="col-sm-10">{{ $fullname }}</label>
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Cấp bậc: {{ ($role==1)? 'Admin' : 'Mod' }} </label>
                   <label class="col-sm-10">{{ ($role==1)? 'Admin' : 'Mod' }}</label>
                </div>
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

