@extends('adminlte::page')

@section('title', 'Quản lí Users')

@section('content_header')
<h1>Mã Giảm Giá </h1>
@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
            @if(Session::has('msg'))
				<div class="alert alert-success">{{Session::get('msg')}}</div>
			@endif
			@if(Session::has('msg-error'))
				<div class="alert alert-danger">{{Session::get('msg-error')}}</div>
			@endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <a class="btn btn-primary" href="{{route('admin.code.add')}}" role="button" style="margin: 10px">Thêm Mới</a>
              <table id="user" class="table table-bordered">
                        <thead>
                            <tr >
                                <th class="text-center">Mã Giảm Giá</th>
                                <th class="text-center">Giá Trị</th>
                                <th class="text-center">Đơn Hàng tối thiểu</th>
                                <th class="text-center">Xóa Mã</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($objItems as $item)
                            @php
                                $urlDelete = route('admin.code.delete',$item->id);
                            @endphp
                            <tr>
                                <td class="text-center" >{{$item->macode}}</td>
                                <td class="text-center" >{{number_format($item->value)}},000đ</td>
                                <td class="text-center" >{{number_format($item->don_hang_toi_thieu)}},000đ</td>
                                <td class="text-center">
                                    <a href="{{$urlDelete}}" title="Xóa User" onclick="return confirm('Bạn Có Chắc Muốn Xóa?')"  class="btn btn-danger" ><i class="fa fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

