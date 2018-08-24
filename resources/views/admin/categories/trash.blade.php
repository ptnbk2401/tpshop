
@extends('adminlte::page')

@section('title', 'Các Danh Mục')

@section('content_header')
<h1>Các Danh Mục Đã Xóa</h1>
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
                <a class="btn btn-danger" href="{{route('admin.cat.alltrash','delete')}}" onclick="return confirm('Bạn Có Chắc Muốn Xóa Vĩnh Viễn?')" role="button" style="margin: 10px">Xóa Toàn Bộ</a>
                <a class="btn btn-primary" href="{{route('admin.cat.alltrash','recycle')}}"  onclick="return confirm('Bạn Có Chắc Muốn Khôi Phục Danh Mục?')" role="button" style="margin: 10px">Khôi phục Toàn Bộ</a>
                @if(Session::has('msg'))
                  <span style="color: #02AD1A; font-size: 13px;font-weight: bold;">{{Session::get('msg')}}</span>
                @endif
              <table id="danhmuc" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>ID</th>
                                <th>Tên Danh Mục</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $arId = array(); 
                            @endphp
                            @foreach($objTrash as $item)
                            @php 
                                $urlRecycle = route('admin.cat.recycle',$item->id_cat);
                                $urlDel = route('admin.cat.del',$item->id_cat);
                            @endphp
                            @if( $item->id_parent == 0 )
                            <tr>
                                <td class="text-center">{{$item->id_cat}}</td>
                                <td>{{$item->name_cat}}
                                    <ul class="list-group list-group-flush "  >
                                    @foreach($objTrash as $child)
                                        @if($child->id_parent == $item->id_cat )
                                        @php 
                                            $arId[]=$child->id_cat;
                                            $urlRecycleChild = route('admin.cat.recycle',$child->id_cat);
                                            $urlDelChild = route('admin.cat.del',$child->id_cat);
                                        @endphp
                                            <li style="list-style-type: none ">
                                                <span class="col-md-4">|---- {{$child->name_cat}}</span>
                                                <span class="col-md-8" >
                                                    <a href="{{$urlRecycleChild}}" title="Khôi phục Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Khôi Phục Danh Mục?')" ><i class="fa fa-edit " ></i> Khôi phục</a> | 
                                                    <a href="{{$urlDelChild}}" title="Xóa Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Xóa Vĩnh Viễn?')" ><i class="fa fa-pencil"></i> Xóa vĩnh viễn</a>
                                                </span>
                                            </li>  
                                        @endif      
                                    @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <a href="{{$urlRecycle}}" title="Khôi phục Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Khôi Phục Danh Mục Này?')" ><i class="fa fa-edit "></i> Khôi phục</a> | 
                                    <a href="{{$urlDel}}" title="Xóa Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Xóa Vĩnh Viễn?')" ><i class="fa fa-pencil"></i> Xóa vĩnh viễn</a>
                                </td>
                            </tr>
                            
                            @elseif( $item->id_parent != 0 &&  !in_array($item->id_cat,$arId) )
                            <tr>
                                <td class="text-center">{{$item->id_cat}}</td>
                                <td>{{$item->name_cat}}
                                </td>
                                <td>
                                    <a href="{{$urlRecycle}}" title="Khôi phục Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Khôi Phục Danh Mục Này?')" ><i class="fa fa-edit "></i> Khôi phục</a> | 
                                    <a href="{{$urlDel}}" title="Xóa Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Xóa Vĩnh Viễn?')" ><i class="fa fa-pencil"></i> Xóa vĩnh viễn</a>
                                </td>
                            </tr>
                            @endif
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

