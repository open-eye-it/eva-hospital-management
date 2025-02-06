@extends('layout.master');
@section('title', 'Follow-Up - OPD')
@section('breadcrumb-module', 'Follow-Up - OPD')
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
                                <form action="{{ route('follow-up.list') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="search_text">Patient ID</label>
                                            <input type="text" class="form-control" placeholder="Appointment ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">Follow Up Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="follow_up_date_range" id="follow_up_date_range" class="form-control" placeholder="Select date range" value="{{ $searchData['follow_up_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('follow-up.list') }}">Reset</a>
                                            <button type="button" class="btn btn-info" onclick="exportFollowUp()"><i class="fa fa-file-export"></i> Export</button>
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
                                    <table class="table table-bordered table-hover" id="followUpOpdListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Appointment ID</th>
                                                <th>Appointment Date</th>
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <th>Contact No</th>
                                                <th>Case Type</th>
                                                <!-- <th>Is FOC</th>
                                                <th>Fee</th>
                                                <th>Additional Charges</th> -->
                                                <th>Follow Up Date</th>
                                                <th>Decided Date of Surgery</th>
                                                <!-- <th>Bill</th> -->
                                                @can('follow-up-opd-note')
                                                <th>Notes</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $appointment)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $appointment->ap_id }}</td>
                                                <td>{{ $appointment->ap_date }}</td>
                                                <td>{{ $appointment->pa_id }}</td>
                                                <td>{{ $appointment->patientData->pa_name }}</td>
                                                <td>{{ $appointment->patientData->pa_contact_no }}</td>
                                                <td>{{ $appointment->ap_case_type }}</td>
                                                <!-- <td>{{ ($appointment->ap_is_foc == 'yes') ? 'Yes' : 'No' }}</td>
                                                <td>{{ $appointment->ap_charge }}</td>
                                                <td id="app_row_additional_charge_{{ $appointment->ap_id }}">{{ $appointment->ap_additional_charge }}</td> -->
                                                <td>{{ ($appointment->ap_follow_up_date != '' || !empty($appointment->ap_follow_up_date)) ? date('d M Y', strtotime($appointment->ap_follow_up_date)) : '' }}</td>
                                                <td>{{ date('d M Y', strtotime($appointment->ap_surg_date)) }}</td>
                                                <!-- <td>
                                                    <span id="billView" data-id="{{ base64_encode($appointment->ap_id) }}" title="Bill"><i class="flaticon flaticon-file-2 icon-3x cursor_pointer"></i></span>
                                                </td> -->
                                                @can('follow-up-opd-note')
                                                <td>
                                                    <span id="OPDNote" data-id="{{ base64_encode($appointment->ap_id) }}" title="Note"><i class="flaticon flaticon-file-1 icon-3x cursor_pointer"></i></span>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="10">Record not found</td>
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
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">OPD Note</h5>
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
                                <input type="text" class="form-control" placeholder="Appointment Date" name="ap_follow_up_date" id="ap_follow_up_date" value="{{ date('Y-m-d') }}" />
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                            <span class="text-danger" id="apac_descErr"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="apac_qty">Notes </label>
                            <textarea class="form-control" name="ap_follow_up_note" id="ap_follow_up_note" cols="30" rows="8"></textarea>
                            <span class="text-danger" id="apac_qtyErr"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="addNote" class="btn btn-primary" id="opd_note_submit">Submit</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // setTimeout(() => {
    //     var table = $('#followUpOpdListTable').DataTable();
    //     table.destroy();
    //     $('#followUpOpdListTable').DataTable({
    //         autoWidth: true,
    //         searching: false,
    //         paging: false,
    //         info: false
    //     });
    // }, 1000);

    function additionalChargeShow(ap_id, queryData) {
        $.ajax({
            url: "{{ route('opd-account-detail.additional-charge.list', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
                $('#addAdditionalCharge').removeClass('spinner spinner-white spinner-right');
                if (res.response === true) {
                    let data = res.data;
                    $('#allAdditionalCharge').prepend(data);
                    $('#addAdditionalCharge').attr("onclick", "addNewCharge('" + ap_id + "', '" + queryData + "')");
                    $('#additionalChargeModal').modal('show');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                $('#createBtn').removeClass('spinner spinner-white spinner-right');
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
            let query = 'ap_id=' + ap_id + '&apac_desc=' + apac_desc + '&apac_qty=' + apac_qty + '&apac_charge=' + apac_charge + '&query=' + queryData;
            $.ajax({
                url: "{{ route('opd-account-detail.additional-charge.store') }}" + '?' + query,
                method: "GET",
                success: function(res) {
                    console.log(res);
                    $('#addAdditionalCharge').removeClass('spinner spinner-white spinner-right');
                    if (res.response === true) {
                        let data = res.data;
                        let tableRow = '<tr> \
                        <td>' + data.data.apac_id + '</td> \
                        <td>' + data.data.apac_desc + '</td> \
                        <td>' + data.data.apac_qty + '</td> \
                        <td>' + data.data.apac_charge + '</td> \
                        <td>' + data.data.apac_final_charge + '</td> \
                        </tr>';
                        $('#allAdditionalCharge').prepend(tableRow);
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
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                }
            });
        }
    }

    /* Export Follow Up */
    function exportFollowUp() {
        let search_text = $('#search_text').val();
        let follow_up_date_range = $('#follow_up_date_range').val();
        let query = '?search_text=' + search_text + '&follow_up_date_range=' + follow_up_date_range;
        window.location.href = "{{ route('follow-up.export') }}" + query;
    }

    /* OPD Note Show */
    $('body').on('click', '#OPDNote', function() {
        let ap_id = $(this).data('id');
        $.ajax({
            url: "{{ route('appointment.view', '') }}" + "/" + ap_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                if (res.response === true) {
                    let data = res.data;
                    $('#ap_follow_up_date').val(data.ap_follow_up_date);
                    $('#ap_follow_up_note').val(data.ap_follow_up_note);
                    $('#addNote').attr('onclick', "OPDNoteSumit('" + ap_id + "')");
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
    function OPDNoteSumit(ap_id) {
        let ap_follow_up_date = $('#ap_follow_up_date').val();
        let ap_follow_up_note = $('#ap_follow_up_note').val();
        let query = 'ap_follow_up_date=' + ap_follow_up_date + '&ap_follow_up_note=' + ap_follow_up_note;
        $('#addNote').addClass('spinner spinner-white spinner-right');
        $('#addNote').attr('disabled', true);
        $.ajax({
            url: "{{ route('appointment.note.update', '') }}" + "/" + ap_id + "?" + query,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    $('#ap_follow_up_date').val('');
                    $('#ap_follow_up_note').val('');
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