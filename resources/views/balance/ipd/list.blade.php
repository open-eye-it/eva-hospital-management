@extends('layout.master');
@section('title', 'IPD - Account Detail')
@section('breadcrumb-module', 'IPD')
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
                                <form action="{{ route('balance.ipd') }}">
                                    <div class="row">
                                        <!-- <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="search_text">Search IPD ID</label>
                                            <input type="text" class="form-control" placeholder="Search IPD ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div> -->
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">IPD Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="date_range" id="date_range" class="form-control" placeholder="Select date range" value="{{ $searchData['admit_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('balance.ipd') }}">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card card-custom bg-danger card-stretch gutter-b">
                                <div class="card-body">
                                    <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $total_fees }}</span>
                                    <h2 class="font-weight-bold text-white">Total Fees</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card card-custom bg-primary card-stretch gutter-b">
                                <div class="card-body">
                                    <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $total_received_fees }}</span>
                                    <h2 class="font-weight-bold text-white">Total Received Fees</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card card-custom bg-info card-stretch gutter-b">
                                <div class="card-body">
                                    <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $ipd_total_cash }}</span>
                                    <h2 class="font-weight-bold text-white">Total Cash</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card card-custom bg-dark card-stretch gutter-b">
                                <div class="card-body">
                                    <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $ipd_total_cheque }}</span>
                                    <h2 class="font-weight-bold text-white">Total Cheque</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="card card-custom bg-warning card-stretch gutter-b">
                                <div class="card-body">
                                    <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">{{ $ipd_total_card }}</span>
                                    <h2 class="font-weight-bold text-white">Total Card</h2>
                                </div>
                            </div>
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