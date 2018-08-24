
@extends('adminlte::page')

@section('title', 'Sản Phẩm ở Thùng rác')

@section('content_header')
<h1>Các Sản Phẩm Đã Xóa</h1>
@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Thùng Rác</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <a class="btn btn-danger" href="{{route('admin.product.alltrash','delete')}}" role="button" style="margin: 10px">Xóa Toàn Bộ</a>
                <a class="btn btn-primary" href="{{route('admin.product.alltrash','recycle')}}" role="button" style="margin: 10px">Khôi phục Toàn Bộ</a>
                @if(Session::has('msg'))
                  <span style="color: #02AD1A; font-size: 13px;font-weight: bold;">{{Session::get('msg')}}</span>
                @endif
              <table id="danhmuc" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($objTrash as $item)
                            @php 
                                $urlRecycle = route('admin.product.recycle',$item->id);
                                $urlDel     = route('admin.product.del',$item->id);
                            @endphp
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <a href="{{$urlRecycle}}" title="Khôi phục Sản Phẩm" onclick="return confirm('Bạn Có Chắc Muốn Khôi Phục Sản Phẩm Này?')" ><i class="fa fa-edit "></i> Khôi phục</a> | 
                                    <a href="{{$urlDel}}" title="Xóa Sản Phẩm" onclick="return confirm('Bạn Có Chắc Muốn Xóa Vĩnh Viễn?')" ><i class="fa fa-pencil"></i> Xóa vĩnh viễn</a>
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
        $('#danhmuc').DataTable();

          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false

      })
    </script>
@stop

