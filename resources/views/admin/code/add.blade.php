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
<h1>Thêm Mã Giảm Giá </h1>
@stop

@section('content')
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              
              <form class="form-horizontal" method="post" action="{{route('admin.code.add')}}">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Mã Giảm Giá:</label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-5">
                      <input type="text" name="macode" class="form-control" value="{{ old('macode') }}">
                      <label id="ername" style="color: red; font-size: 12px">{{$errors->first('macode')}}</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Giá Trị:</label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-5">
                      <span class="input-group-addon">VNĐ</span>
                      <input type="number" name="value" class="form-control" placeholder="Giá Trị " value="{{ old('value') }}">
                      <span class="input-group-addon">.000đ</span>
                    </div>
                  </div>
                    <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('value')}}</label>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Đơn Hàng tối thiểu:</label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-5">
                      <span class="input-group-addon">VNĐ</span>
                      <input type="number" name="don_hang_toi_thieu" class="form-control" placeholder="Giá Trị " value="{{ old('don_hang_toi_thieu') }}">
                      <span class="input-group-addon">.000đ</span>
                    </div>
                  </div>
                    <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('don_hang_toi_thieu')}}</label>
                </div>
                
                <center>
                    <a class="btn btn-danger" href="{{route('admin.code.index')}}" role="button" style="margin-left: 50px" onclick="return confirm('Dữ liệu chưa được Lưu! Tiếp tục?') ">Cancel</a>
                    <button type="submit" name="submit" class="btn btn-info ">Thêm Mã</button>
                    @if(Session::has('msg'))
                      <label style="color: red; font-size: 12px;">{{Session::get('msg')}}</label>
                    @endif
                </center>
              
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

