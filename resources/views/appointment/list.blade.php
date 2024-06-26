@extends('layout.master');
@section('title', 'Appointment - List')
@section('breadcrumb-module', 'Appointment')
@section('page-content')
<!--begin::Row-->
<div class="row">
    <div class="col-lg-12 col-xxl-12">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-custom gutter-b p-5">
                                <form action="{{ route('appointment.list') }}">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="search_text">Search Appointment ID</label>
                                            <input type="text" class="form-control" placeholder="Search Appointment ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="patient">Patient</label>
                                            <select name="patient" id="patient" class="form-control">
                                                <option value="">Select</option>
                                                @if(!empty($patientList))
                                                @foreach($patientList as $plist)
                                                <option value="{{ $plist->pa_id }}" {{ ($plist->pa_id == $searchData['patient']) ? 'selected' : '' }}>{{ $plist->pa_name }} - {{ $plist->pa_id }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">Appointment Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="appointment_date_range" class="form-control" readonly="readonly" placeholder="Select date range" value="{{ $searchData['appointment_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="patient">Doctor</label>
                                            <select name="doctor" id="doctor" class="form-control">
                                                <option value="">Select</option>
                                                @if(!empty($doctors))
                                                @foreach($doctors as $doctor)
                                                <option value="{{ $doctor['user_id'] }}" {{ ($doctor['user_id'] == $searchData['doctor']) ? 'selected' : '' }}>{{ $doctor['person_name'] }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="patient">Case Type</label>
                                            <select class="form-control" name="case_type" id="case_type" onchange="changeFee(this.value)">
                                                <option value="">Select</option>
                                                @if(!empty($visitingFees))
                                                @foreach($visitingFees as $fee)
                                                <option value="{{ $fee->vf_case_type }}" {{ ($fee->vf_case_type == $searchData['case_type']) ? 'selected' : '' }}>{{ ucfirst($fee->vf_case_type) }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('appointment.list') }}">Resst</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b">
                                <div class="card-header flex-wrap py-3">
                                    <div class="card-title">
                                        <h3 class="card-label">List
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered scrollable_table_custom" id="">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Appointment ID</th>
                                                <th>Date</th>
                                                <th>Case Type</th>
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <th>Doctor</th>
                                                <th>Has Madiclaim</th>
                                                <th>Status</th>
                                                <th>Prescribe</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $appointment)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $appointment->ap_id }}</td>
                                                <td>{{ $appointment->ap_date }}</td>
                                                <td>{{ $appointment->ap_case_type }}</td>
                                                <td>{{ $appointment->pa_id }}</td>
                                                <td>{{ $appointment->patientData->pa_name }}</td>
                                                <td>{{ $appointment->doctorData->person_name }}</td>
                                                <td>{{ ($appointment->ap_pament_mode == 'mediclaim') ? 'Yes' : 'No' }}</td>
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
                                                    <span class="btn btn-danger" onclick="prescribeShow('{{ base64_encode($appointment->ap_id) }}')">Prescribe</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('appointment.edit', base64_encode($appointment->ap_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                    <span id="fullView" data-id="{{ base64_encode($appointment->ap_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4">Record not found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <!--end: Datatable-->
                                    @if(!$list->isEmpty())
                                    {{ $list->withQueryString()->onEachSide(1)->links() }}
                                    @endif
                                </div>
                            </div>

                            <!--end::Card-->
                        </div>
                    </div>
                </div>
                <!--end::Container-->
            </div>
            <!--end::Entry-->
        </div>
    </div>
</div>
<!--end::Row-->
<div class="modal fade" id="fullViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Appointment Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="viewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Appointment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="statusDetail">
                    <span class="btn btn-primary mr-2" id="pendingStatus">Pending</span>
                    <span class="btn btn-success mr-2" id="completedStatus">Completed</span>
                    <span class="btn btn-danger mr-2" id="cancelledStatus">Cancelled</span>
                    <div class="form-group pt-4">
                        <label for="ap_status_reason">Cancel Reason</label>
                        <textarea class="form-control" name="ap_status_reason" id="ap_status_reason" cols="30" rows="5"></textarea>
                    </div>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('click', '#fullView', function(event) {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('appointment.view', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
                $('#fullViewModal').modal('show');
                if (res.response === true) {
                    let data = res.data;
                    let photo = '';
                    if (data.photo != '') {
                        photo = '<img src="' + data.photo + '" class="img-fluid" />';
                    }
                    let view = '<tr> \
                        <th>Patient Name</th> \
                        <td>' + $.trim(data.patient_name) + '</td> \
                        <th>Height</th> \
                        <td>' + $.trim(data.ap_height) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Weight</th> \
                        <td>' + $.trim(data.ap_weight) + '</td> \
                        <th>BP</th> \
                        <td>' + $.trim(data.ap_bp) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Appointment For Doctor</th> \
                        <td>' + $.trim(data.doctor_name) + '</td> \
                        <th>Appointment Date</th> \
                        <td>' + $.trim(data.ap_date) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Apointment booked via</th> \
                        <td>' + $.trim(data.ap_book_via) + '</td> \
                        <th>Case Type</th> \
                        <td>' + $.trim(data.ap_case_type) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Fees</th> \
                        <td>' + $.trim(data.ap_charge) + '</td> \
                    </tr>';

                    $('#viewDetail').html(view);
                    $('#fullViewModal').modal('show');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    })

    function statusModal(ap_id) {
        $('#statusModal').modal('show');
        $('#pendingStatus').attr('onclick', 'changeStatus("' + ap_id.toString() + '", "pending")');
        $('#completedStatus').attr('onclick', 'changeStatus("' + ap_id.toString() + '", "completed")');
        $('#cancelledStatus').attr('onclick', 'changeStatus("' + ap_id.toString() + '", "cancelled")');
        $.ajax({
            url: "{{ route('appointment.view', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(result) {
                if (result.response === true) {
                    $('#ap_status_reason').val(result.data.ap_status_reaason);
                }
            },
            err: function(error) {
                sweetAlertError(error.message, 3000);
            }
        });
    }

    function changeStatus(ap_id, status) {
        let ap_status_reason = $('#ap_status_reason').val();
        let stringVal = btoa(ap_id + '[]' + status + '[]' + ap_status_reason);
        $.ajax({
            url: "{{ route('appointment.status', '') }}" + "/" + stringVal,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let removeClass = 'text-primary text-success text-danger';
                    let addClass = '';
                    let addText = '';
                    if (status == 'pending') {
                        addClass = 'bg-primary';
                        addText = 'Primary';
                    } else if (status == 'completed') {
                        addClass = 'bg-success';
                        addText = 'Completed';
                    } else {
                        addClass = 'bg-danger';
                        addText = 'Cancelled';
                    }
                    $('#status_' + atob(ap_id)).removeClass(removeClass);
                    $('#status_' + atob(ap_id)).addClass(addClass);
                    $('#status_' + atob(ap_id)).text(addText);
                    sweetAlertSuccess(res.message, 3000);
                    $('#statusModal').modal('hide');
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

    function prescribeShow(ap_id) {
        window.location.href = "{{ route('appointment.prescribe', '') }}" + "/" + ap_id;
    }
</script>
@endsection