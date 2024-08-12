@extends('layout.master');
@section('title', 'Dashboard')
@section('breadcrumb-module', 'Dashboard')
@section('page-content')
<!--begin::Row-->
<div class="row">
    <div class="col-12">
        <h1>Dashboard</h1>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-danger card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <a href="#" class="text-white font-size-h1 text-hover-primary font-weight-bolder">OPD</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">All OPD</span>
                    </div>
                    <span class="symbol symbol-light-danger symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $opdAllCount }}</span>
                    </span>
                </div>
                <div class="progress progress-xs mt-7 bg-white-o-60">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 70%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-success card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <a href="#" class="text-white font-size-h1 text-hover-primary font-weight-bolder">IPD</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">All IPD</span>
                    </div>
                    <span class="symbol symbol-light-success symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $ipdAllCount }}</span>
                    </span>
                </div>
                <div class="progress progress-xs mt-7 bg-white-o-60">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 30%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-primary card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <a href="#" class="text-white font-size-h1 text-hover-primary font-weight-bolder">OPD</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">Today OPD</span>
                    </div>
                    <span class="symbol symbol-light-primary symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $opdTodayCount }}</span>
                    </span>
                </div>
                <div class="progress progress-xs mt-7 bg-white-o-60">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-info card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <a href="#" class="text-white font-size-h1 text-hover-primary font-weight-bolder">IPD</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">Today IPD</span>
                    </div>
                    <span class="symbol symbol-light-info symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $ipdTodayCount }}</span>
                    </span>
                </div>
                <div class="progress progress-xs mt-7 bg-white-o-60">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 60%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-dark card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <a href="#" class="text-white font-size-h1 text-hover-primary font-weight-bolder">Patient</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">Today New Patient</span>
                    </div>
                    <span class="symbol symbol-light-dark symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $ipdTodayCount }}</span>
                    </span>
                </div>
                <div class="progress progress-xs mt-7 bg-white-o-60">
                    <div class="progress-bar bg-white" role="progressbar" style="width: 40%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Row-->
@endsection