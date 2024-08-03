@extends('layout.master');
@section('title', 'OPD-IPD - List')
@section('breadcrumb-module', 'OPd-IPD')
@section('page-content')
<div class="row">
    <div class="col-12">
        <div class="card card-custom gutter-b p-5">
            <form action="{{ route('doctor_opd_ipd.list') }}" class="mb-0">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 form-group">
                        <label for="search_text">OPD/IPD ID</label>
                        <input type="text" class="form-control" placeholder="Search ID" name="search_text" id="search_text" value="{{ $filterData['search_text'] }}">
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 form-group">
                        <label for="patient">Patient</label>
                        <select name="patient" id="patient" class="form-control">
                            <option value="">Select</option>
                            @if(!empty($patientList))
                            @foreach($patientList as $plist)
                            <option value="{{ $plist->pa_id }}" {{ ($plist->pa_id == $filterData['patient']) ? 'selected' : '' }}>{{ $plist->pa_name }} - {{ $plist->pa_id }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 form-group">
                        <label for="appointment_date">OPD/IPD Date</label>
                        <div class='input-group' id='appointment_date_range'>
                            <input type='text' name="date_range" id="appointment_date_range_filter" class="form-control" placeholder="Select date range" value="{{ $filterData['date_range'] }}" />
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6 form-group">
                        <label for="patient">Case Type</label>
                        <select class="form-control" name="case_type" id="case_type" onchange="changeFee(this.value)">
                            <option value="">Select</option>
                            @if(!empty($visitingFees))
                            @foreach($visitingFees as $fee)
                            <option value="{{ $fee->vf_case_type }}" {{ ($fee->vf_case_type == $filterData['case_type']) ? 'selected' : '' }}>{{ ucfirst($fee->vf_case_type) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 form-group mb-0 pt-lg-4 mt-lg-4 pt-md-4 mt-md-4">
                        <button class="btn btn-primary" type="submit">Search</button>
                        <a class="btn btn-danger" href="{{ route('doctor_opd_ipd.list') }}">Resst</a>
                        <button type="button" class="btn btn-info" onclick="exportAppointment()"><i class="fa fa-file-export"></i> Export</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <div class="content d-flex flex-column flex-column-fluid pt-0 pb-0" id="kt_content">
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">OPD
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered scrollable_table_custom" id="">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$app_lists->isEmpty())
                                @foreach($app_lists as $key => $appointment)
                                <tr>
                                    <td>{{ $app_lists->firstItem() + $key }}</td>
                                    <td>{{ $appointment->patientData->pa_name }}</td>
                                    <td>
                                        @if($appointment->ap_status == 'pending')
                                        @php $statusClass = 'btn-primary'; @endphp
                                        @elseif($appointment->ap_status == 'completed')
                                        @php $statusClass = 'btn-success'; @endphp
                                        @else
                                        @php $statusClass = 'btn-danger'; @endphp
                                        @endif
                                        <span class="btn {{ $statusClass }}" id="status_{{ $appointment->ap_id }}" onclick="statusModal('{{ base64_encode($appointment->ap_id) }}')">{{ ucfirst($appointment->ap_status) }}</span>
                                    </td>
                                    <td>
                                        <span id="OPDDetail" data-id="{{ base64_encode($appointment->ap_id) }}" title="View Detail"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                        @if(!$app_lists->isEmpty())
                        {{ $app_lists->withQueryString()->onEachSide(1)->links() }}
                        @endif
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Entry-->
        </div>
        <div class="content d-flex flex-column flex-column-fluid pt-0" id="kt_content">
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">IPD
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-bordered scrollable_table_custom" id="">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!$ipd_lists->isEmpty())
                                @foreach($ipd_lists as $key => $ipd)
                                <tr>
                                    <td>{{ $ipd_lists->firstItem() + $key }}</td>
                                    <td>{{ $ipd->patientData->pa_name }}</td>
                                    <td>
                                        @if($ipd->ipd_status == 'admit')
                                        @php $statusClass = 'btn-primary'; @endphp
                                        @elseif($ipd->ipd_status == 'discharged')
                                        @php $statusClass = 'btn-success'; @endphp
                                        @else
                                        @php $statusClass = 'btn-danger'; @endphp
                                        @endif
                                        <span class="btn {{ $statusClass }}" id="status_{{ $ipd->ipd_id }}" onclick="statusModalIPD('{{ base64_encode($ipd->ipd_id) }}')">{{ ucfirst($ipd->ipd_status) }}</span>
                                    </td>
                                    <td>
                                        <span id="IPDDetail" data-id="{{ base64_encode($ipd->ipd_id) }}" title="View Detail"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                        @if(!$ipd_lists->isEmpty())
                        {{ $ipd_lists->withQueryString()->onEachSide(1)->links() }}
                        @endif
                    </div>
                </div>
            </div>
            <!--end::Entry-->
        </div>
    </div>
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" id="detailView"></div>
</div>
<!-- Start:: OPD Script -->
<script>
    $('body').on('click', '#OPDDetail', function() {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('doctor_opd_ipd.opd.view', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
                $('#fullViewModal').modal('show');
                if (res.response === true) {
                    let data = res.data;
                    $('#detailView').html('');
                    $('#detailView').html(data);
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                console.log(r);
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });
</script>
<!-- End:: OPD Script -->
<!-- Start:: IPD Script -->
<script>
    $('body').on('click', '#IPDDetail', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('doctor_opd_ipd.ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                $('#fullViewModal').modal('show');
                if (res.response === true) {
                    let data = res.data;
                    $('#detailView').html('');
                    $('#detailView').html(data);
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                console.log(r);
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });
</script>
<!-- End:: IPD Script -->
@endsection