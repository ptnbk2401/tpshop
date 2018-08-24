<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="keywords" content="Winter Login Form Responsive widget, Flat Web Templates, Android Compatible web template, 

    Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- stylesheets -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="/public/templates/login/css/style.css">

    <!-- google fonts  -->

    <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">

</head>

<body>

    <div class="agile-login">

        <h1>Trang đăng nhập TPShop AdminCP</h1>

        <div class="wrapper">

            <h2>đăng nhập</h2>

            <div class="w3ls-form">

                 <form action="{{route('auth.login')}}" method="post">
                    @csrf

                    <label>Tên Đăng nhập</label>

                    <input type="text" name="username" placeholder="Nhập tên đăng nhập"/>

                    <label>Mật khẩu</label>

                    <input type="password" name="password" placeholder="Nhập mật khẩu" />

                    <!-- <a href="#" class="pass">Forgot Password ?</a> -->

                    <input type="submit" value="Đăng nhập" name="submit" />
                    <label >{{Session::get('msg')}}</label>
                </form>

            </div>

            

            <div class="agile-icons">

                <a href="https://twitter.com/ntp_bbbr" target="_blank" ><span class="fa fa-twitter" aria-hidden="true"></span></a>

                <a href="https://www.facebook.com/ntpbg" target="_blank"><span class="fa fa-facebook"></span></a>

                <a href="https://www.pinterest.com/ptnbk2401/" target="_blank"><span class="fa fa-pinterest-p"></span></a>

            </div>

        </div>

        <br>

        <div class="copyright">

         <p>© 2018 Login for TPShop. Nguyen Phan CV | Phát triển bởi <a href="https://www.facebook.com/ntpbg" target="_blank">Nguyen Phan</a></p>

    </div>

    </div>

    

</body>

</html>