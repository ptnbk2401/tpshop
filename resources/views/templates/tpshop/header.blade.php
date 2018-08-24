<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="{{$urlTpshop}}/images/favicon.png">
   <title>Welcome to FlatShop</title>
   <link href="{{$urlTpshop}}/css/bootstrap.css" rel="stylesheet">
   <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,700,500italic,100italic,100' rel='stylesheet' type='text/css'>
   <link href="{{$urlTpshop}}/css/font-awesome.min.css" rel="stylesheet">
   <link rel="stylesheet" href="{{$urlTpshop}}/css/flexslider.css" type="text/css" media="screen"/>
   <link href="{{$urlTpshop}}/css/sequence-looptheme.css" rel="stylesheet" media="all"/>
   <link href="{{$urlTpshop}}/css/style.css" rel="stylesheet">
   <link href="{{$urlTpshop}}/css/cart.css" rel="stylesheet">
   <script type="text/javascript" src="{{$urlTpshop}}/js/jquery-1.10.2.min.js"></script>
   <script type="text/javascript" src="{{$urlTpshop}}/js/jquery.easing.1.3.js"></script>
   <script type="text/javascript" src="{{$urlTpshop}}/js/bootstrap.min.js"></script>
   <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
   <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
   {{-- Paypal --}}
   <script src="https://www.paypalobjects.com/api/checkout.js"></script>
   <!--[if lt IE 9]><script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script><script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script><![endif]-->
</head>
<body id="{{Request::is('/')? 'home' : ''}}" data-spy="scroll">
   <div class="wrapper">
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-2 col-sm-2">
                  <div class="logo"><a href="index.html"><img src="{{$urlTpshop}}/images/logo.png" alt="FlatShop"></a></div>
               </div>
               <div class="col-md-10 col-sm-10">
                  <div class="header_top">
                     <div class="row">
                        <div class="col-md-offset-3 col-md-5  ">
                           <ul class="topmenu">
                              <li><a href="#">Thông tin Shop</a></li>
                              <li><a href="#">Tin Tức</a></li>
                              <li><a href="#">Liên Hệ</a></li>
                           </ul>
                        </div>
                        <div class="col-md-4">
                           <ul class="usermenu">
                              @if(isset($objUser))
                              <li>
                                    <a href="javascript:void(0)" class="log" data-toggle="dropdown" >{{$objUser->fullname}} <span class="caret"></span></a> 
                                    <ul class="dropdown-menu user-menu">
                                       <li><a href="{{route('tpshop.user.profile')}}">Thông tin</a></li>
                                       <li><a href="{{route('tpshop.pay.finish')}}">Xem Đơn Hàng</a></li>
                                       <li><a href="{{route('auth.logout')}}">Đăng xuất</a></li>
                                    </ul>
                              </li>
                              @else
                              <li><a href="javascript:void(0)" class="log" data-toggle="modal" data-target="#singin">Đăng Nhập/Đăng Ký</a></li>
                              @endif
                           </ul>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="header_bottom">
                     <ul class="option">
                        <li id="search" class="search">
                           @include('tpshop.search')  
                        </li>
                        <li class="option-cart">
                           @include('tpshop.cart')  
                        </li>
                     </ul>
                     <div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button></div>
                     <div class="navbar-collapse collapse">
                       @include('tpshop.menu-cat')  
                    </div>
                 </div>
              </div>
           </div>
        </div>

     </div>
     <div class="clearfix"></div>
     <div id="singin" class="modal fade" role="dialog"  aria-hidden="true">
      <div class="modal-dialog .modal-sm" >
         <!-- Modal content-->
         <div class="modal-content" style="padding: 20px">
            <div class="row">
               <div class="col-md-10 col-md-offset-1">
                  <div class="panel panel-login">
                     <div class="panel-heading">
                        <div class="row">
                           <div class="col-xs-6">
                              <a href="#" class="active" id="login-form-link">Đăng Nhập</a>
                           </div>
                           <div class="col-xs-6">
                              <a href="#" id="register-form-link">Đăng Ký</a>
                           </div>
                        </div>
                        <hr>
                     </div>
                     <div class="panel-body">
                        <div class="row">
                           <div class="col-lg-12">
                              <form id="login-form" action="{{route('auth.login')}}" method="post" role="form" style="display: block;"> 
                                 @csrf
                                 <div class="form-group">
                                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Tên đăng nhập" value="">
                                 </div>
                                 <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Mật khẩu">
                                 </div>
                                 <div class="form-group">
                                    <div class="row">
                                       <div class="col-sm-6 col-sm-offset-3">
                                          <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Đăng Nhập">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="text-center">
                                             <a href="" tabindex="5" class="forgot-password">Quên mật khẩu?</a>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                              <form id="register-form" action="{{route('tpshop.user.add')}}" method="post" role="form" style="display: none;">
                                 @csrf
                                 <div class="form-group">
                                    <input type="text" name="fullname" id="fullname" tabindex="1" class="form-control" placeholder="Họ Tên" value="">
                                 </div>
                                 <div class="form-group">
                                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Tên đăng nhập" value="">
                                 </div>
                                 <div class="form-group">
                                    <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Địa chỉ Email" >
                                 </div>
                                 <div class="form-group">
                                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Mật khẩu">
                                 </div>
                                 
                                 <div class="form-group">
                                    <div class="row">
                                       <div class="col-sm-6 col-sm-offset-3">
                                          <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Đăng Ký">
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

<script>
   jQuery(function() {

    jQuery('#login-form-link').click(function(e) {
      jQuery("#login-form").delay(100).fadeIn(100);
      jQuery("#register-form").fadeOut(100);
      jQuery('#register-form-link').removeClass('active');
      jQuery(this).addClass('active');
      e.preventDefault();
   });
   jQuery('#register-form-link').click(function(e) {
      jQuery("#register-form").delay(100).fadeIn(100);
      jQuery("#login-form").fadeOut(100);
      jQuery('#login-form-link').removeClass('active');
      jQuery(this).addClass('active');
      e.preventDefault();
   });

});
</script>





