<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Perview Laporan | Dishub Penomoran</title>
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
        
        <script>
            var baseUrl = "{{url('/')}}/";
            
        </script>
	</head>
	<body class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading the-body">
		<div class="d-flex flex-column flex-root">
			<div class="col-md-12 row mt-10 px-20">
                <div class="col-md-6" style="height: fit-content;">
                    <a href="{{url('report')}}" class="btn btn-light font-weight-bolder font-size-sm px-5 w-25"><i class="fas fa-arrow-left"></i>Kembali</a>
                </div>
                <div class="col-md-6 text-right" style="height: fit-content;">
                    <button class="btn btn-danger btn-pill font-weight-bolder font-size-sm px-5 w-25" onclick="window.print();"><i class="fas fa-print"></i>Cetak</button>
                </div>
                <div class="col-md-12 p-4 text-center" style="background-color:#fff" id="div-perview"></div>
            </div>
            
		</div>
        <script src="{{asset('assets/extends/js/perview.js')}}"></script>
	</body>
</html>