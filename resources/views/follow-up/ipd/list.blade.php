@extends('layout.master');
@section('title', 'Follow Up - IPD')
@section('breadcrumb-module', 'Follow Up - IPD')
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
                                <form action="{{ route('follow-up.ipd.list') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="search_text">IPD ID</label>
                                            <input type="text" class="form-control" placeholder="IPD ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">Follow Up Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="follow_up_date_range" id="follow_up_date_range" class="form-control" placeholder="Select date range" value="{{ $searchData['follow_up_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('follow-up.ipd.list') }}">Reset</a>
                                            <button type="button" class="btn btn-info" onclick="exportIPD()"><i class="fa fa-file-export"></i> Export</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b">
                                <div class="card-header flex-wrap py-2">
                                    <div class="card-title">
                                        <h3 class="card-label">List
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered table-hover" id="followUpIpdListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>IPD ID</th>
                                                <th>Admit Date</th>
                                                <!-- <th>Room No</th>
                                                <th>Doctor</th> -->
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <!-- <th>DOB</th> -->
                                                <th>Age</th>
                                                <th>Contact No</th>
                                                <th>Date of Surgery</th>
                                                <th>Type of Surgery</th>
                                                <th>Follow Up Date</th>
                                                <!-- <th>Bill Amount</th>
                                                <th>Received Amount</th> -->
                                                @can('follow-up-ipd-opd-history')
                                                <th>OPD</th>
                                                @endcan
                                                @can('follow-up-ipd-ipd-history')
                                                <th>IPD</th>
                                                @endcan
                                                <!-- <th>Actions</th> -->
                                                @can('follow-up-ipd-note')
                                                <th>Notes</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $ipd)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $ipd->ipd_id }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->ipd_admit_date)) }}</td>
                                                <!-- <td>{{ $ipd->roomData->rm_building.'-'.$ipd->roomData->rm_floor.'-'.$ipd->roomData->rm_ward.'-'.$ipd->roomData->rm_no }}</td>
                                                <td>{{ $ipd->doctorData->person_name }}</td> -->
                                                <td>{{ $ipd->pa_id }}</td>
                                                <td>{{ $ipd->patientData->pa_name }}</td>
                                                <!-- <td>{{ date('d M Y', strtotime($ipd->patientData->pa_dob)) }}</td> -->
                                                <td>{{ $ipd->patientData->pa_age }}</td>
                                                <td>{{ $ipd->patientData->pa_contact_no }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->ipd_surgery_date)) }}</td>
                                                <td>{{ $ipd->ipd_surgery_text }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->ipd_follow_up_date)) }}</td>
                                                <!-- <td id="billAmountShow_{{ $ipd->ipd_id }}">{{ $ipd->ipd_bill_amount }}</td>
                                                <td>{{ $ipd->ipd_received_amount }}</td> -->
                                                @can('follow-up-ipd-opd-history')
                                                <td>
                                                    <span id="opdHistoryView" data-id="{{ base64_encode($ipd->pa_id) }}" title="OPD History"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                </td>
                                                @endcan
                                                @can('follow-up-ipd-ipd-history')
                                                <td>
                                                    <span id="ipdHistoryView" data-id="{{ base64_encode($ipd->pa_id) }}" title="IPD History"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                </td>
                                                @endcan
                                                <!-- <td>
                                                    <span id="fullView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                </td> -->
                                                @can('follow-up-ipd-note')
                                                <td>
                                                    <span id="IPDNote" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Note"><i class="flaticon flaticon-file-1 icon-3x cursor_pointer"></i></span>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="16">Record not found</td>
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
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="apac_desc">Follow Up Date</label>
                            <div class="input-group date">
                                <input type="text" class="form-control" placeholder="IPD Date" name="ipd_follow_up_date" id="ipd_follow_up_date" value="{{ date('Y-m-d') }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="apac_qty">Notes </label>
                            <textarea class="form-control" name="ipd_follow_up_note" id="ipd_follow_up_note" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="addNote" class="btn btn-primary" id="ipd_note_submit">Submit</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
                <table class="table" id="viewDetail">

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
                <table class="table" id="statusDetail">
                    <div class="form-group">
                        <label for="">Satatus</label>
                        <select name="ip_status_val" id="ip_status_val" class="form-control" onchange="changeStatusVal(this.value)">
                            <option value="">-Select-</option>
                            <option value="admit">Admit</option>
                            <option value="discharged">Discharge</option>
                            <option value="cancelled">Cancel</option>
                        </select>
                    </div>
                    <!-- <span class="btn btn-primary mr-2" id="admitStatus">Admit</span>
                    <hr /> -->
                    <div class="d-none" id="dischargeStatusVal">
                        <div class="form-group pt-4">
                            <label for="ipd_discharge_date">Discharge Date</label>
                            <input type="date" class="form-control" name="ipd_discharge_date" id="ipd_discharge_date" />
                            <span class="text-primary cursor_pointer" onclick="ResetDischargeDate()">Reset</span>
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_discharge_date">Follow Up Date</label>
                            <input type="date" class="form-control" name="ipd_follow_up_date" id="ipd_follow_up_date" />
                            <span class="text-primary cursor_pointer" onclick="ResetFollowUpDate()">Reset</span>
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_diagnosis">Diagnosis</label>
                            <input type="text" class="form-control" name="ipd_diagnosis" id="ipd_diagnosis" />
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_investigations">Invastigations</label>
                            <input type="text" class="form-control" name="ipd_investigations" id="ipd_investigations" />
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_treatment_given">Treatment Given</label>
                            <textarea class="form-control" name="ipd_treatment_given" id="ipd_treatment_given" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_treatment_discharge">Treatment On Discharge</label>
                            <textarea class="form-control" name="ipd_treatment_discharge" id="ipd_treatment_discharge" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <!-- <span class="btn btn-success mr-2" id="dischargedStatus">Discharge</span>
                    <hr /> -->
                    <div class="d-none" id="cancelStatusVal">
                        <div class="form-group pt-4">
                            <label for="ipd_cancel_reason">Cancel Reason</label>
                            <textarea class="form-control" name="ipd_cancel_reason" id="ipd_cancel_reason" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <!-- <span class="btn btn-danger mr-2" id="cancelledStatus">Cancel</span> -->
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
<div class="modal fade" id="billAmountViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Bill Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="billAmountViewDetail">

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
<div class="modal fade" id="opdHistoryViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl popup-90" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">OPD Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4>Total Fees: <span id="opd_total_fees"></span></h4>
                <table class="table table-bordered" id="followUpOpdppopup">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Appointment ID</th>
                            <th>Date</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>Contact No</th>
                            <th>Case Type</th>
                            <th>Is FOC</th>
                            <th>Fee</th>
                            <th>Additional Charge</th>
                            <th>Follow Up Date</th>
                            <th>Decided Date of Surgery</th>
                        </tr>
                    </thead>
                    <tbody id="opdHistoryViewDetail"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ipdHistoryViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl popup-90" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <!-- <h4>Total Fees: <span id="ipd_total_fees"></span></h4> -->
                <h4>Bill Amount: <span id="ipd_total_bill"></span></h4>
                <h4>Received Amount: <span id="ipd_total_received"></span></h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IPD ID</th>
                            <th>Admit Date</th>
                            <th>Room No</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>AGE</th>
                            <th>Contact No</th>
                            <th>Surgery Type</th>
                            <th>Surgery Date</th>
                            <th>Doctor</th>
                            <th>Discharge Date</th>
                            <th>Bill Amount</th>
                            <th>Received Amount</th>
                            <th>Operative Note</th>
                            <th>Discharge Summary</th>
                        </tr>
                    </thead>
                    <tbody id="ipdHistoryViewDetail"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // setTimeout(() => {
    //     var table = $('#followUpIpdListTable').DataTable();
    //     table.destroy();
    //     $('#followUpIpdListTable').DataTable({
    //         autoWidth: true,
    //         searching: false,
    //         paging: false,
    //         info: false
    //     });
    // }, 1000);

    /* Export IPD Details */
    function exportIPD() {
        let search_text = $('#search_text').val();
        let admit_date_range = $('#admit_date_range').val();
        let query = '?search_text=' + search_text + '&admit_date_range=' + admit_date_range;
        window.location.href = "{{ route('ipd.export') }}" + query;
    }

    $('body').on('click', '#fullView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let photo = '';
                    if (data.photo != '') {
                        photo = '<img src="' + data.photo + '" class="img-fluid" />';
                    }
                    let mediclaim = 'No';
                    let foc = 'No';
                    if (data.ipd_mediclaim == 'yes') {
                        mediclaim = 'Yes';
                    }
                    if (data.ipd_is_foc == 'yes') {
                        foc = 'Yes';
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
                        <th>Received Amount</th> \
                        <td>' + $.trim(data.ipd_received_amount) + '</td> \
                        <th>Mediclaim</th> \
                        <td>' + $.trim(mediclaim) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Is FOC</th> \
                        <td>' + $.trim(foc) + '</td> \
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

    function statusModal(ipd_id) {
        $('#statusModal').modal('show');
        // $('#admitStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "admit")');
        // $('#dischargedStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "discharged")');
        // $('#cancelledStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "cancelled")');
        $('#statusButton').attr('onclick', 'changeStatus("' + ipd_id.toString() + '")');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(result) {
                console.log(result);
                if (result.response === true) {
                    let data = result.data;
                    $('#ip_status_val').val(data.ipd_status);
                    if (data.ipd_status == 'discharged') {
                        $('#dischargeStatusVal').removeClass('d-none');
                        $('#cancelStatusVal').addClass('d-none');
                    } else if (data.ipd_status == 'cancelled') {
                        $('#dischargeStatusVal').addClass('d-none');
                        $('#cancelStatusVal').removeClass('d-none');
                    } else {
                        $('#dischargeStatusVal').addClass('d-none');
                        $('#cancelStatusVal').addClass('d-none');
                    }
                    $('#ipd_discharge_date').val(data.ipd_discharge_date);
                    $('#ipd_diagnosis').val(data.ipd_diagnosis);
                    $('#ipd_investigations').val(data.ipd_investigations);
                    $('#ipd_treatment_given').val(data.ipd_treatment_given);
                    $('#ipd_treatment_discharge').val(data.ipd_treatment_discharge);
                    $('#ipd_cancel_reason').val(data.ipd_cancel_reason);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    function changeStatusVal(ip_status_val) {
        if (ip_status_val == 'cancelled') {
            $('#dischargeStatusVal').addClass('d-none');
            $('#cancelStatusVal').removeClass('d-none');
        } else if (ip_status_val == 'discharged') {
            $('#dischargeStatusVal').removeClass('d-none');
            $('#cancelStatusVal').addClass('d-none');
        } else {
            $('#dischargeStatusVal').addClass('d-none');
            $('#cancelStatusVal').addClass('d-none');
        }
    }

    function ResetDischargeDate() {
        $('#ipd_discharge_date').val('');
    }

    function ResetFollowUpDate() {
        $('#ipd_follow_up_date').val('');
    }

    function changeStatus(ipd_id) {
        let ip_status_val = $('#ip_status_val').val();
        let ipd_discharge_date = $('#ipd_discharge_date').val();
        let ipd_follow_up_date = $('#ipd_follow_up_date').val();
        let ipd_diagnosis = $('#ipd_diagnosis').val();
        let ipd_investigations = $('#ipd_investigations').val();
        let ipd_treatment_given = $('#ipd_treatment_given').val();
        let ipd_treatment_discharge = $('#ipd_treatment_discharge').val();
        let ipd_cancel_reason = $('#ipd_cancel_reason').val();
        let stringVal = btoa(ipd_id + '[]' + ip_status_val + '[]' + ipd_cancel_reason + '[]' + ipd_discharge_date + '[]' + ipd_diagnosis + '[]' + ipd_investigations + '[]' + ipd_treatment_given + '[]' + ipd_treatment_discharge + '[]' + ipd_follow_up_date);
        $.ajax({
            url: "{{ route('ipd.status', '') }}" + "/" + stringVal,
            method: "GET",
            success: function(res) {
                console.log(status);
                if (res.response === true) {
                    let removeClass = 'bg-primary bg-success bg-danger';
                    let addClass = '';
                    let addText = '';
                    if (ip_status_val == 'admit') {
                        addClass = 'bg-primary';
                        addText = 'Admit';
                    } else if (ip_status_val == 'discharged') {
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

    /* Show Bill Amount Modal */
    $('body').on('click', '#billAmountView', function(event) {
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

                    $('#billAmountViewDetail').html(view);
                    $('#billAmountViewModal').modal('show');
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
                    $('#billAmountViewModal').modal('hide');
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
    })

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
                            list += '<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12"> \
                                <label for="medicine_' + medicineList[i].om_id + '">' + medicineList[i].om_name + ' (' + medicineList[i].om_company_name + ')</label> \
                                <input type="number" class="form-control" name="medicine[]" id="medicine_' + medicineList[i].om_id + '" value="' + medicineVal + '"  /> \
                            </div>';
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
                        <div class="col-12 form-group"> \
                            <button class="btn btn-primary" id="operative_note_update_btn" onclick="updateOperationMedicine(' + atob(ipd_id) + ')">Update</button> \
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
    })

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
                console.log(res);
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

    /* OPD History Show */
    $('body').on('click', '#opdHistoryView', function(event) {
        let pa_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.opd_history', '') }}" + "/" + pa_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                if (res.response === true) {
                    // var table = $('#followUpOpdppopup').DataTable();
                    // table.destroy();
                    // $('#followUpOpdppopup').DataTable({
                    //     autoWidth: true,
                    //     searching: false,
                    //     paging: false,
                    //     info: false
                    // });

                    let data = res.data.list;
                    let total_fees = res.data.total_fees;
                    let total_additional_fees = res.data.total_additional_fees;
                    $('#opd_total_fees').text(total_fees + total_additional_fees);
                    $('#opdHistoryViewDetail').html(data);
                    $('#opdHistoryViewModal').modal('show');
                    //$('.dataTables_wrapper').DataTable().columns.adjust().draw();
                    //$('#followUpOpdppopup').DataTable({colReorder: true});

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

    /* IPD History Show */
    $('body').on('click', '#ipdHistoryView', function(event) {
        let pa_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.ipd_history', '') }}" + "/" + pa_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    // let data = res.data.list;
                    // let total_fees = res.data.total_fees;
                    // let total_additional_fees = res.data.total_additional_fees;
                    // $('#ipd_total_fees').text(total_fees + total_additional_fees);
                    let data = res.data.list;
                    let total_bill = res.data.total_bill;
                    let total_received = res.data.total_received;
                    $('#ipd_total_bill').text(total_bill);
                    $('#ipd_total_received').text(total_received);
                    $('#ipdHistoryViewDetail').html(data);
                    $('#ipdHistoryViewModal').modal('show');
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

    /* OPD Note Show */
    $('body').on('click', '#IPDNote', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                if (res.response === true) {
                    let data = res.data;
                    $('#ipd_follow_up_date').val(data.ipd_follow_up_date);
                    $('#ipd_follow_up_note').val(data.ipd_follow_up_note);
                    $('#addNote').attr('onclick', "IPDNoteSumit('" + ipd_id + "')");
                    $('#noteModal').modal('show');
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
    /* OPD Note Submit */
    function IPDNoteSumit(ipd_id) {
        let ipd_follow_up_date = $('#ipd_follow_up_date').val();
        let ipd_follow_up_note = $('#ipd_follow_up_note').val();
        let query = 'ipd_follow_up_date=' + ipd_follow_up_date + '&ipd_follow_up_note=' + ipd_follow_up_note;
        $('#addNote').addClass('spinner spinner-white spinner-right');
        $('#addNote').attr('disabled', true);
        $.ajax({
            url: "{{ route('ipd.note.update', '') }}" + "/" + ipd_id + "?" + query,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    $('#ipd_follow_up_date').val('');
                    $('#ipd_follow_up_note').val('');
                    $('#addNote').removeAttr('onclick');
                    $('#noteModal').modal('hide');
                    sweetAlertSuccess(res.message, 3000, '');
                    //window.location.reload();
                } else {
                    sweetAlertError(res.message, 3000);
                }
                $('#addNote').removeClass('spinner spinner-white spinner-right');
                $('#addNote').attr('disabled', false);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
                $('#addNote').removeClass('spinner spinner-white spinner-right');
                $('#addNote').attr('disabled', false);
            }
        });
    }
</script>
@endsection