@extends('adminlte::page')

@section('title', 'Quản lí Thông Tin')

@section('content_header')
<h1>Trang Liên Hệ </h1>
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
              <table id="contact" class="table table-bordered">
                        <thead>
                            <tr >
                                <th class="text-center">Họ Tên</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Số Phone</th>
                                <th class="text-center" style="width: 200px" >Nội dung</th>
                                <th class="text-center" style="min-width: 102px">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($objItems as $item)
                            @php
                                $urlDel = route('admin.contact.delete',$item->id);
                            @endphp
                            <tr>
                                <td class="td-gift">{{$item->fullname}}
                                @if($item->reply==0)
                                <img class="gift-new" src="http://mimiso.vn/images/new.gif" alt="">
                                @endif
                                </td>
                                <td>{{$item->email}}</td>
                                <td class="text-center">{{$item->phone_number}}</td>
                                <td>{{$item->message}}</td>
                                <td class="text-center" >
                                    <a class="btn btn-success btn-md" type="a" class="btn btn-primary" data-toggle="modal" data-target="#add-{{$item->id}}"><i class="fa fa-mail-forward"></i> Liên hệ</a>
                                    <a href="{{$urlDel}}" title="Xóa Thông Tin" onclick="return confirm('Bạn Có Chắc Muốn Xóa?')" class="btn btn-danger" ><i class="fa fa-trash"></i> Xóa</a>
                                </td>
                            </tr>
                            <div class="modal fade" id="add-{{$item->id}}" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <a type="a" class="close" data-dismiss="modal">&times;</a>
                                            <h4 class="modal-title">Liên hệ</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <form action="{{route('admin.contact.sendmail',$item->id)}}"  method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group">
                                                    <br> <label>Người nhận</label>
                                                    <input readonly type="text" name="email" id="email" value="{{$item->email}}" class="form-control" />
                                                    <label>Tiêu đề</label>
                                                    <input type="text" name="title" id="title" value="" class="form-control" />
                                                    <label>Nội dung</label>
                                                    <textarea name="message" rows="5" class="form-control" cols="80" id="noidung"></textarea>
                                                    </div>
                                                    <input type="submit" name="submit"  value="Gửi" class="btn btn-success btn-md"  />
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a type="a" class="btn btn-default" data-dismiss="modal">Đóng</a>
                                        </div>
                                    </div>
                                </div>  
                            </div>

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
        $('#contact').DataTable();
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
      })
    </script>
@stop

