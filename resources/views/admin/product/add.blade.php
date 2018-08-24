<?php
function menuParent($data,$parent,$str){
 foreach($data as $val){
   if($val->id_parent==$parent){
    echo '<option value="'.$val->id_cat.'" >'.$str.' '.$val->name_cat.'</option>';
    menuParent($data,$val->id_cat,$str.'|----');
  }
}
}
?>
@extends('adminlte::page')

@section('title', 'Danh sách Bài Viết')

@section('css')

@stop

@section('content_header')
<h1>Bài viết mới</h1>
@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">Thêm Mới Sản Phẩm</h3>
        </div>
        <form class="form-horizontal" method="post" action="{{route('admin.product.add')}}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label  class="col-sm-4 control-label">Tên Sản Phẩm</label>

              <div class="col-sm-7">

                <div class="input-group col-xs-7">
                  <input type="text" name="name" id="name"  class="form-control" placeholder="Name" value="{{ old('name') }}">
                  <label id="ername" style="color: red; font-size: 12px">{{$errors->first('name')}}</label>
                </div>

              </div>

            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Danh Mục</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-5">
                  <select class="form-control" name="idparent" id="idparent">
                    <option value="">--Chọn--</option>
                    <?php menuParent($objItemsCat,0,'') ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Kích cỡ</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-5">
                  <select class="form-control" name="type" id="type" onchange="return changeSize()">
                    <option value="">--Chọn--</option>
                    @foreach($objSizeType as $size)
                    @if($size->type != 'none')
                    <option value="{{$size->type}}">{{$size->type}}</option>
                    @endif
                    @endforeach
                  </select>
                </div>
                <div class="input-group col-xs-5">
                  <select class="form-control select2" name="size[]" id="size" multiple>
                    @foreach($objSize as $size)
                    <option value="{{$size->id}}">{{$size->value}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Màu sắc</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-5">
                  <input type="color" onchange="return inputColor()" class="form-control" placeholder="Color" id="selectColor" >
                </div>
                <div class="input-group col-xs-5">
                  <select class="form-control select2" name="color[]" id="color" multiple>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label  class="col-sm-4 control-label">Giá Gốc</label>

              <div class="col-sm-7">
                <div class="input-group col-xs-5">
                  <span class="input-group-addon">VNĐ</span>
                  <input type="number" name="price_old" class="form-control" placeholder="Price Old" value="{{ old('price_old') }}">
                  <span class="input-group-addon">.000đ</span>
                </div>
              </div>

              @if($errors->has('price_old'))
              <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('price_old')}}</label>
              @endif

            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Giá Khuyến Mãi</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-5">
                  <span class="input-group-addon">VNĐ</span>
                  <input type="number" name="price_new" class="form-control" placeholder="Price Sale" value="{{ old('price_new') }}">
                  <span class="input-group-addon">.000đ</span>
                </div>
              </div>
              @if($errors->has('price_new'))
              <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('price_new')}}</label>
              @endif
            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Hình Ảnh Sản Phẩm</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-5">
                  <input type="file" name="picture" class="form-control" accept="image/*">
                </div>
              </div>
              @if($errors->has('picture'))
              <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('picture')}}</label>
              @endif
            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Quà Tặng Kèm</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-5">
                  <select class="form-control" name="idgift">
                    <option value="0">Không có quà kèm theo</option>
                    @foreach($objGift as $item)
                    <option value="{{$item->id_gift}}">{{$item->name_gift}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Mô tả</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-12 ">
                  <textarea name="preview" id="preview" class="form-control" rows="5" placeholder="Mô tả"></textarea>
                </div>
              </div>
              @if($errors->has('preview'))
              <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('preview')}}</label>
              @endif
            </div>
            <div class="form-group">
              <label  class="col-sm-4 control-label">Chi Tiết</label>
              <div class="col-sm-7">
                <div class="input-group col-xs-12 ">
                  <textarea name="detail" id="detail" class="form-control" rows="5" placeholder="Chi Tiết"></textarea>
                </div>
              </div>
              @if($errors->has('detail'))
              <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('detail')}}</label>
              @endif
            </div>
            <div style=" margin-left: 231px; margin-top: 10px; ">
              <button type="submit" name="submit" class="btn btn-info ">Thêm Sản Phẩm</button>
              <a class="btn btn-danger" href="{{route('admin.product.index')}}" role="button" style="margin-left: 10px" onclick="return confirm('Dữ liệu chưa được Lưu! Tiếp tục?') ">Cancel</a>
            </div>
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
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
</script>
<script>
 function changeSize() {
  var type = $("#type").val();
    // alert(type);
    $.ajax({
      url: '{{route('admin.product.changeSize')}}',
      type: 'GET',
      cache: false,
      data: { type: type },
      success: function(data){
          // alert(data);
          $("#size").html(data);
          // $("#aleartModel").modal("show");
        }, 
        error: function() {
         alert("Có lỗi");
       }
     }); 
    return false;
  }


  function inputColor() {
    var color = $("#selectColor").val();
      //alert(color);
      $.ajax({
        url: '{{route('admin.product.selectColor')}}',
        type: 'GET',
        cache: false,
        data: { color: color },
        success: function(data){
          // alert(data);
          $("#color").html(data);
        }, 
        error: function() {
          alert("Có lỗi");
        }
       }); 
      
    }

  </script>
  <script>
    $(function () {
      CKEDITOR.replace('detail',options)
      CKEDITOR.replace('preview')
    })

  </script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.select2').select2()
    })
  </script>


  @endsection


