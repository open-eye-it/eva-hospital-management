@extends('layout.master');
@section('title', 'Profile')
@section('breadcrumb-module', 'Profile')
@section('page-content')
<!--begin::Row-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Mobile Toggle-->
                <button class="burger-icon burger-icon-left mr-4 d-inline-block d-lg-none" id="kt_subheader_mobile_toggle">
                    <span></span>
                </button>
                <!--end::Mobile Toggle-->
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Profile</h5>
                    <!--end::Page Title-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Profile Account Information-->
            <div class="d-flex flex-row">
                <!--begin::Aside-->
                <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                    <!--begin::Profile Card-->
                    <div class="card card-custom card-stretch">
                        <!--begin::Body-->
                        <div class="card-body pt-4">
                            <!--begin::User-->
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                    <div class="symbol-label" style="background-image:url('assets/media/users/blank.png')"></div>
                                    <i class="symbol-badge bg-success"></i>
                                </div>
                                <div>
                                    <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name }}</a>
                                    <div class="text-muted">{{ ucFirst(str_replace('["', '', str_replace('"]', '', Auth::user()->getRoleNames()))) }}</div>
                                </div>
                            </div>
                            <!--end::User-->
                            <!--begin::Contact-->
                            <div class="py-9">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold mr-2">Email:</span>
                                    <a href="#" class="text-muted text-hover-primary">{{ Auth::user()->email }}</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold mr-2">Phone:</span>
                                    <span class="text-muted">{{ Auth::user()->contactno }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="font-weight-bold mr-2">Address:</span>
                                    <span class="text-muted">{{ Auth::user()->address }}</span>
                                </div>
                            </div>
                            <!--end::Contact-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Profile Card-->
                </div>
                <!--end::Aside-->
                <!--begin::Content-->
                <div class="flex-row-fluid ml-lg-8">
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <!--begin::Header-->
                        <div class="card-header py-3">
                            <div class="card-title align-items-start flex-column">
                                <h3 class="card-label font-weight-bolder text-dark">Account Information</h3>
                                <span class="text-muted font-weight-bold font-size-sm mt-1">Change your account settings</span>
                                @if(session('success'))
                                <span class="text-success">{{ session('success') }}</span>
                                @endif
                                @if(session('error'))
                                <span class="text-danger">{{ session('error') }}</span>
                                @endif
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Form-->
                        <form class="form" method="POST" action="{{ route('change_password') }}" id="changePassword">
                            @csrf
                            <div class="card-body">
                                <!--begin::Heading-->
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <h5 class="font-weight-bold mb-6">Change Password:</h5>
                                    </div>
                                </div>
                                <!--begin::Form Group-->
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group">
                                            <input class="form-control form-control" type="password" id="old_password" name="old_password" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="old_pass_icon" onclick="showOldPassword()">
                                                    <i class="far fa-eye-slash icon-lg"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="old_password_err"></span>
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">Current Password</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="">
                                            <input class="form-control form-control" type="password" id="old_password" name="old_password" value="">
                                        </div>
                                        <span class="text-danger" id="old_password_err"></span>
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="">
                                            <input class="form-control form-control" type="password" id="password" name="password" value="">
                                        </div>
                                        <span class="text-danger" id="password_err"></span>
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">New Password</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="input-group">
                                            <input class="form-control form-control" type="password" id="password" name="password" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="new_pass_icon" onclick="showPassword()">
                                                    <i class="far fa-eye-slash icon-lg"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="password_err"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-xl-3"></label>
                                    <div class="col-lg-9 col-xl-6">
                                        <button type="submit" class="btn btn-primary mr-2">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Profile Account Information-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Row-->
<script>
    $('#changePassword').on('submit', function(e) {
        let old_password = $('#old_password').val();
        let password = $('#password').val();
        if (old_password == '') {
            e.preventDefault();
            $('#old_password_err').text('Please enter current password');
            timeoutID('old_password_err', 3000);
            scrollTop('old_password');
        } else if (password == '') {
            e.preventDefault();
            $('#password_err').text('Please enter new password');
            timeoutID('password_err', 3000);
            scrollTop('password');
        }
    });

    function showOldPassword() {
        let pa_attr = $('#old_password').attr('type');
        if (pa_attr == 'password') {
            $('#old_password').attr('type', 'text');
            $('#old_pass_icon i').removeClass('fa-eye-slash');
            $('#old_pass_icon i').addClass('fa-eye');
        } else {
            $('#old_password').attr('type', 'password');
            $('#old_pass_icon i').addClass('fa-eye-slash');
            $('#old_pass_icon i').removeClass('fa-eye');
        }
    }

    function showPassword() {
        let pa_attr = $('#password').attr('type');
        if (pa_attr == 'password') {
            $('#password').attr('type', 'text');
            $('#new_pass_icon i').removeClass('fa-eye-slash');
            $('#new_pass_icon i').addClass('fa-eye');
        } else {
            $('#password').attr('type', 'password');
            $('#new_pass_icon i').addClass('fa-eye-slash');
            $('#new_pass_icon i').removeClass('fa-eye');
        }
    }
</script>
@endsection