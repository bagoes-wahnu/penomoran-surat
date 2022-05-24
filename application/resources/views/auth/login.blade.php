<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Login | Dishub Penomoran</title>
		<meta name="description" content="Login page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<link href="{{ url('assets/metronic-7/assets') }}/plugins/global/plugins.bundle.css?v=7.1.7" rel="stylesheet" type="text/css" />
		<link href="{{ url('assets/metronic-7/assets') }}/plugins/custom/prismjs/prismjs.bundle.css?v=7.1.7" rel="stylesheet" type="text/css" />
		<link href="{{ url('assets/metronic-7/assets') }}/css/style.bundle.css?v=7.1.7" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/extends')}}/css/ewp.css" rel="stylesheet" type="text/css"/>
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<script src="{{ url('assets/metronic-7/assets') }}/plugins/global/plugins.bundle.js?v=7.1.7"></script>
		<script src="{{ url('assets/metronic-7/assets') }}/plugins/custom/prismjs/prismjs.bundle.js?v=7.1.7"></script>
        <script src="{{ url('assets/metronic-7/assets') }}/js/scripts.bundle.js?v=7.1.7"></script>
        <script src="{{asset('assets/extends')}}/js/ewp.js"></script>
        <style>
            .the-body{
                display: flex;
                justify-content: center;
            }
            .login-bg-1{
                width: 1240px;
                height: 85vh;
                margin: 0 auto;
                border-bottom-left-radius: 10px;
                border-bottom-right-radius: 10px;
                background: linear-gradient(269.48deg, #F89B29 0.45%, #FF0F7B 99.6%);
            }
            img{
                position: absolute;
                left: 32rem;
                top: 19vmin;
                width: 50vmin;
            }
            .form-login{
                position: absolute;
                width: 1040px;
                height: 30vh;
                left: 25rem;
                top: 68vh;
                background: #FFFFFF;
                box-shadow: 0px 100px 80px rgba(211, 211, 211, 0.07), 0px 41.7776px 33.4221px rgba(211, 211, 211, 0.0503198), 0px 22.3363px 17.869px rgba(211, 211, 211, 0.0417275), 0px 12.5216px 10.0172px rgba(211, 211, 211, 0.035), 0px 6.6501px 5.32008px rgba(211, 211, 211, 0.0282725), 0px 2.76726px 2.21381px rgba(211, 211, 211, 0.0196802);
                border-radius: 10px;
                padding: 40px 25px;
            }
            h1{
                font-style: normal;
                font-weight: 600;
                font-size: 6vmin;
                line-height: 72px;
                color: #FFFFFF;
                padding-top: 5vh;
                padding-left: 100px;
            }
            h2{
                font-style: normal;
                font-weight: 600;
                font-size: 28px; 
                line-height: 42px;
                color: #3F4254;
            }
            h3{
                font-style: normal;
                font-weight: normal;
                font-size: 3vmin;
                line-height: 36px;
                color: #FFFFFF;
                padding-left: 100px;
            }
            .fw{
                width: 100%;
            }

            @media only screen and (max-width: 1440px) {
                .login-bg-1{
                    width: 1240px;
                    margin: 0 auto;
                    border-bottom-left-radius: 10px;
                    border-bottom-right-radius: 10px;
                    background: linear-gradient(269.48deg, #F89B29 0.45%, #FF0F7B 99.6%);
                }
                .form-login{
                    position: absolute;
                    width: 1040px;
                    left: calc((100vw - 1040px) / 2);
                }
                img{
                    position: absolute;
                    left: calc((100vw - 90vmin) / 2);
                    width: 90vmin;
                }
            }

            @media only screen and (max-width: 1280px) {
                .login-bg-1{
                    width: 1100px;
                }
                .form-login{
                    width: 890px;
                    left: calc((100vw - 890px) / 2);
                }
                img{
                    position: absolute;
                    left: calc((100vw - 100vmin) / 2);
                    width: 100vmin;
                }
            }

            @media only screen and (max-width: 1024px) {
                .login-bg-1{
                    width: 900px;
                }
                .form-login{
                    width: 785px;
                    left: calc((100vw - 785px) / 2);
                }
                img{
                    position: absolute;
                    left: calc((100vw - 100vmin) / 2);
                    width: 100vmin;
                }
            }

            @media only screen and (max-width: 768px) {
                
            }

            @media only screen and (max-width: 600px) {
                
            }
        </style>
        <script>
            var baseUrl = "{{url('/')}}/";
            
        </script>
	</head>
	<body class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading the-body">
		<div class="d-flex flex-column flex-root">
			<div class="login-bg-1">
                <h1>Aplikasi Penomoran Surat</h1>
                <h3>Dinas Perhubungan Kota Surabaya</h3>
                <img src="{{ url('assets/extends/images/bg-login-ilustrasi.svg') }}">
                <div class="form-login">
                    <div class="form-group">
                        <h2>Silahkan Masuk</h2>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="user" placeholder="Masukkan username">
                            </div>
                            <div class="col-md-5">
                                <input type="password" id="psw" class="form-control" name="password" placeholder="Masukkan password">
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="loginBtn" class="btn btn-default fw">Masuk</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
		</div>
        <script src="{{asset('assets/extends/js/login.js')}}"></script>
	</body>
</html>