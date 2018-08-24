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

@section('title', 'Các Danh Mục')

@section('content_header')
<h1>Danh Mục Mới</h1>
@stop

@section('content')

<section class="content">
<div class="row">
    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Thêm Mới</h3>
            </div>
            <form class="form-horizontal" method="post" action="{{route('admin.cat.add')}}">
                {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Tên Danh Mục</label>

                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                  </div>
                  @if(Session::has('erorr-name'))
                  <label style="color: red; font-size: 12px; margin-left: 135px; margin-top: 10px; ">{{Session::get('erorr-name')}}</label>
                  @endif
                </div>
                <div class="form-group">
                  <label  class="col-sm-2 control-label">Danh Mục Cha</label>
                  <div class="col-sm-10">
                        <select class="form-control select2" name="idparent">
                            <option value="0">----Không----</option>

                            <?php menuParent($objItems,0,'') ?>
                            {{-- @foreach($objParent as $item)
                            <option value="{{$item->id_cat}}">{{$item->name_cat}}</option>
                                @foreach($objChild as $child)
                                @if ($child->id_parent == $item->id_cat )
                                  <option value="{{$child->id_cat}}" style="padding-left: 100px;" >&emsp;&emsp;{{$child->name_cat}}</option>
                                @endif
                                @endforeach
                            @endforeach --}}
                        </select>
                  </div>
                </div>

                <a class="btn btn-danger" href="{{route('admin.cat.index')}}" role="button" style="margin-left: 50px" onclick="return confirm('Dữ liệu chưa được Lưu! Tiếp tục?') ">Cancel</a>
                <button type="submit" name="submit" class="btn btn-info ">Lưu Danh mục</button>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
  $(document).ready(function() {
    $('.select2').select2()
        
  })
  </script>

@endsection


