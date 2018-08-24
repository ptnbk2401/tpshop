<?php
use App\Model\Diachi;
use App\Model\DiachiGiaoHang;


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
.products-div {
    position: relative;
    padding: 10px;
}
.products-div img {
    width: 40px;
    
}
.products-div .left {
    position: absolute;
    top: 0;
    left: 55px;

}
</style>
@endsection
@section('content_header')
<h1>Quản lí đơn hàng</h1>
@stop

@section('content')

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Đơn hàng</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body" >
          <div >
            <div class="col-sm-3" style="margin-bottom: 20px">
              @if(Session::has('msg'))
              <span style="color: #02AD1A; font-size: 13px;font-weight: bold;">{{Session::get('msg')}}</span>
              @endif
            </div>
            
            <div class="col-sm-6" ></div>
          </div>

          <table id="baiviet" class="table table-bordered">
            <thead>
              <tr class="text-center">
                <th>Order</th>
                <th style="width: 350px">Sản Phẩm</th>
                <th>Mã Code</th>
                <th>Tổng tiền</th>
                <th>Ngày Đặt Hàng</th>
                <th>Thanh Toán</th>
                <th>Trạng thái hàng</th>
                <th style="width: 77px;">Hành Động</th>
              </tr>
            </thead>
            <tbody>

              @foreach($objItems as $item)
              @php
              $urlDel = route('admin.order.delete',$item->id);
              $created_at = date("l, d-m-Y ", strtotime($item->created_at));
              // $trangthaidonhang = ($item->trangthaidonhang == -1)? 'Đang Xử Lí' : (($item->trangthaidonhang == 0)? 'Đang Vận Chuyển' : 'Đã Hoàn Thành') ; 
              $trangthaidonhang = $item->trangthaidonhang;
              $macode = $item->macode;
              $thanhtoan = ($item->status == 0)? 'Thanh toán khi nhận hàng' : 'Đã thanh toán qua Paypal' ;
              $arID = explode(',', $item->id_product);
              $arSL = explode(',', $item->soluong);
              $arTT = explode(',', $item->thuoctinh);
              $i=0;
              @endphp
              <tr>
                <td class="text-center">{{$item->id}}</td>
                <td>
                  @foreach($arID as $id)
                  @php
                    $objProduct = \App\Model\Product::find($id);
                  @endphp
                  <div class="products-div">
                    <img src="/storage/app/files/upload/{{$objProduct->picture}}" alt="">
                    <div class="left">
                      <h6 >{{$objProduct->name}}</h6>
                      <p style="font-size: 12px">Số lượng: {{ $arSL[$i++] }}</p>
                    </div>
                  </div>
                  @endforeach
                </td>
                <td class="text-center">{{ $macode }}</td>
                <td class="text-center">{{number_format($item->money_pay).",000đ"}}</td>
                <td>{{$created_at}}</td>
                <td>{{$thanhtoan}}</td>
                <td style="width: 120px;">
                  <div class="form-group" >
                      <select name="trangthaidonhang"  id="TTVC-{{$item->id}}" onchange="return changeTTDH({{$item->id}})" class="form-control" >
                        <option value="-1" {{ ($trangthaidonhang == -1) ? 'selected' : ''}} >Xử Lí</option>
                        <option value="0"  {{ ($trangthaidonhang == 0) ? 'selected' : ''}}  >Vận Chuyển</option>
                        <option value="1"  {{ ($trangthaidonhang == 1) ? 'selected' : ''}}  >Hoàn Thành</option>
                      </select>
                  </div>
                </td>
                <td class="text-center">
                  <a href="javascript:void(0)" title="Xem chi tiết" data-toggle="modal" data-target="#view-{{$item->id}}" ><i class="fa fa-eye"></i> View</a>
                  <a href="{{$urlDel}}" title="Xóa Sản Phẩm" onclick="return confirm('Bạn Có Chắc Muốn Xóa?')" ><i class="fa fa-trash"></i> Xóa</a>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="view-{{$item->id}}" role="dialog">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header" style="background: #EDECEC">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Đơn Hàng {{$item->id}} - {{$created_at}} </h4>
                  </div>
                  <div class="modal-body">
                    <div class="row" style="padding-left: 15px; ">
                      <h3 class="modal-title">Thông tin sản phẩm </h3>
                      <div>
                        <div class=" col-sm-6">
                            <p>Sản Phẩm</p>
                        </div> 
                        <div class=" text-center col-sm-2">
                            <p>Số lượng</p>
                        </div>
                        <div class="text-center col-sm-2">
                            <p>Đơn Giá</p>
                        </div>
                        <div class="text-center col-sm-2">
                            <p>Thành Tiền</p>
                        </div>
                      </div>
                      @php
                        $k = 0;
                      @endphp
                      @foreach($arID as $id)
                      @php
                        $objProduct = \App\Model\Product::find($id);
                        $gia = empty($objProduct->price_new)? $objProduct->price_old : $objProduct->price_new;
                        $soluong = $arSL[$k];
                        $thuoctinh = $arTT[$k];
                        $color = substr($thuoctinh,0,7);
                        $size  = substr($thuoctinh,8,1);
                        $itemSize = App\Model\Size::find($size) ;
                        $tongtien = $soluong*$gia;
                        $k++;
                        
                      @endphp
                        <div class="col-sm-12" style="margin: 10px auto">
                          <div class="media col-sm-6">
                            <div class="media-left">
                              <img src="/storage/app/files/upload/{{$objProduct->picture}}" class="media-object" style="width:60px">
                            </div>
                            <div class="media-body">
                              <h4 class="media-heading">{{$objProduct->name}}</h4>
                              <p>Thông tin: <a style="margin: 0 5px; padding:5px 15px 0 7px; background: {{$color}}"></a> - Size <strong>{{$itemSize->value }}</strong></p>
                            </div>
                          </div> 
                          <div class="text-center col-sm-2">
                              <p>{{ $soluong }}</p>
                          </div>
                          <div class="text-center col-sm-2">
                              <p>{{ $gia }}</p>
                          </div>
                          <div class="text-center col-sm-2">
                              <p> {{$tongtien}} </p>
                          </div>
                       </div> 
                      @endforeach
                  </div>
                  <hr>
                  @php 
                  $objAddress = DiachiGiaoHang::getItem($item->id_user);
                  $arDC = Diachi::getInfo($objAddress->tinh,$objAddress->quan,$objAddress->phuong);
                  $diachi = $arDC[0];

                  @endphp
                  <div class="row" style="padding-left: 15px; ">
                      <h3 class="modal-title">Thông tin Khách Hàng </h3>
                      <div class="well col-md-offset-3 col-md-6">
                        <div class=" col-sm-4">
                            <p>Họ Tên:</p>
                        </div> 
                        <div class=" col-sm-8">
                            <p>{{ $objAddress->fullname }}</p> 
                        </div>
                        <div class=" col-sm-4">
                            <p>Số điện thoại:</p>
                        </div> 
                        <div class=" col-sm-8">
                            <p>{{ $objAddress->phone}}</p>
                        </div>
                        <div class=" col-sm-4">
                            <p>Địa chỉ:</p>
                        </div> 
                        <div class=" col-sm-8">
                            <p>{{$objAddress->address}}, {{$diachi->ptype}} {{$diachi->pname}} - {{$diachi->qtype}} {{$diachi->qname}} - {{$diachi->ttype}} {{$diachi->tname}} </p>
                        </div>
                      </div>
                  </div>
                  <hr>

                  <div class="row" style="padding-left: 15px; ">

                      <h3 class="modal-title">Vận chuyển: {{ ($item->vanchuyen == 1 )? 'Giao hàng tiêu chuẩn' : 'Giao hàng Nhanh'}} </h3>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
<!-- Modal -->
    <div class="modal fade" id="alertMSG" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header" style="background: #EDECEC">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Thông Báo</h4>
          </div>
          <div class="modal-body">
            <div class="text-center" id="alertContent" >
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

    function changeTTDH(id){
          var select = '#TTVC-'+id;
          var val = $(select).val();
          //alert(val);
          $.ajax({
            url: '{{route('admin.order.changeTTDH')}}',
            type: 'GET',
            cache: false,
            data: {idOrder: id, Val : val },
            success: function(data){
              //alert(data);
              if(data){
                $("#alertMSG").modal("show");
                $("#alertContent").html("Trạng thái Đơn Hàng "+id+" đã được thay đổi");
              }
            }, 
            error: function() {
             alert("Có lỗi");
           }
         }); 
          return false;
        }

</script>
        @stop

