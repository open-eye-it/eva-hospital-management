@extends('layout.master');
@section('title', 'OPD - Account Detail')
@section('breadcrumb-module', 'OPD')
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
                                <form action="{{ route('opd-account-detail.list') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="search_text">Patient ID</label>
                                            <input type="text" class="form-control" placeholder="Appointment ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
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
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">OPD Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="appointment_date_range" class="form-control" readonly="readonly" placeholder="Select date range" value="{{ $searchData['appointment_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('opd-account-detail.list') }}">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b">
                                <div class="card-header flex-wrap py-2">
                                    <div class="card-title">
                                        <h3 class="card-label">Account Detail
                                        </h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <h3>Total Fees: <span id="total_fees_amount">{{ $total_fees + $total_additional_fees }}</span></h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered table-hover scrollable_table_custom" id="accountDetailsOpdTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Appointment ID</th>
                                                <th>DOA</th>
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <th>Contact No</th>
                                                <th>Case</th>
                                                <th>Is FOC</th>
                                                <th>Fee</th>
                                                <th>Fee Status</th>
                                                <th>Extra Charges</th>
                                                <!-- <th>Follow Up Date</th> -->
                                                <th>Decided Date of Surgery</th>
                                                @can('account-detail-opd-additional-charge')
                                                <th>Add Charges</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $appointment)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $appointment->ap_id }}</td>
                                                <td>{{ date('d M Y', strtotime($appointment->ap_date)) }}</td>
                                                <td>{{ $appointment->pa_id }}</td>
                                                <td>{{ $appointment->patientData->pa_name }}</td>
                                                <td>{{ $appointment->patientData->pa_contact_no }}</td>
                                                <td>{{ ucfirst($appointment->ap_case_type) }}</td>
                                                <td>{{ ($appointment->ap_is_foc == 'yes') ? 'Yes' : 'No' }}</td>
                                                <td>{{ $appointment->ap_charge }}</td>
                                                <td>{{ ucfirst($appointment->ap_charge_status) }}</td>
                                                <td id="app_row_additional_charge_{{ $appointment->ap_id }}">{{ $appointment->ap_additional_charge }}</td>
                                                <!-- <td>{{ ($appointment->ap_follow_up_date != '' || !empty($appointment->ap_follow_up_date)) ? date('d M Y', strtotime($appointment->ap_follow_up_date)) : '' }}</td> -->
                                                <td>{{ date('d M Y', strtotime($appointment->ap_surg_date)) }}</td>
                                                @can('account-detail-opd-additional-charge')
                                                <td>

                                                    <i title="Additional Charge" class="icon-2x flaticon flaticon-add-circular-button cursor_pointer" onclick="additionalChargeShow('{{ base64_encode($appointment->ap_id) }}', '{{ json_encode($searchData) }}')"></i>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="13">Record not found</td>
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
<div class="modal fade" id="additionalChargeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">OPD Extra Charges</h5>
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
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="apac_qty">QTY <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="apac_qty" id="apac_qty" value="0" onchange="changeQty(this.value)">
                            <span class="text-danger" id="apac_qtyErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="apac_charge">Charge <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="apac_charge" id="apac_charge" value="0" onchange="changeCharge(this.value)">
                            <span class="text-danger" id="apac_chargeErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="apac_charge">Total Charge <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="apac_total_charge" id="apac_total_charge" value="0" disabled>
                            <span class="text-danger" id="apac_total_chargeErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label for="apac_payment_mode">Mode of Payment <span class="text-danger">*</span></label>
                            <select class="form-control" name="apac_payment_mode" id="apac_payment_mode">
                                <option value="">Select</option>
                                @foreach(PaymentMode() as $paymentType)
                                <option value="{{ $paymentType['ap_payment_mode'] }}">{{ ucfirst($paymentType['ap_payment_mode']) }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="apac_payment_modeErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pt-lg-4 mt-lg-4 pt-md-4 mt-md-4">
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
                            <th>Mode of Payment</th>
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
    function changeQty(val) {
        let charge = $('#apac_charge').val();
        let total = val * charge;
        $('#apac_total_charge').val(total);
    }

    function changeCharge(val) {
        let qty = $('#apac_qty').val();
        let total = val * qty;
        $('#apac_total_charge').val(total);
    }
    $('#apac_qty').on('keyup', function() {
        let val = $(this).val();
        let charge = $('#apac_charge').val();
        let total = val * charge;
        $('#apac_total_charge').val(total);
    });
    $('#apac_charge').on('keyup', function() {
        let val = $(this).val();
        let qty = $('#apac_qty').val();
        let total = val * qty;
        $('#apac_total_charge').val(total);
    });

    setTimeout(() => {
        var table = $('#accountDetailsOpdTable').DataTable();
        table.destroy();
        $('#accountDetailsOpdTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

    function additionalChargeShow(ap_id, queryData) {
        let url = "{{ route('opd-account-detail.additional-charge.list', ['ap_id' => ':ap_id', 'queryData' => ':queryData']) }}";
        url = url.replace(':ap_id', ap_id);
        url = url.replace(':queryData', queryData);
        $.ajax({
            url: url,
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
                    $('#addAdditionalCharge').removeClass('spinner spinner-white spinner-right');
                    $('#addAdditionalCharge').attr('disabled', false);
                    if (res.response === true) {
                        let data = res.data;
                        let tableRow = '<tr id="row_' + data.data.apac_id + '"> \
                        <td>' + data.data.apac_id + '</td> \
                        <td>' + data.data.apac_desc + '</td> \
                        <td>' + data.data.apac_qty + '</td> \
                        <td>' + data.data.apac_charge + '</td> \
                        <td>' + data.data.apac_final_charge + '</td> \
                        <td>' + data.data.apac_payment_mode + '</td> \
                        <td><i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge(' + data.data.apac_id + ', ' + ap_id + ', ' + btoa(queryData) + ')"></i></td> <\tr > ';
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
                    $('#total_fees_amount').text(data.total_final);
                    $('#app_row_additional_charge_' + atob(ap_id)).text(data.appointment_row_additional_charge);
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