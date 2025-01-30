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
                    <div class="col-lg-2 col-md-2 col-sm-3 col-6 form-group">
                        <label for="patient">OPD Status</label>
                        <select class="form-control" name="ap_status" id="ap_status" onchange="changeFee(this.value)">
                            <option value="">Select</option>
                            <option value="pending" {{ ($filterData['ap_status'] == 'pending') ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ ($filterData['ap_status'] == 'completed') ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ ($filterData['ap_status'] == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                            <option value="all" {{ ($filterData['ap_status'] == '') ? 'selected' : '' }}>All</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 col-6 form-group">
                        <label for="">IPD Status</label>
                        <select name="ipd_status" id="ipd_status" class="form-control" onchange="changeStatusVal(this.value)">
                            <option value="">-Select-</option>
                            <option value="admit" {{ ($filterData['ipd_status'] == 'admit') ? 'selected' : '' }}>Admitted</option>
                            <option value="discharged" {{ ($filterData['ipd_status'] == 'discharged') ? 'selected' : '' }}>Discharge</option>
                            <option value="cancelled" {{ ($filterData['ipd_status'] == 'cancelled') ? 'selected' : '' }}>Cancel</option>
                            <option value="all" {{ ($filterData['ipd_status'] == '') ? 'selected' : '' }}>All</option>
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
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap">
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
                                    <span class="btn {{ $statusClass }}" id="status_{{ $appointment->ap_id }}" onclick="OPDStatusModal('{{ base64_encode($appointment->ap_id) }}')">{{ ucfirst($appointment->ap_status) }}</span>
                                </td>
                                <td>
                                    <span id="OPDDetail" data-id="{{ base64_encode($appointment->ap_id) }}" title="View Detail"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                    <span id="OPDPrescriptionDetail" data-id="{{ base64_encode($appointment->ap_id) }}" title="Prescription Detail"><i class="la la-file-prescription icon-3x cursor_pointer"></i></span>
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
        <div class="content d-flex flex-column flex-column-fluid pt-0" id="kt_content">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap">
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
    </div>
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" id="detailView"></div>
</div>
<!-- Start:: OPD MOdal -->
<div class="modal fade" id="OPDStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Appointment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="statusDetail">
                    <div class="form-group">
                        <label for="">Satatus</label>
                        <select name="ap_status_val" id="ap_status_val" class="form-control" onchange="OPDChangeStatusVal(this.value)">
                            <option value="">-Select-</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Comlpleted</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <!-- <span class="btn btn-primary mr-2" id="pendingStatus">Pending</span>
                    <span class="btn btn-success mr-2" id="completedStatus">Completed</span>
                    <span class="btn btn-danger mr-2" id="cancelledStatus">Cancelled</span> -->
                    <div class="form-group pt-4 d-none" id="statusCancelReason">
                        <label for="ap_status_reason">Cancel Reason</label>
                        <textarea class="form-control" name="ap_status_reason" id="ap_status_reason" cols="30" rows="5"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-primary" id="statusButton">Submit</button>
                    </div>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Start:: OPD MOdal -->
<!-- Start:: IPD MOdal -->
<div class="modal fade" id="ipdBillAmountViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Bill Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="ipdBillAmountViewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="operativeNoteViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Operative Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="operativeNoteViewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="prescribeViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Operation Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="prescribeViewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End:: IPD MOdal -->
<!-- Start:: OPD Script -->
<script>
    /* OPD Status Modal Show */
    function OPDStatusModal(ap_id) {
        $('#OPDStatusModal').modal('show');
        $('#statusButton').attr('onclick', 'OPDChangeStatus("' + ap_id.toString() + '")');
        $.ajax({
            url: "{{ route('appointment.view', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(result) {
                if (result.response === true) {
                    let data = result.data;
                    $('#ap_status_reason').val(data.ap_status_reaason);
                    $('#statusCancelReason').addClass('d-none');
                    $('#ap_status_val').val(data.ap_status);
                    if (data.ap_status == 'cancelled') {
                        $('#statusCancelReason').removeClass('d-none');
                    }
                }
            },
            err: function(error) {
                sweetAlertError(error.message, 3000);
            }
        });
    }
    /* OPH Status Popup Val Change */
    function OPDChangeStatusVal(ap_status_val) {
        if (ap_status_val == 'cancelled') {
            $('#statusCancelReason').removeClass('d-none');
        } else {
            $('#statusCancelReason').addClass('d-none');
        }
    }
    /* OPD Status Popup Submit */
    function OPDChangeStatus(ap_id) {
        let status = $('#ap_status_val').val();
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
                        addText = 'Pending';
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
                    $('#OPDStatusModal').modal('hide');
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
    /* OPD Detail Show */
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
    /* OPD Prescription Show */
    $('body').on('click', '#OPDPrescriptionDetail', function() {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('doctor_opd_ipd.opd.prescription.show', '') }}" + "/" + ap_id,
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

    /* Show Bill Amount Modal */
    $('body').on('click', '#ipdBillAmountView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let view = '<div class="row"> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_name">Patient Name</label> \
                            <input type="text" class="form-control" name="patient_name" id="patient_name" value="' + data.patient_name + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="surgery_type">Type of Surgery</label> \
                            <input type="text" class="form-control" name="surgery_type" id="surgery_type" value="' + data.ipd_surgery_text + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="ipd_bill_amount_update">Bill Amount</label> \
                            <input type="text" class="form-control" name="ipd_bill_amount_update" id="ipd_bill_amount_update" value="' + data.ipd_bill_amount + '" /> \
                        </div> \
                        <div class="col-12 form-group"> \
                            <button class="btn btn-primary" id="bill_amount_update_btn" onclick="updateBillAmount(' + atob(ipd_id) + ')">Update</button> \
                        </div> \
                    </div>';

                    $('#ipdBillAmountViewDetail').html(view);
                    $('#ipdBillAmountViewModal').modal('show');
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
    /* Update Bill Amount */
    function updateBillAmount(ipd_id) {
        let ipd_bill_amount = $('#ipd_bill_amount_update').val();
        $.ajax({
            url: "{{ route('ipd.bill_amount.update', '') }}" + '/' + btoa(ipd_id) + '?ipd_bill_amount=' + ipd_bill_amount,
            method: "get",
            success: function(res) {
                if (res.response === true) {
                    $('#billAmountShow_' + ipd_id).text(ipd_bill_amount);
                    $('#ipdBillAmountViewModal').modal('hide');
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

    /* Operative Note Show */
    $('body').on('click', '#operativeNoteView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.operative_note.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let view = '<div class="row"> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_name">Patient Name</label> \
                            <input type="text" class="form-control" name="patient_name" id="patient_name" value="' + data.patient_name + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_age">Patient Age</label> \
                            <input type="text" class="form-control" name="patient_age" id="patient_age" value="' + data.patient_age + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="surgery_type">Type of Surgery</label> \
                            <input type="text" class="form-control" name="surgery_type" id="surgery_type" value="' + data.ipd_surgery_text + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="ion_date">Print Date <span class="text-danger">*</span></label> \
                            <input type="date" class="form-control" name="ion_date" id="ion_date" value="' + data.ion_date + '" /> \
                            <span class="text-danger" id="ion_dateErr"></span> \
                        </div> \
                        <div class="col-12 form-group"> \
                            <label for="ion_note">Operative Note <span class="text-danger">*</span></label> \
                            <textarea class="form-control" name="ion_note" id="ion_note" rows="15">' + data.ion_note + '</textarea> \
                            <span class="text-danger" id="ion_noteErr"></span> \
                        </div> \
                        <div class="col-12 form-group"> \
                            <button class="btn btn-primary" id="operative_note_update_btn" onclick="updateOperativeNote(' + atob(ipd_id) + ')">Update</button> \
                            <button class="btn btn-info" id="operativeNotPrint" data-id="' + btoa(data.ipd_id) + '">Print <i class="flaticon flaticon2-print cursor_pointer"></i></button> \
                        </div> \
                    </div>';

                    $('#operativeNoteViewDetail').html(view);
                    $('#operativeNoteViewModal').modal('show');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Update Operative Note */
    function updateOperativeNote(ipd_id) {
        let ion_date = $('#ion_date').val();
        let ion_note = $('#ion_note').val();
        $.ajax({
            url: "{{ route('ipd.operative_note.update', '') }}" + '/' + btoa(ipd_id) + '?ion_date=' + ion_date + '&ion_note=' + ion_note,
            method: "get",
            success: function(res) {
                if (res.response === true) {
                    sweetAlertSuccess(res.message, 3000);
                    //$('#operativeNoteViewModal').modal('hide');
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

    /* Prescription Show */
    $('body').on('click', '#prescribeView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.prescription.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let medicineList = res.data.medicineList;
                    let data = res.data.data;
                    let ipdMedicine = data.ipd_operation_medicine;

                    let list = '';

                    if (medicineList.length > 0) {
                        for (let i = 0; i < medicineList.length; i++) {
                            let medicineVal = 0;
                            if (ipdMedicine != null) {
                                ipdMedicine.map(function(val) {
                                    if (val.medicine_id == medicineList[i].om_id) {
                                        medicineVal = val.medicine_val;
                                    }
                                });
                            }
                            // list += '<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12"> \
                            //     <label for="medicine_' + medicineList[i].om_id + '">' + medicineList[i].om_name + ' (' + medicineList[i].om_company_name + ')</label> \
                            //     <input type="number" class="form-control" name="medicine[]" id="medicine_' + medicineList[i].om_id + '" value="' + medicineVal + '"  /> \
                            // </div>';
                            list += '<table> \
                                <tr> \
                                <td for="medicine_' + medicineList[i].om_id + '">' + medicineList[i].om_name + ' (' + medicineList[i].om_company_name + ')</td> \
                                <td> \
                                <input type="number" class="form-control" name="medicine[]" id="medicine_' + medicineList[i].om_id + '" value="' + medicineVal + '"  /> \
                                </td> \
                                </tr> \
                            </table>';
                        }
                    }

                    let view = '<div class="row"> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_name">Patient Name</label> \
                            <input type="text" class="form-control" name="patient_name" id="patient_name" value="' + data.patient_name + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_age">Patient Age</label> \
                            <input type="text" class="form-control" name="patient_age" id="patient_age" value="' + data.patient_age + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="ipd_operation_medicine_date">Print Date <span class="text-danger">*</span></label> \
                            <input type="date" class="form-control" name="ipd_operation_medicine_date" id="ipd_operation_medicine_date" value="' + data.ipd_operation_medicine_date + '" /> \
                            <span class="text-primary cursor_pointer" onclick="ResetOperationMedicineDate()">Reset</span> \
                        </div> \
                        <hr> \
                        <div class="col-12 form-group"> \
                            <strong class="">Medicine</strong> \
                        </div> \
                        <div class="col-12"> \
                            <div class="row">' + list + '</div> \
                        </div> \
                        <div class="col-12 form-group pt-4"> \
                            <button class="btn btn-primary" id="operative_note_update_btn" onclick="updateOperationMedicine(' + atob(ipd_id) + ')">Update</button> \
                            <button class="btn btn-info" id="operationMedicinePrint" data-id="' + btoa(data.ipd_id) + '">Print <i class="flaticon flaticon2-print cursor_pointer"></i></button> \
                        </div> \
                    </div>';

                    $('#prescribeViewDetail').html(view);
                    $('#prescribeViewModal').modal('show');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Operative not print */
    $('body').on('click', '#operativeNotPrint', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.operative_note.print', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Operation Medicine print */
    $('body').on('click', '#operationMedicinePrint', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.operation_medicine.print', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Reset Operation Medicine Date */
    function ResetOperationMedicineDate() {
        $('#ipd_operation_medicine_date').val('');
    }

    /* Operation Medicine Update */
    function updateOperationMedicine(ipd_id) {
        let ipd_operation_medicine_date = $('#ipd_operation_medicine_date').val();
        let medicine_arr = [];
        $('input[name^=medicine]').map(function(idx, elem) {
            medicine_arr.push($(elem).val());
        }).get();
        $.ajax({
            url: "{{ route('ipd.prescription.update', '') }}" + '/' + btoa(ipd_id) + '?ipd_operation_medicine_date=' + ipd_operation_medicine_date + '&medicine_arr=' + btoa(medicine_arr),
            method: "get",
            success: function(res) {
                if (res.response === true) {
                    sweetAlertSuccess(res.message, 3000);
                    //$('#operativeNoteViewModal').modal('hide');
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

    /* IPD Print */
    $('body').on('click', '#IPDPrint', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.bill.print', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Print Data */
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
<!-- End:: IPD Script -->
@endsection