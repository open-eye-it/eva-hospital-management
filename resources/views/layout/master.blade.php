<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="{{ url('/') }}">
	<meta charset="utf-8" />
	<title>EVA - Womens Hospital and Endoscopy Centre | @yield('title')</title>
	<meta name="description" content="Aside light theme example" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	@include('layout.style')
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
	<!--begin::Main-->
	<!--begin::Header Mobile-->
	@include('layout.header-mobile')
	<!--end::Header Mobile-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">
			<!--begin::Aside-->
			@include('layout.sidebar')
			<!--end::Aside-->
			<!--begin::Wrapper-->
			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
				<!--begin::Header-->
				@include('layout.header-top')
				<!--end::Header-->
				<!--begin::Content-->
				<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
					<!--begin::Subheader-->
					@include('layout.header-breadcrumb')
					<!--end::Subheader-->
					<!--begin::Entry-->
					<div class="d-flex flex-column-fluid">
						<!--begin::Container-->
						<div class="container">
							<!--begin::Dashboard-->
							@yield('page-content')
							<!--end::Dashboard-->
						</div>
						<!--end::Container-->
					</div>
					<!--end::Entry-->
				</div>
				<!--end::Content-->
				<!--begin::Footer-->
				@include('layout.footer')
				<!--end::Footer-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--end::Page-->
	</div>
	<!--end::Main-->
	<!-- begin::User Panel-->
	@include('layout.profile-panel')
	<!-- end::User Panel-->
	<!--begin::Scrolltop-->
	@include('layout.scrolltop')
	<!--end::Scrolltop-->
	<!--begin::Script-->
	@include('layout.script')
	<!--end::Script-->
	<script>
		function openNotification(route, no_id, role) {
			$.ajax({
				url: "{{ route('notification.read') }}" + "?no_id=" + btoa(no_id),
				method: "GET",
				success: function(res) {
					if (res.response === true) {
						window.location.href = route;
					} else {
						sweetAlertError(res.message, 3000);
					}
				},
				error: function(r) {
					let res = r.responseJSON;
					sweetAlertError(res.message, 3000);
				}
			});
		}
	</script>
	@yield('custom-script')
</body>
<!--end::Body-->

</html>