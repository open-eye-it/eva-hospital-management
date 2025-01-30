<div id="kt_header" class="header header-fixed d-none">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::User-->
            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="false">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                            <i class="la la-bell icon-3x text-info"></i>
                        </span>
                        <span class="pulse-ring"></span>
                    </div>
                </div>
                <!--end::Toggle-->
                <!--begin::Dropdown-->
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg" style="">
                    <form>
                        <!--begin::Header-->
                        <div class="d-flex flex-column pt-8 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(assets/media/misc/bg-1.jpg)">
                            <!--begin::Title-->
                            <h4 class="d-flex flex-center rounded-top pb-8">
                                <span class="text-white">Eva Notifications</span>
                                <!-- <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">23 new</span> -->
                            </h4>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Content-->
                        <div class="tab-content">
                            <div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
                                @php $notificationList = loginUserUnreadNotification()['notificationList']; @endphp
                                <!--begin::Scroll-->
                                <div class="scroll pr-7 mr-n7 ps ps--active-y" data-scroll="true" data-height="300" data-mobile-height="200" style="height: 300px; overflow: hidden;">
                                    @if(!empty($notificationList))
                                    @foreach($notificationList as $notification)
                                    @php $role = Auth::user()->role; $no_id = $notification['no_id'] ; $route = notificationRoute($notification['no_action']); @endphp
                                    <!--begin::Item-->
                                    <div class="cursor_pointer" onclick="openNotification('{{ $route }}', '{{ $no_id }}')">
                                        <div class="d-flex align-items-center mb-6">
                                            <div class="symbol symbol-40 symbol-light-info mr-5">
                                                <span class="symbol-label">
                                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                                        <i class="{{ $notification['no_icon'] }} icon-2x text-info"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <!--begin::Text-->
                                            <div class="d-flex flex-column font-weight-bold">
                                                <span class="text-dark text-hover-primary mb-1 font-size-lg">{{ $notification['no_subject'] }} - {{ ($notification['ap_id'] != '') ? $notification['ap_id'] : $notification['ipd_id'] }}</span>
                                                <span class="text-muted">{{ $notification['no_message'] }}</span>
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                    </div>
                                    <!--end::Item-->
                                    @endforeach
                                    @else
                                    <h3>No any pending notification</h3>
                                    @endif
                                </div>
                                <!--end::Scroll-->
                            </div>
                        </div>
                        <!--end::Content-->
                    </form>
                </div>
                <!--end::Dropdown-->
            </div>
            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ Auth::user()->person_name }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">{{ Str::charAt(Auth::user()->person_name, 0) }}</span>
                    </span>
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>