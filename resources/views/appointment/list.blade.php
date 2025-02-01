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
                            <div class="card card-custom gutter-b pt-5 pl-5 pr-5 pb-0">
                                <form action="{{ route('appointment.list') }}" class="mb-0">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group d-none">
                                            <label for="search_text">Search Appointment ID</label>
                                            <input type="text" class="form-control" placeholder="Search Appointment ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="search_text">Patient ID or Phone Number</label>
                                            <input type="text" class="form-control" placeholder="Patient ID or Phone Number" name="patient_id_phone_number" id="patient_id_phone_number" value="{{ $searchData['patient_id_phone_number'] }}">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group">
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
                                        <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">Appointment Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="appointment_date_range" id="appointment_date_range_filter" class="form-control" placeholder="Select date range" value="{{ $searchData['appointment_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group">
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
                                        <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="case_type">Case Type</label>
                                            <select class="form-control" name="case_type" id="case_type1" onchange="changeFee(this.value)">
                                                <option value="">Select</option>
                                                @if(!empty($visitingFees))
                                                @foreach($visitingFees as $fee)
                                                <option value="{{ $fee->vf_case_type }}" {{ ($fee->vf_case_type == $searchData['case_type']) ? 'selected' : '' }}>{{ ucfirst($fee->vf_case_type) }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="patient">Status</label>
                                            <select class="form-control" name="ap_status" id="ap_status1" onchange="changeFee(this.value)">
                                                <option value="">Select</option>
                                                <option value="pending" {{ ($searchData['ap_status'] == 'pending') ? 'selected' : '' }}>Pending</option>
                                                <option value="completed" {{ ($searchData['ap_status'] == 'completed') ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ ($searchData['ap_status'] == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('appointment.list') }}">Reset</a>
                                            <button type="button" class="btn btn-info" onclick="exportAppointment()"><i class="fa fa-file-export"></i> Export</button>
                                            @php
                                            $filterDataRangeArr = explode(' - ', $searchData['appointment_date_range']);
                                            @endphp
                                            <a class="btn btn-primary" href="{{ route('appointment.list', ['appointment_date_range' => date('Y-m-d', strtotime($filterDataRangeArr[0].' -1 day')).' - '.date('Y-m-d', strtotime($filterDataRangeArr[0].' -1 day'))]) }}"><i class="fa fa-arrow-left"></i> Previous Day</a>
                                            <a class="btn btn-primary" href="{{ route('appointment.list', ['appointment_date_range' => date('Y-m-d', strtotime($filterDataRangeArr[0].' +1 day')).' - '.date('Y-m-d', strtotime($filterDataRangeArr[0].' +1 day'))]) }}">Next Day <i class="fa fa-arrow-right"></i></a>
                                            <a class="btn btn-primary float-right" href="{{ route('appointment.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                    <table class="table table-bordered table-separate scrollable_table_custom" id="appointmentTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <!-- <th>Appointment ID</th> -->
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <th class="min-w-100px">DOA</th>
                                                <th>Dr Name</th>
                                                <th>Case</th>
                                                <th>Fees Amount</th>
                                                <th>Fees</th>
                                                <th>Referred By</th>
                                                <!-- <th>Has Madiclaim</th> -->
                                                @can('appointment-status')
                                                <th>Status</th>
                                                @endcan
                                                @can('appointment-prescription')
                                                <th>Prescribe</th>
                                                @endcan
                                                @if(auth()->user()->can('appointment-edit') || auth()->user()->can('appointment-full-view') || auth()->user()->can('appointment-bill-print') || auth()->user()->can('appointment-additional-charge'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $appointment)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <!-- <td>{{ $appointment->ap_id }}</td> -->
                                                <td>{{ $appointment->pa_id }}</td>
                                                <td>{{ $appointment->patientData->pa_name }}</td>
                                                <td>{{ date('d M Y',strtotime($appointment->ap_date)) }}</td>
                                                <td>{{ $appointment->doctorData->person_name }}</td>
                                                <td>{{ ucfirst($appointment->ap_case_type) }}</td>
                                                <td>{{ $appointment->ap_charge }}</td>
                                                <td>{{ ucfirst($appointment->ap_charge_status) }}</td>
                                                <td>{{ $appointment?->patientData?->pa_referred_doctor }}</td>
                                                <!-- <td>{{ ($appointment->ap_pament_mode == 'mediclaim') ? 'Yes' : 'No' }}</td> -->
                                                @can('appointment-status')
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
                                                @endcan
                                                @can('appointment-prescription')
                                                <td>
                                                    <span class="btn btn-danger mb-2" onclick="prescribeShow('{{ base64_encode($appointment->ap_id) }}')">Prescribe</span>
                                                    <span id="prescriptionBillView" data-id="{{ base64_encode($appointment->ap_id) }}" title="Prescription Bill"><i class="flaticon flaticon2-print icon-3x cursor_pointer"></i></span>
                                                </td>
                                                @endcan
                                                @if(auth()->user()->can('appointment-edit') || auth()->user()->can('appointment-full-view') || auth()->user()->can('appointment-bill-print') || auth()->user()->can('appointment-additional-charge'))
                                                <td>
                                                    <div class="dropdown dropdown-inline">
                                                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"> <i class="ki ki-bold-more-hor icon-3x"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                            <ul class="nav nav-hoverable">
                                                                @can('appointment-edit')
                                                                <li class="nav-item"><a class="nav-link" href="{{ route('appointment.edit', base64_encode($appointment->ap_id)) }}" title="Edit"><i class="la la-edit icon-3x px-1"></i></a></li>
                                                                @endcan
                                                                @can('appointment-full-view')
                                                                <li class="nav-item"><span class="nav-link" id="fullView" data-id="{{ base64_encode($appointment->ap_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer px-1"></i></span></li>
                                                                @endcan
                                                                @can('appointment-bill-print')
                                                                <li class="nav-item"><span class="nav-link" id="billView" data-id="{{ base64_encode($appointment->ap_id) }}" title="Bill"><i class="flaticon flaticon2-print icon-3x cursor_pointer px-1"></i></span></li>
                                                                @endcan
                                                                @can('appointment-additional-charge')
                                                                <li class="nav-item"><span class="nav-link" title="Additional Charge"><i title="Additiona Charge" class="flaticon flaticon-add-circular-button icon-3x cursor_pointer px-1" onclick="additionalChargeShow('{{ base64_encode($appointment->ap_id) }}', '{{ json_encode($searchData) }}')"></i></span></li>
                                                                @endcan
                                                                <li class="nav-item"><span class="nav-link" id="AppointmentDocument" data-id="{{ base64_encode($appointment->ap_id) }}" title="Appointment Documents"><i class="flaticon flaticon-file icon-3x cursor_pointer"></i></span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="11">Record not found</td>
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
<div class="modal fade" id="appointmentDocViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Appointment Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enc-type="multipart/form-data" id="submitDocument">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12col-xs-12">
                            <label for="patient_name">Document Name</label>
                            <input type="text" class="form-control" name="ap_doc_name" id="ap_doc_name" value="" placeholder="Document Name" />
                            <span class="text-danger" id="ap_doc_name_err"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12col-xs-12">
                            <label for="patient_name">Document File</label>
                            <input type="file" class="form-control" name="ap_doc" id="ap_doc" value="" placeholder="Document" />
                            <span class="text-danger" id="ap_doc_err"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12col-xs-12">
                            <input type="hidden" id="ap_id_doc" name="ap_id_doc" value="">
                            <button type="submit" id="docAdd" class="btn btn-primary mt-4">Add <i class="la la-plus"></i></button>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="appointmentDocData"></tbody>
                </table>
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
                <h5 class="modal-title" id="exampleModalLabel">Appointment Detail</h5>
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
                <h5 class="modal-title" id="exampleModalLabel">Appointment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="statusDetail">
                    <div class="form-group">
                        <label for="">Satatus</label>
                        <select name="ap_status_val" id="ap_status_val" class="form-control" onchange="changeStatusVal(this.value)">
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
<div class="modal fade" id="additionalChargeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">OPD Additional Charges</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="apac_desc">Description <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="apac_desc" id="apac_desc" value="">
                            <span class="text-danger" id="apac_descErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="apac_qty">QTY <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="apac_qty" id="apac_qty" value="">
                            <span class="text-danger" id="apac_qtyErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="apac_charge">Charge <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="apac_charge" id="apac_charge" value="">
                            <span class="text-danger" id="apac_chargeErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="apac_payment_mode">Mode of Payment <span class="text-danger">*</span></label>
                            <select class="form-control" name="apac_payment_mode" id="apac_payment_mode" onchange="changePaymnt(this.value)">
                                <option value="">Select</option>
                                @foreach(PaymentMode() as $paymentType)
                                <option value="{{ $paymentType['ap_payment_mode'] }}">{{ ucfirst($paymentType['ap_payment_mode']) }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="apac_payment_modeErr"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="addAdditionalCharge" class="btn btn-primary">Add <i class="la la-plus"></i></button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Description</th>
                            <th>QTY</th>
                            <th>Charge</th>
                            <th>Total Charge</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="allAdditionalCharge">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(() => {
        var table = $('#appointmentTable').DataTable();
        table.destroy();
        $('#appointmentTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

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
                        <th>Height__cm</th> \
                        <td>' + $.trim(data.ap_height) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Weight__kg</th> \
                        <td>' + $.trim(data.ap_weight) + '</td> \
                        <th>BP(_/_)mmhg</th> \
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
                        <td>' + $.trim(data.ap_case_type).toLowerCase().replace(/^[a-z]/, function(m) {
                        return m.toUpperCase()
                    }) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Fees</th> \
                        <td>' + $.trim(data.ap_charge) + '</td> \
                        <th>Fee Status</th> \
                        <td>' + $.trim(data.ap_charge_status).toLowerCase().replace(/^[a-z]/, function(m) {
                        return m.toUpperCase()
                    }) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Additional Charge</th> \
                        <td>' + $.trim(data.ap_additional_charge) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Last Menstrual Period</th> \
                        <td>' + $.trim(data.pa_last_monestrual_period) + '</td> \
                        <th>Number of Pregnancy</th> \
                        <td>' + $.trim(data.pa_pregnancy_no) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Number of Miscarriages</th> \
                        <td>' + $.trim(data.pa_miscarriages_no) + '</td> \
                        <th>Number of Living Children</th> \
                        <td>' + $.trim(data.pa_children_no) + '</td> \
                    </tr> \
                    <tr> \
                        <th colspan="4"><h4><strong>Do you consume any of below?</strong></h4></th> \
                    </tr> \
                    <tr> \
                        <th>Tobacco</th> \
                        <td>' + $.trim(data.pa_tobacco) + '</td> \
                        <th>Smoking</th> \
                        <td>' + $.trim(data.pa_smoking) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Alcohol</th> \
                        <td colspan="3">' + $.trim(data.pa_alcohol) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Any medical or surgical history?</th> \
                        <td colspan="3">' + $.trim(data.pa_medical_history) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Family member had any medical or surgical history?</th> \
                        <td colspan="3">' + $.trim(data.pa_family_medical_history) + '</td> \
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

    function statusModal(ap_id) {
        $('#statusModal').modal('show');
        // $('#pendingStatus').attr('onclick', 'changeStatus("' + ap_id.toString() + '", "pending")');
        // $('#completedStatus').attr('onclick', 'changeStatus("' + ap_id.toString() + '", "completed")');
        // $('#cancelledStatus').attr('onclick', 'changeStatus("' + ap_id.toString() + '", "cancelled")');
        $('#statusButton').attr('onclick', 'changeStatus("' + ap_id.toString() + '")');
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

    function changeStatusVal(ap_status_val) {
        if (ap_status_val == 'cancelled') {
            $('#statusCancelReason').removeClass('d-none');
        } else {
            $('#statusCancelReason').addClass('d-none');
        }
    }

    function changeStatus(ap_id) {
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
        let case_type = $('#case_type1').val();
        let query = '?search_text=' + search_text + '&patient=' + patient + '&appointment_date_range=' + appointment_date_range + '&doctor=' + doctor + '&case_type=' + case_type;
        window.location.href = "{{ route('appointment.export') }}" + query;
    }

    $('body').on('click', '#billView', function(event) {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('appointment.bill_print', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
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

    $('body').on('click', '#prescriptionBillView', function(event) {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('appointment.prescription_bill_print', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
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

    function additionalChargeShow(ap_id, queryData) {
        $.ajax({
            url: "{{ route('opd-account-detail.additional-charge.list', '') }}" + "/" + ap_id + "/" + queryData,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    $('#allAdditionalCharge').html(data);
                    $('#addAdditionalCharge').attr("onclick", "addNewCharge('" + ap_id + "', '" + queryData + "')");
                    $('#additionalChargeModal').modal('show');
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

    function addNewCharge(ap_id, queryData) {
        let apac_desc = $('#apac_desc').val();
        let apac_qty = $('#apac_qty').val();
        let apac_charge = $('#apac_charge').val();
        let apac_payment_mode = $('#apac_payment_mode').val();
        if (apac_desc == '') {
            $('#apac_descErr').text('Please enter description');
            timeoutID('apac_descErr', 3000);
            scrollTop('apac_descErr');
        } else if (apac_qty == '') {
            $('#apac_qtyErr').text('Please enter quantity of charge');
            timeoutID('apac_qtyErr', 3000);
            scrollTop('apac_qtyErr');
        } else if (apac_charge == '') {
            $('#apac_chargeErr').text('Please enter additional charge');
            timeoutID('apac_chargeErr', 3000);
            scrollTop('apac_chargeErr');
        } else if (apac_payment_mode == '') {
            $('#apac_payment_modeErr').text('Please select paymetn mode');
            timeoutID('apac_payment_modeErr', 3000);
            scrollTop('apac_payment_modeErr');
        } else {
            $('#addAdditionalCharge').addClass('spinner spinner-white spinner-right');
            $('#addAdditionalCharge').attr('disabled', true);
            let query = 'ap_id=' + ap_id + '&apac_desc=' + apac_desc + '&apac_qty=' + apac_qty + '&apac_charge=' + apac_charge + '&apac_payment_mode=' + apac_payment_mode + '&query=' + queryData;
            $.ajax({
                url: "{{ route('opd-account-detail.additional-charge.store') }}" + '?' + query,
                method: "GET",
                success: function(res) {
                    console.log('ok');
                    console.log(res);
                    let blankText = "";
                    $('#addAdditionalCharge').removeClass('spinner spinner-white spinner-right');
                    $('#addAdditionalCharge').attr('disabled', false);
                    if (res.response === true) {
                        let data = res.data;
                        let tableRow = '<tr> \
                        <td>' + data.data.apac_id + '</td> \
                        <td>' + data.data.apac_desc + '</td> \
                        <td>' + data.data.apac_qty + '</td> \
                        <td>' + data.data.apac_charge + '</td> \
                        <td>' + data.data.apac_final_charge + '</td> \
                        <td><i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge(' + data.data.apac_id + ', ' + btoa(data.data.ap_id) + ', ' + blankText + ')"></i></td> \
                        </tr>';
                        $('#allAdditionalCharge').prepend(data.tableRow);
                        $('#total_fees_amount').text(data.total_final);
                        $('#app_row_additional_charge_' + atob(ap_id)).text(data.appointment_row_additional_charge);

                        $('#apac_desc').val('');
                        $('#apac_qty').val('');
                        $('#apac_charge').val('');
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                },
                error: function(r) {
                    $('#addAdditionalCharge').removeClass('spinner spinner-white spinner-right');
                    $('#addAdditionalCharge').attr('disabled', false);
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                }
            });
        }
    }

    /* Remove Charge */
    function removerCharge(apac_id, ap_id, queryData) {
        let url = "{{ route('opd-account-detail.additional-charge.remove', ['apac_id' => ':apac_id', 'ap_id' => ':ap_id', 'queryData' => ':queryData']) }}";
        url = url.replace(':apac_id', apac_id);
        url = url.replace(':ap_id', ap_id);
        url = url.replace(':queryData', queryData);
        $.ajax({
            url: url,
            method: "GET",
            success: function(res) {
                console.log(res);
                if (res.response == true) {
                    let data = res.data;
                    $('#row_' + apac_id).remove();
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

    /* Appointment Document */
    $('body').on('click', '#AppointmentDocument', function() {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('appointment.doc.view', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                $('#ap_id_doc').val(ap_id);
                $('#appointmentDocData').html(res.data);
                $('#appointmentDocViewModal').modal('show');
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    $('#submitDocument').on('submit', function(e) {
        e.preventDefault();
        let name = $('#ap_doc_name').val();
        let file = $('#ap_doc').val();
        if (name == '') {
            $('#ap_doc_name_err').text('Please enter doc name');
        } else if (file == '') {
            $('#ipdap_doc_err').text('Please select document');
        } else {
            let formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('appointment.doc.send') }}",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: (res) => {
                    if (res.response == true) {
                        $('#appointmentDocData').prepend(res.data);
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
    });

    function removerDoc(id) {
        $.ajax({
            url: "{{ route('appointment.doc.remove') }}/" + id,
            method: "GET",
            success: function(res) {
                console.log(res);
                if (res.response == true) {
                    $('#doc_row_' + id).remove();
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
</script>
@endsection