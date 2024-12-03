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
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="search_text">Search Patient ID</label>
                                            <input type="text" class="form-control" placeholder="Search Appointment ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">OPD Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="appointment_date_range" class="form-control" readonly="readonly" placeholder="Select date range" value="{{ $searchData['appointment_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('opd-account-detail.list') }}">Resst</a>
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
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <h3>Total Fees: <span id="total_fees_amount">{{ $total_fees + $total_additional_fees }}</span></h3>
                                        </div>
                                    </div>
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
<script>
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
        } else {
            $('#addAdditionalCharge').addClass('spinner spinner-white spinner-right');
            $('#addAdditionalCharge').attr('disabled', true);
            let query = 'ap_id=' + ap_id + '&apac_desc=' + apac_desc + '&apac_qty=' + apac_qty + '&apac_charge=' + apac_charge + '&query=' + queryData;
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