<?php
    
    //var_dump($arColor); die();
    //$i=0;
    function menuParent($data,$parent,$str,$i){
        $i++;
        $arColor = ['#00007B','#0CA700','#DC09C1','#B50808','#7108B4'];
       foreach($data as $val){
        if($val->id_parent==$parent){
            $urlEdit = route('admin.cat.edit',$val->id_cat);
            $urlDel = route('admin.cat.movetrash',$val->id_cat);
            echo '<tr><td class="text-center">'.$val->id_cat.'</td><td style="color: '.$arColor[$i].' ">'.$str.$val->name_cat.'</td>
                <td>
                    <a href="'.$urlEdit.'" title="Sửa Danh Mục" ><i class="fa fa-edit "></i> Sửa</a> | 
                    <a href="'.$urlDel.'" title="Xóa Danh Mục" onclick="return confirm(\'Bạn Có Chắc Muốn Xóa?\')"  ><i class="fa fa-pencil"></i> Xóa</a>
                </td></tr>';
            menuParent($data,$val->id_cat,$str.'&emsp;&emsp;',$i);
        }

       }
        
    }
?>
@extends('adminlte::page')

@section('title', 'Các Danh Mục')

@section('content_header')
<h1>Các Danh Mục</h1>
@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Danh Mục</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <a class="btn btn-primary" href="{{route('admin.cat.add')}}" role="button" style="margin: 10px">Thêm Mới</a>
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
                            <?php menuParent($objItems,0,'',-1) ?>
                            {{-- @foreach($objParent as $item)
                            @php 
                                $urlEdit = route('admin.cat.edit',$item->id_cat);
                                $urlDel = route('admin.cat.movetrash',$item->id_cat);
                            @endphp
                            <tr>
                                <td class="text-center">{{$item->id_cat}}</td>
                                <td>{{$item->name_cat}}</td>
                                <td>
                                    <a href="{{$urlEdit}}" title="Sửa Danh Mục" ><i class="fa fa-edit "></i> Sửa</a> | 
                                    <a href="{{$urlDel}}" title="Xóa Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Xóa?')" ><i class="fa fa-pencil"></i> Xóa</a>
                                </td>
                            </tr>

                            @foreach($objItems as $child)
                                @if($child->id_parent == $item->id_cat )
                                @php 

                                $urlEditChild = route('admin.cat.edit',$child->id_cat);
                                $urlDelChild = route('admin.cat.movetrash',$child->id_cat);
                                @endphp
                                <tr>
                                    <td class="text-center">{{$child->id_cat}}</td>
                                    <td>&emsp;&emsp;{{$child->name_cat}}</td>
                                    <td>
                                        <a href="{{$urlEditChild}}" title="Sửa Danh Mục" ><i class="fa fa-edit "></i> Sửa</a> | 
                                        <a href="{{$urlDelChild}}" title="Xóa Danh Mục" onclick="return confirm('Bạn Có Chắc Muốn Xóa?')" ><i class="fa fa-pencil"></i> Xóa</a>
                                    </td>
                                </tr>
                                @endif      
                            @endforeach
                              
                            @endforeach --}}
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

