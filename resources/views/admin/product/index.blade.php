<?php
function menuParent($data,$parent,$str){
 foreach($data as $val){
   if($val->id_parent==$parent){
    echo '<option value="'.$val->id_cat.'">'.$str.' '.$val->name_cat.'</option>';
    menuParent($data,$val->id_cat,$str.'|----');
  }
}
}
?>
@extends('adminlte::page')

@section('title', 'Danh sách sản phẩm')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
#select2-idcat-container {
  line-height: 22px;

}
</style>
@endsection
@section('content_header')
<h1>Danh sách Bài Viết</h1>
@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Bài viết</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body" >
          <div >
            <div class="col-sm-3" style="margin-bottom: 20px">
              <a class="btn btn-primary" href="{{route('admin.product.add')}}" role="button" >Thêm Mới</a>
              @if(Session::has('msg'))
              <span style="color: #02AD1A; font-size: 13px;font-weight: bold;">{{Session::get('msg')}}</span>
              @endif
            </div>
            <div class="col-sm-3">
               <!--<select class="form-control select2"  name="idcat" id="idcat" >
                <option value="">--Chọn Sản Phẩm--</option>
                {{-- <?php menuParent($objItemsCat,0,'') ?> --}}
              </select>  -->
            </div>
            <div class="col-sm-6" ></div>
          </div>

          <table id="baiviet" class="table table-bordered">
            <thead>
              <tr class="text-center">
                <th>ID</th>
                <th>Tên Sản Phẩm</th>
                <th>Sản Phẩm</th>
                <th>Giá Gốc</th>
                <th>Giá Sale</th>
                <th>Hình Ảnh</th>
                <th>Đặc Tính</th>
                <th style="width: 77px;">Hành Động</th>
              </tr>
            </thead>
            <tbody>

              @foreach($objItems as $item)
              @php 
              $hot = ($item->hot==1)? 'checked' : '' ;
              $sale = ($item->sale == 1)? 'checked' : '' ;
              $urlEdit = route('admin.product.edit',$item->id);
              $urlTrash = route('admin.product.movetrash',$item->id);
              $srcImg = '/storage/app/files/upload/'.$item->picture;
              @endphp
              <tr>
                <td class="text-center">{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->name_cat}}</td>
                <td>{{$item->price_old}}.000</td>
                <td>{{$item->price_new}}.000</td>
                <td><img src="{{$srcImg}}" alt="{{$item->name}}" style="width: 80px;"></td>
                <td>
                  <span>Hot</span>
                  <span id="hot-{{$item->id}}" ><input onchange="return changeHot({{$item->id}})" type="checkbox" {{ $hot }} ></span> 
                  <span >Sale</span>
                  <span id="sale-{{$item->id}}"><input onchange="return changeSale({{$item->id}})" type="checkbox" {{ $sale }}></span>
                </div>


              </td>
              <td>
                <a href="{{$urlEdit}}" title="Sửa Sản Phẩm" ><i class="fa fa-edit "></i> Sửa</a> | 
                <a href="{{$urlTrash}}" title="Xóa Sản Phẩm" onclick="return confirm('Bạn Có Chắc Muốn Xóa?')" ><i class="fa fa-trash"></i> Xóa</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2()
    $('#baiviet').DataTable();

  })
  function changeHot(id){
    var idDiv = '#hot-'+id;
        // alert(idDiv);
        $.ajax({
          url: '{{route('admin.product.hot')}}',
          type: 'GET',
          cache: false,
          data: {idPost: id },
          success: function(data){
            // alert(data);
            $(idDiv).html(data);
          }, 
          error: function() {
           alert("Có lỗi");
         }
       }); 
        return false;
      }
  function changeSale(id){
        var idDiv = '#sale-'+id;
        // alert(idDiv);
        $.ajax({
          url: '{{route('admin.product.sale')}}',
          type: 'GET',
          cache: false,
          data: {idPost: id },
          success: function(data){
            // alert(data);
            $(idDiv).html(data);
          }, 
          error: function() {
           alert("Có lỗi");
         }
       }); 
        return false;
      }

</script>
        @stop

