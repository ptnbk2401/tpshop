<?php
    function menuParent($data,$id_cat,$parent,$str){
       foreach($data as $val){
         if($val->id_parent==$parent){
            $selected = ($id_cat == $val->id_cat )? "selected" : "";
            echo '<option value="'.$val->id_cat.'" '. $selected.' >'.$str.' '.$val->name_cat.'</option>';
            menuParent($data,$id_cat,$val->id_cat,$str.'|----');
          }
       }
    }
?>
@extends('adminlte::page')

@section('title', 'Chỉnh sửa  Bài Viết')

@section('content_header')
<h1>Chỉnh sửa Bài viết</h1>
@stop

@section('content')

<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Chỉnh sửa Sản Phẩm</h3>
            </div>
            <form class="form-horizontal" method="post" action="{{route('admin.product.edit',$objItem->id)}}" enctype="multipart/form-data">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Tên Sản Phẩm</label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-7">
                      <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $objItem->name }}">
                      <label id="ername" style="color: red; font-size: 12px;">{{$errors->first('name')}}</label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Danh Mục</label>
                  <div class="col-sm-7">
                      <div class="input-group col-xs-5">
                        <select class="form-control" name="idparent" id="idparent">
                            <option value="">--Chọn--</option>
                            @php 
                              $id_cat = $objItem->id_cat;
                            @endphp
                            <?php menuParent($objItemsCat,$id_cat,0,'') ?>
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
                        <option value="{{$size->type}}">{{$size->type}}</option>
                        @endforeach
                      </select>
                    </div>
                     
                    <div class="input-group col-xs-5">
                      <select class="form-control select2" name="size[]" id="size" multiple>
                        @foreach($objSize as $size)
                        @php
                        $ID_SIZE = $objItem->id_size ;
                        $arID = explode(',',$ID_SIZE );
                        $selected = (in_array($size->id, $arID)) ? 'selected' : '' ;
                        @endphp
                        <option {{$selected}} value="{{$size->id}}">{{$size->value}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Màu sắc</label>
                  <div class="col-sm-7">
                    @if(!empty($objItem->color))
                    @php
                      $Color = $objItem->color ;
                      $arColor = explode(',',$Color );
                    @endphp
                    <div class="input-group col-xs-5">
                      @foreach($arColor as $color)
                        <p class="col-xs-4" style="margin: 10px; width: 20px;height: 15px;background: {{$color}}; border: 1px solid #000;"></p>
                      @endforeach
                    </div>
                    @else
                    @php
                      $arColor = array();
                    @endphp
                    @endif
                   
                    <div class="input-group col-xs-5">
                      <input type="color" onchange="return inputColor()" class="form-control" placeholder="Color" id="selectColor" >
                    </div>
                    <div class="input-group col-xs-5">
                      <select class="form-control select2" name="color[]" id="color" multiple>
                        @foreach($arColor as $color)
                        <option selected value="{{$color}}">{{$color}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Giá Gốc</label>

                  <div class="col-sm-7">
                    <div class="input-group col-xs-5">
                      <span class="input-group-addon">VNĐ</span>
                      <input type="number" name="price_old" class="form-control" placeholder="Price Old" value="{{ $objItem->price_old }}">
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
                     <input type="number" name="price_new" class="form-control" placeholder="Price Sale" value="{{ $objItem->price_new }}">
                      <span class="input-group-addon">.000đ</span>
                    </div>
                    
                  </div>
                  @if($errors->has('price_new'))
                    <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('price_new')}}</label>
                  @endif
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Hình Ảnh Cũ</label>
                  <div class="col-sm-7">
                    <img src="/storage/app/files/upload/{{$objItem->picture}}" alt="{{$objItem->name}}" style="width: 150px;">
                  </div>
                  @if($errors->has('picture'))
                    <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('picture')}}</label>
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
                        @php
                            $selected = ($objItem->id_gift == $item->id_gift)? "selected" : "";
                        @endphp
                        <option value="{{$item->id_gift}}" {{$selected}}>{{$item->name_gift}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label  class="col-sm-4 control-label">Mô tả</label>
                  <div class="col-sm-7">
                    <div class="input-group col-xs-12 ">
                      <textarea name="preview" id="preview" class="form-control" rows="5" placeholder="Mô tả">{{$objItem->preview}}</textarea>
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
                      <textarea name="detail" id="detail" class="form-control" rows="5" placeholder="Chi Tiết">{{$objItem->detail}}</textarea>
                    </div>
                  </div>
                  @if($errors->has('detail'))
                    <label style="color: red; font-size: 12px; margin-left: 373px; margin-top: 10px; ">{{$errors->first('detail')}}</label>
                  @endif
                </div>
                <center>
                  <a class="btn btn-danger" href="{{route('admin.product.index')}}" role="button" style="margin-left: 50px" onclick="return confirm('Dữ liệu chưa được Lưu! Tiếp tục?') ">Cancel</a>
                <button type="submit" name="submit" class="btn btn-info ">Lưu Sản Phẩm</button>
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
  <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
  <script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
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
 
@endsection


