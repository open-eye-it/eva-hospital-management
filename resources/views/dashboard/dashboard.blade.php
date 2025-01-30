@extends('layout.master');
@section('title', 'Dashboard')
@section('breadcrumb-module', 'Dashboard')
@section('page-content')
<!--begin::Row-->
<div class="row mb-4">
    <div class="col-12 text-right">
        <h4>Date: {{ date('d M Y') }}</h4>
    </div>
</div>
<div class="row dashboard">
    <!-- <div class="col-12">
        <h1>Dashboard</h1>
    </div> -->
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-primary card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <i class="icon-2x flaticon-calendar-2 text-white"></i>
                        @role('doctor')
                        <a href="{{ route('doctor_opd_ipd.list') }}?appointment_date_range={{ date('Y-m-d') }}+-+{{ date('Y-m-d') }}" class="text-decoration-underline text-white font-size-h1 font-weight-bolder mt-4">OPD</a>
                        @else
                        <a href="{{ route('appointment.list') }}?appointment_date_range={{ date('Y-m-d') }}+-+{{ date('Y-m-d') }}" class="text-white font-size-h1 font-weight-bolder mt-4">OPD</a>
                        @endrole
                        <span class="text-white font-size-h6 font-weight-bold mt-2">Today OPD</span>
                    </div>
                    <span class="symbol symbol-light-primary symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $opdTodayCount }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-info card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <i class="icon-3x la la-bed text-white"></i>
                        @role('doctor')
                        <a href="{{ route('doctor_opd_ipd.list').'?admit_date_range='.date('Y-m-d').'+-+'.date('Y-m-d') }}" class="text-white font-size-h1 font-weight-bolder mt-4">IPD</a>
                        @else
                        <a href="{{ route('ipd.list').'?admit_date_range='.date('Y-m-d').'+-+'.date('Y-m-d') }}" class="text-white font-size-h1 font-weight-bolder mt-4">IPD</a>
                        @endrole
                        <span class="text-white font-size-h6 font-weight-bold mt-2">Today IPD</span>
                    </div>
                    <span class="symbol symbol-light-info symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $ipdTodayCount }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-dark card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <i class="icon-2x flaticon-user-settings text-white"></i>
                        <a href="{{ route('patient.list') }}?date={{ date('Y-m-d') }}" class="text-white font-size-h1 font-weight-bolder mt-4">Patient</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">Today New Patient</span>
                    </div>
                    <span class="symbol symbol-light-dark symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $patientTodayCount }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-warning card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <i class="icon-2x flaticon-calendar-2 text-white"></i>
                        <a href="{{ route('appointment.list') }}" class="text-white font-size-h1 font-weight-bolder mt-4">OPD</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">All OPD</span>
                    </div>
                    <span class="symbol symbol-light-danger symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $opdAllCount }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-success card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <i class="icon-3x la la-bed text-white"></i>
                        <a href="{{ route('ipd.list') }}" class="text-white font-size-h1 font-weight-bolder mt-4">IPD</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">All IPD</span>
                    </div>
                    <span class="symbol symbol-light-success symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $ipdAllCount }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
        <div class="card card-custom bg-dark card-stretch gutter-b">
            <div class="card-body my-4">
                <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                    <div class="d-flex flex-column mr-2">
                        <i class="icon-2x flaticon-user-settings text-white"></i>
                        <a href="{{ route('patient.list') }}" class="text-white font-size-h1 font-weight-bolder mt-4">Patient</a>
                        <span class="text-white font-size-h6 font-weight-bold mt-2">All Patient</span>
                    </div>
                    <span class="symbol symbol-light-dark symbol-70">
                        <span class="symbol-label font-weight-bolder font-size-h1">{{ $patientAllCount }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Row-->
@endsection