<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="{{ url('/') }}">
	<meta charset="utf-8" />
	<title>EVA - Womens Hospital and Endoscopy Centre | signin</title>
	<meta name="description" content="Login page example" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="canonical" href="{{ url('/') }}" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Page Custom Styles(used by this page)-->
	<link href="{{ asset('assets/css/pages/login/classic/login-4.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles-->
	<!--begin::Global Theme Styles(used by all pages)-->
	<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Global Theme Styles-->
	<!--begin::Layout Themes(used by all pages)-->
	<link href="{{ asset('assets/css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
	<!--end::Layout Themes-->
	<link rel="shortcut icon" href="{{ asset('assets/eva/img/logo/favicon-1.ico') }}" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
		<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
			<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('assets/media/bg/bg-3.jpg');">
				<div class="login-form text-center p-7 position-relative overflow-hidden">
					<!--begin::Login Header-->
					<div class="d-flex flex-center mb-15">
						<a href="">
							<img src="assets/eva/img/logo/eva-logo.png" class="max-h-150px" alt="" />
						</a>
					</div>
					<!--end::Login Header-->
					<!--begin::Login Sign in form-->
					<div class="login-signin">
						<div class="mb-20">
							<h3>Sign In To EVA</h3>
							<div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
						</div>
						@if($error = \Session::get('error'))
						<div class="alert alert-danger mt-3 text-left">{!! $error !!}</div>
						@endif
						<form class="form" id="kt_login_signin_form" method="POST" action="{{ route('signin.submit') }}" id="signinSubmit">
							@csrf
							<div class="form-group mb-5 text-left">
								<input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Username" name="username" id="username" autocomplete="off" />
								<span class="text text-danger" id="usernameErr"></span>
							</div>
							<div class="form-group mb-5 text-left">
								<input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" id="password" />
								<span class="text text-danger" id="passwordErr"></span>
							</div>
							<button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button>
						</form>
					</div>
					<!--end::Login Sign in form-->
				</div>
			</div>
		</div>
		<!--end::Login-->
	</div>
	<!--end::Main-->
	<!--begin::Global Config(global config for global JS scripts)-->
	<!-- <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script> -->
	<!--end::Global Config-->
	<!--begin::Global Theme Bundle(used by all pages)-->
	<!-- <script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script> -->
	<!--end::Global Theme Bundle-->
	<!--begin::Page Scripts(used by this page)-->
	<!-- <script src="assets/js/pages/custom/login/login-general.js"></script> -->
	<!--end::Page Scripts-->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="{{ asset('assets/js/custom.js') }}"></script>
	<script>
		$("form").submit(function(e) {
			let username = $('#username').val();
			let password = $('#password').val();
			if (username == '') {
				e.preventDefault();
				$('#usernameErr').text('Please enter username');
				timeoutID('usernameErr', 3000);
			} else if (password == '') {
				e.preventDefault();
				$('#passwordErr').text('Please enter password');
				timeoutID('passwordErr', 3000);
			} else {

			}
		})
	</script>
</body>
<!--end::Body-->

</html>