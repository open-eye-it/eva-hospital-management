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
                                            <label for="search_text">Search IPD ID</label>
                                            <input type="text" class="form-control" placeholder="Search IPD ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('ipd.list') }}">Resst</a>
                                            <button type="button" class="btn btn-info" onclick="exportAppointment()"><i class="fa fa-file-export"></i> Export</button>
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
                                                <th>IPD ID</th>
                                                <th>Admit Date</th>
                                                <th>Room No</th>
                                                <th>Doctor</th>
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <th>DOB</th>
                                                <th>Age</th>
                                                <th>Contact No</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $ipd)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $ipd->ipd_id }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->ipd_admit_date)) }}</td>
                                                <td>{{ $ipd->roomData->rm_building.'-'.$ipd->roomData->rm_floor.'-'.$ipd->roomData->rm_ward.'-'.$ipd->roomData->rm_no }}</td>
                                                <td>{{ $ipd->doctorData->person_name }}</td>
                                                <td>{{ $ipd->pa_id }}</td>
                                                <td>{{ $ipd->patientData->pa_name }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->patientData->pa_dob)) }}</td>
                                                <td>{{ $ipd->patientData->pa_age }}</td>
                                                <td>{{ $ipd->patientData->pa_contact_no }}</td>
                                                <td>
                                                    @if($ipd->ipd_status == 'admit')
                                                    @php $statusClass = 'btn-primary'; @endphp
                                                    @elseif($ipd->ipd_status == 'discharged')
                                                    @php $statusClass = 'btn-success'; @endphp
                                                    @else
                                                    @php $statusClass = 'btn-danger'; @endphp
                                                    @endif
                                                    <span class="btn {{ $statusClass }}" id="status_{{ $ipd->ipd_id }}" onclick="statusModal('{{ base64_encode($ipd->ipd_id) }}')">{{ ucfirst($ipd->ipd_status) }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('ipd.edit', base64_encode($ipd->ipd_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                    <span id="fullView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span>
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
                <h5 class="modal-title" id="exampleModalLabel">IPD Detail</h5>
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
                <h5 class="modal-title" id="exampleModalLabel">IPD Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="statusDetail">
                    <span class="btn btn-primary mr-2" id="admitStatus">Admit</span>
                    <span class="btn btn-success mr-2" id="dischargedStatus">Discharged</span>
                    <span class="btn btn-danger mr-2" id="cancelledStatus">Cancelled</span>
                    <div class="form-group pt-4">
                        <label for="ipd_cancel_reason">Cancel Reason</label>
                        <textarea class="form-control" name="ipd_cancel_reason" id="ipd_cancel_reason" cols="30" rows="5"></textarea>
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
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                $('#fullViewModal').modal('show');
                if (res.response === true) {
                    let data = res.data;
                    let photo = '';
                    if (data.photo != '') {
                        photo = '<img src="' + data.photo + '" class="img-fluid" />';
                    }
                    let view = '<tr> \
                        <th>IPD ID</th> \
                        <td>' + $.trim(data.ipd_id) + '</td> \
                        <th>Admit Date</th> \
                        <td>' + $.trim(data.ipd_admit_date) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Room No</th> \
                        <td>' + $.trim(data.room_no) + '</td> \
                        <th>Doctor</th> \
                        <td>' + $.trim(data.doctor_name) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Patient ID</th> \
                        <td>' + $.trim(data.pa_id) + '</td> \
                        <th>Patient Name</th> \
                        <td>' + $.trim(data.patient_name) + '</td> \
                    </tr> \
                    <tr> \
                        <th>DOB</th> \
                        <td>' + $.trim(data.patient_dob) + '</td> \
                        <th>Age</th> \
                        <td>' + $.trim(data.patient_age) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Contact No</th> \
                        <td>' + $.trim(data.patient_contact_no) + '</td> \
                        <th>Date of Surgery</th> \
                        <td>' + $.trim(data.ipd_surgery_date) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Type of Surgery</th> \
                        <td>' + $.trim(data.ipd_surgery_text) + '</td> \
                        <th>Bill Amount</th> \
                        <td>' + $.trim(data.ipd_bill_amount) + '</td> \
                    </tr> \
                    <tr> \
                        <th>ReceivedAmount</th> \
                        <td>' + $.trim(data.ipd_received_amount) + '</td> \
                    </tr>';

                    $('#viewDetail').html(view);
                    $('#fullViewModal').modal('show');
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
    })

    function statusModal(ipd_id) {
        $('#statusModal').modal('show');
        $('#admitStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "admit")');
        $('#dischargedStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "discharged")');
        $('#cancelledStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "cancelled")');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(result) {
                if (result.response === true) {
                    $('#ipd_cancel_reason').val(result.data.ipd_cancel_reason);
                }
            },
            err: function(error) {
                sweetAlertError(error.message, 3000);
            }
        });
    }

    function changeStatus(ipd_id, status) {
        let ipd_cancel_reason = $('#ipd_cancel_reason').val();
        let stringVal = btoa(ipd_id + '[]' + status + '[]' + ipd_cancel_reason);
        $.ajax({
            url: "{{ route('ipd.status', '') }}" + "/" + stringVal,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let removeClass = 'text-primary text-success text-danger';
                    let addClass = '';
                    let addText = '';
                    if (status == 'admit') {
                        addClass = 'bg-primary';
                        addText = 'Admit';
                    } else if (status == 'discharged') {
                        addClass = 'bg-success';
                        addText = 'Discharged';
                    } else {
                        addClass = 'bg-danger';
                        addText = 'Cancelled';
                    }
                    $('#status_' + atob(ipd_id)).removeClass(removeClass);
                    $('#status_' + atob(ipd_id)).addClass(addClass);
                    $('#status_' + atob(ipd_id)).text(addText);
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

    /* Export Appointment */
    function exportAppointment() {
        let search_text = $('#search_text').val();
        let patient = $('#patient').val();
        let appointment_date_range = $('#appointment_date_range_filter').val();
        let doctor = $('#doctor').val();
        let case_type = $('#case_type').val();
        let query = '?search_text=' + search_text + '&patient=' + patient + '&appointment_date_range=' + appointment_date_range + '&doctor=' + doctor + '&case_type=' + case_type;
        window.location.href = "{{ route('appointment.export') }}" + query;
    }

    $('body').on('click', '#billView', function(event) {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('appointment.bill_print', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                printData(res);
            },
            error: function(r) {
                console.log(r);
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
        //openPrintDialogue();
    });

    function printData(data) {
        $('<iframe>', {
                name: 'myiframe',
                class: 'printFrame'
            })
            .appendTo('body')
            .contents().find('body')
            .append(data);

        window.frames['myiframe'].focus();
        window.frames['myiframe'].print();

        setTimeout(() => {
            $(".printFrame").remove();
        }, 1000);
    };
</script>
@endsection