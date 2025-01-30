<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
	<!--begin::Brand-->
	<div class="brand flex-column-auto" id="kt_brand">
		<!--begin::Logo-->
		<a href="{{ route('dashboard') }}" class="brand-logo">
			<img alt="Logo" src="assets/eva/img/logo/eva-logo-1.png" class="max-h-50px" />
		</a>
		<!--end::Logo-->
		<!--begin::Toggle-->
		<button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
			<span class="svg-icon svg-icon svg-icon-xl">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
						<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
					</g>
				</svg>
				<!--end::Svg Icon-->
			</span>
		</button>
		<!--end::Toolbar-->
	</div>
	<!--end::Brand-->
	<!--begin::Aside Menu-->
	<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
		<!--begin::Menu Container-->
		<div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
			<!--begin::Menu Nav-->
			<ul class="menu-nav">
				<li class="menu-item {{ (Request::segment(1) == 'dashboard') ? 'menu-item-active' : '' }}" aria-haspopup="true">
					<a href="{{ route('dashboard') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
							<i class="icon-2x flaticon-dashboard"></i>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-text">Dashboard</span>
					</a>
				</li>
				@if(auth()->user()->hasRole('doctor'))
				<li class="menu-item {{ (Request::segment(1) == 'doctor' && Request::segment(2) == 'opd-ipd') ? 'menu-item-active' : '' }}" aria-haspopup="true">
					<a href="{{ route('doctor_opd_ipd.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
							<i class="icon-2x flaticon-user-settings"></i>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-text">OPD/IPD</span>
					</a>
				</li>
				@endif
				@if(auth()->user()->can('patient-read'))
				<li class="menu-section">
					<h4 class="menu-text">OPD/IPD</h4>
					<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
				</li>
				@endif
				@can('patient-read')
				<li class="menu-item {{ (Request::segment(1) == 'patient') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('patient.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user-settings"></i>
						</span>
						<span class="menu-text">Patient (F2)</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'patient') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user-settings"></i>
						</span>
						<span class="menu-text">Patient</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('patient-create')
							<li class="menu-item {{ (Request::segment(1) == 'patient' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('patient.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('patient-read')
							<li class="menu-item {{ (Request::segment(1) == 'patient' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('patient.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@can('appointment-read')
				<li class="menu-item {{ (Request::segment(1) == 'appointment') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('appointment.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-calendar-2"></i>
						</span>
						<span class="menu-text">Appointment (F8)</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'appointment') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-calendar-2"></i>
						</span>
						<span class="menu-text">Appointment</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('appointment-create')
							<li class="menu-item {{ (Request::segment(1) == 'appointment' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('appointment.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('appointment-read')
							<li class="menu-item {{ (Request::segment(1) == 'appointment' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('appointment.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@can('ipd-read')
				<li class="menu-item {{ (Request::segment(1) == 'ipd') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('ipd.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-bed"></i>
						</span>
						<span class="menu-text">IPD (F9)</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'ipd') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-bed"></i>
						</span>
						<span class="menu-text">IPD</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('ipd-create')
							<li class="menu-item {{ (Request::segment(1) == 'ipd' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('ipd.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('ipd-read')
							<li class="menu-item {{ (Request::segment(1) == 'ipd' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('ipd.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@if(auth()->user()->can('follow-up-opd-read') || auth()->user()->can('follow-up-ipd-read'))
				<li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'follow-up') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-calendar-with-a-clock-time-tools"></i>
						</span>
						<span class="menu-text">Follow Up</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('follow-up-opd-read')
							<li class="menu-item {{ (Request::segment(1) == 'follow-up' && Request::segment(2) == 'opd') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('follow-up.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">OPD</span>
								</a>
							</li>
							@endcan
							@can('follow-up-ipd-read')
							<li class="menu-item {{ (Request::segment(1) == 'follow-up' && Request::segment(2) == 'ipd') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('follow-up.ipd.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">IPD</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li>
				@endif
				@if(auth()->user()->can('account-detail-opd-read') || auth()->user()->can('account-detail-ipd-read'))
				<li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'opd-account-detail' || Request::segment(1) == 'ipd-account-detail') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-money-bill-wave"></i>
						</span>
						<span class="menu-text">Account Detail</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('account-detail-opd-read')
							<li class="menu-item {{ (Request::segment(1) == 'opd-account-detail') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('opd-account-detail.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">OPD</span>
								</a>
							</li>
							@endcan
							@can('account-detail-ipd-read')
							<li class="menu-item {{ (Request::segment(1) == 'ipd-account-detail' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('ipd-acount-detail.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">IPD</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li>
				@endif
				@if(auth()->user()->can('balance-read'))
				<li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'balance') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-money-bill-wave"></i>
						</span>
						<span class="menu-text">Balance</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							<li class="menu-item {{ (Request::segment(1) == 'balance' && Request::segment(2) == 'opd') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('balance.opd') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">OPD</span>
								</a>
							</li>
							<li class="menu-item {{ (Request::segment(1) == 'balance' && Request::segment(2) == 'ipd') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('balance.ipd') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">IPD</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				@endif
				@if(auth()->user()->can('general-medicine-read') || auth()->user()->can('operation-medicine-read') || auth()->user()->can('post-operative-medicine-read'))
				<li class="menu-section">
					<h4 class="menu-text">Medicine</h4>
					<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
				</li>
				<li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'medicine') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-tablets"></i>
						</span>
						<span class="menu-text">Medicine</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('general-medicine-read')
							<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'general-medicine') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('general-medicine.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">General Medicine</span>
								</a>
							</li>
							@endcan
							@can('operation-medicine-read')
							<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'operation-medicine') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('operation-medicine.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Operation Medicine</span>
								</a>
							</li>
							@endcan
							@can('post-operative-medicine-read')
							<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'post-operative-medicine') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('post-medicine.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Post Operative Medicine</span>
								</a>
							</li>
							@endcan
							@can('pre-operative-medicine-read')
							<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'pre-operative-medicine') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('pre-medicine.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Pre Operative Medicine</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'medicine') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-tablets"></i>
						</span>
						<span class="menu-text">Medicine</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							<li class="menu-item menu-item-parent" aria-haspopup="true">
								<span class="menu-link">
									<span class="menu-text">Medicine</span>
								</span>
							</li>
							@can('general-medicine-read')
							<li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'general-medicine') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">General Medicine</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										@can('general-medicine-create')
										<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'general-medicine' && Request::segment(3) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
											<a href="{{ route('general-medicine.create') }}" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Add</span>
											</a>
										</li>
										@endcan
										@can('general-medicine-read')
										<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'general-medicine' && Request::segment(3) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
											<a href="{{ route('general-medicine.list') }}" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">List</span>
											</a>
										</li>
										@endcan
									</ul>
								</div>
							</li>
							@endcan
							@can('operation-medicine-read')
							<li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'operation-medicine') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
								<a href="javascript:;" class="menu-link menu-toggle">
									<i class="menu-bullet menu-bullet-line">
										<span></span>
									</i>
									<span class="menu-text">Operation Medicine</span>
									<i class="menu-arrow"></i>
								</a>
								<div class="menu-submenu">
									<i class="menu-arrow"></i>
									<ul class="menu-subnav">
										@can('operation-medicine-create')
										<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'operation-medicine' && Request::segment(3) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
											<a href="{{ route('operation-medicine.create') }}" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">Add</span>
											</a>
										</li>
										@endcan
										@can('operation-medicine-read')
										<li class="menu-item {{ (Request::segment(1) == 'medicine' && Request::segment(2) == 'operation-medicine' && Request::segment(3) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
											<a href="{{ route('operation-medicine.list') }}" class="menu-link">
												<i class="menu-bullet menu-bullet-dot">
													<span></span>
												</i>
												<span class="menu-text">List</span>
											</a>
										</li>
										@endcan
									</ul>
								</div>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endif
				@if(auth()->user()->can('category-read') || auth()->user()->can('user-read') || auth()->user()->can('visiting-fee-read') || auth()->user()->can('trainee-read') || auth()->user()->can('room-read') || auth()->user()->can('referred-doctor-read'))
				<li class="menu-section">
					<h4 class="menu-text">Admin</h4>
					<i class="menu-icon ki ki-bold-more-hor icon-md"></i>
				</li>
				@endif
				@can('mac-address-read')
				<li class="menu-item {{ (Request::segment(1) == 'mac_address') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('mac_address.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-server"></i>
						</span>
						<span class="menu-text">System IP Address</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'mac_address') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-server"></i>
						</span>
						<span class="menu-text">System IP Address</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('mac-address-create')
							<li class="menu-item {{ (Request::segment(1) == 'mac_address' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('mac_address.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('mac-address-read')
							<li class="menu-item {{ (Request::segment(1) == 'mac_address' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('mac_address.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@can('category-read')
				<li class="menu-item {{ (Request::segment(1) == 'category') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('category.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user"></i>
						</span>
						<span class="menu-text">User Categories</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'category') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user"></i>
						</span>
						<span class="menu-text">User Categories</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('category-create')
							<li class="menu-item {{ (Request::segment(1) == 'category' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('category.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('category-read')
							<li class="menu-item {{ (Request::segment(1) == 'category' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('category.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@can('user-read')
				<li class="menu-item {{ (Request::segment(1) == 'user') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('user.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-users"></i>
						</span>
						<span class="menu-text">User</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'user') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-users"></i>
						</span>
						<span class="menu-text">User</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('user-create')
							<li class="menu-item {{ (Request::segment(1) == 'user' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('user.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('user-read')
							<li class="menu-item {{ (Request::segment(1) == 'user' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('user.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@can('visiting-fee-read')
				<li class="menu-item {{ (Request::segment(1) == 'visiting_fee') ? 'menu-item-active' : '' }}" aria-haspopup="true">
					<a href="{{ route('visiting_fee.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg-->
							<i class="icon-2x la la-rupee-sign"></i>
							<!--end::Svg Icon-->
						</span>
						<span class="menu-text">Visiting Fee</span>
					</a>
				</li>
				@endcan
				@can('trainee-read')
				<li class="menu-item {{ (Request::segment(1) == 'trainee') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('trainee.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user-ok"></i>
						</span>
						<span class="menu-text">Trainee</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'trainee') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user-ok"></i>
						</span>
						<span class="menu-text">Trainee</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('trainee-create')
							<li class="menu-item {{ (Request::segment(1) == 'trainee' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('trainee.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('trainee-read')
							<li class="menu-item {{ (Request::segment(1) == 'trainee' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('trainee.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@can('room-read')
				<li class="menu-item {{ (Request::segment(1) == 'room') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('room.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-bed"></i>
						</span>
						<span class="menu-text">Room</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'room') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x la la-bed"></i>
						</span>
						<span class="menu-text">Room</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('room-create')
							<li class="menu-item {{ (Request::segment(1) == 'room' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('room.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('room-read')
							<li class="menu-item {{ (Request::segment(1) == 'room' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('room.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				@can('referred-doctor-read')
				<li class="menu-item {{ (Request::segment(1) == 'referred-doctor') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('referred-doctor.list') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user-add"></i>
						</span>
						<span class="menu-text">Referred By</span>
					</a>
				</li>
				<!-- <li class="menu-item menu-item-submenu {{ (Request::segment(1) == 'referred-doctor') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true" data-menu-toggle="hover">
					<a href="javascript:;" class="menu-link menu-toggle">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-user-add"></i>
						</span>
						<span class="menu-text">Referred By</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="menu-submenu">
						<i class="menu-arrow"></i>
						<ul class="menu-subnav">
							@can('referred-doctor-create')
							<li class="menu-item {{ (Request::segment(1) == 'referred-doctor' && Request::segment(2) == 'create') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('referred-doctor.create') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">Add</span>
								</a>
							</li>
							@endcan
							@can('referred-doctor-read')
							<li class="menu-item {{ (Request::segment(1) == 'referred-doctor' && Request::segment(2) == 'list') ? 'menu-item-active' : '' }}" aria-haspopup="true">
								<a href="{{ route('referred-doctor.list') }}" class="menu-link">
									<i class="menu-bullet menu-bullet-dot">
										<span></span>
									</i>
									<span class="menu-text">List</span>
								</a>
							</li>
							@endcan
						</ul>
					</div>
				</li> -->
				@endcan
				<li class="menu-item {{ (Request::segment(1) == 'profile') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('profile') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-profile-1"></i>
						</span>
						<span class="menu-text">Profile</span>
					</a>
				</li>
				<li class="menu-item {{ (Request::segment(1) == 'signout') ? 'menu-item-open menu-item-here' : '' }}" aria-haspopup="true">
					<a href="{{ route('signout') }}" class="menu-link">
						<span class="svg-icon menu-icon">
							<i class="icon-2x flaticon-logout"></i>
						</span>
						<span class="menu-text">Sign Out</span>
					</a>
				</li>
			</ul>
			<!--end::Menu Nav-->
		</div>
		<!--end::Menu Container-->
	</div>
	<!--end::Aside Menu-->
</div>