@extends('adminlte::page')

@section('title', 'Quản lí Users')

@section('content_header')
<h1>Danh sách Users </h1>
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
                <a class="btn btn-primary" href="{{route('admin.user.add')}}" role="button" style="margin: 10px">Thêm Mới</a>
              <table id="user" class="table table-bordered">
                        <thead>
                            <tr >
                                <th class="text-center">ID</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Họ Tên</th>
                                <th class="text-center">Cấp bậc</th>
                                <th class="text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($objItems as $item)
                        	@php
                        		$urlDelete = route('admin.user.delete',$item->id);
                        		$urlEdit = route('admin.user.edit',$item->id);
                        	@endphp
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td>{{$item->username}}</td>
                                <td>{{$item->fullname}}</td>
                                <td>{{($item->role == 1)? 'ADMIN' : (($item->role == 0) ? 'MOD' : 'Khách Hàng') }}</td>
                                <td class="text-center">
                                    <a href="{{$urlEdit}}" title="Sửa User"  class="btn btn-primary" ><i class="fa fa-edit "></i> Sửa</a>
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

