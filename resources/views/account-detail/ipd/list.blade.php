@extends('layout.master');
@section('title', 'IPD - List')
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
                                <form action="{{ route('ipd-acount-detail.list') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="search_text">IPD ID</label>
                                            <input type="text" class="form-control" placeholder="IPD ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
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
                                            <label for="appointment_date">Admit Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="admit_date_range" id="admit_date_range" class="form-control" placeholder="Select date range" value="{{ $searchData['admit_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('ipd-acount-detail.list') }}">Reset</a>
                                            <button type="button" class="btn btn-info" onclick="exportIPD()"><i class="fa fa-file-export"></i> Export</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <h3>Total Fees: <span id="total_fees_amount">{{ $total_fees }}</span></h3>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <h3>Total Received Fees: <span id="total_received_fees_amount">{{ $total_received_fees }}</span></h3>
                                </div>
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
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered" id="accountDetailsIpdTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Admit ID</th>
                                                <th>Patient Name</th>
                                                <th>Contact No</th>
                                                <th>Has Mediclaim</th>
                                                <th>DOA</th>
                                                <th>DOD</th>
                                                <th>Is Discharged</th>
                                                <th>Bill Amount</th>
                                                <th>Received Amount</th>
                                                @if(auth()->user()->can('account-detail-ipd-bill-amount') || auth()->user()->can('account-detail-ipd-print-bill'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $ipd)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $ipd->ipd_id }}</td>
                                                <td>{{ $ipd->patientData->pa_name }}</td>
                                                <td>{{ $ipd->patientData->pa_contact_no }}</td>
                                                <td>{{ ($ipd->ipd_mediclaim == 'yes') ? 'Yes' : 'No' }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->ipd_admit_date)) }}</td>
                                                <td>{{ ($ipd->ipd_discharge_date != null) ? date('d M Y', strtotime($ipd->ipd_discharge_date)) : '' }}</td>
                                                <td>{{ ($ipd->ipd_discharge_date != null) ? 'Yes' : 'No' }}</td>
                                                <td id="billAmountShow_{{ $ipd->ipd_id }}">{{ $ipd->ipd_bill_amount }}</td>
                                                <td id="billReceivedAmountShow_{{ $ipd->ipd_id }}">{{ $ipd->ipd_received_amount }}</td>
                                                @if(auth()->user()->can('account-detail-ipd-bill-amount') || auth()->user()->can('account-detail-ipd-print-bill'))
                                                <td>
                                                    @can('account-detail-ipd-bill-amount')
                                                    <span id="billAmountView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Bill Details"><i class="la la-money-bill icon-3x cursor_pointer"></i></span>
                                                    @endcan
                                                    @can('account-detail-ipd-print-bill')
                                                    <i title="Print Bill" class="flaticon flaticon2-print icon-3x cursor_pointer" onclick="printIPDBill('{{ $ipd->ipd_id }}')"></i>
                                                    @endcan
                                                </td>
                                                @endif
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
    <div class="modal-dialog modal-xl popup-100" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Billing Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body" id="billAmountViewDetail">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><strong>IPD ID: </strong> <span id="ipdIdShow"></span></div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12"><strong>Patient Name: </strong> <span id="ipdPatientNameShow"></span></div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><strong>IPD Date: </strong><span id="ipd_admit_date_format"></span></div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><strong>Bill Amount: </strong><span id="billAmount">18000</span> Rs.</div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"><strong>Received Amount: </strong><span id="receivedAmount">18000</span> Rs.</div>
                </div>
                <div class="row mt-4">
                    <input type="hidden" id="ipd_id" name="ipd_id" value="">
                    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 col-12 pt-4 border-right-lg border-right-md">
                        <h4 class="text-center"><strong>Charge Details</strong></h4>
                        <div class="row pt-2">
                            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 col-12">
                                <div class="form-group">
                                    <label for="">Charge For <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ic_text" name="ic_text">
                                    <span class="text-danger" id="ic_textErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col-12">
                                <div class="form-group">
                                    <label for="">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="ic_amount" name="ic_amount">
                                    <span class="text-danger" id="ic_amountErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 col-12 mt-lg-3 mt-md-3">
                                <button class="btn btn-primary mt-lg-4 mt-md-4" id="addNewCharge">Add</button>
                            </div>
                        </div>
                        <div class="row pt-0">
                            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 col-12">
                                <div class="form-group">
                                    <label for="">Discount</label>
                                    <input type="number" class="form-control" id="ipd_discount" name="ipd_discount">
                                    <span class="text-danger" id="ipd_discountErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 col-12">
                                <div class="form-group">
                                    <label for="">Discount Approved By</label>
                                    <input type="text" class="form-control" id="ipd_discount_approved_by" name="ipd_discount_approved_by">
                                    <span class="text-danger" id="ipd_discount_approved_byErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 col-12">
                                <div class="form-group mt-lg-3 mt-md-3">
                                    <button class="btn btn-primary mt-lg-4 mt-md-4" id="updateDiscount">Update</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="ic_id" name="ic_id" value="">
                        <!-- <button class="btn btn-primary" id="addNewCharge">Add</button> -->
                        <table class="table scrollable_table_custom" id="chargeDetilsTable">
                            <thead>
                                <tr>
                                    <!-- <th>Charge ID</th> -->
                                    <th>Particular</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="chargeDetail"></tbody>
                        </table>

                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 col-12 pt-4">
                        <h4 class="text-center"><strong>Payment Received Details</strong></h4>
                        <div class="row pt-2">
                            <div class="col-lg-6 col-md-6 col-sm-12col-xs-12">
                                <div class="form-group">
                                    <label for="">Paid By <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ipl_paid_by" name="ipl_paid_by">
                                    <span class="text-danger" id="ipl_paid_byErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col-12">
                                <div class="form-group">
                                    <label for="">Mode of Payment <span class="text-danger">*</span></label>
                                    <select class="form-control" name="ipd_received_by" id="ipd_received_by">
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="card">Card</option>
                                        <option value="UPI">UPI</option>
                                    </select>
                                    <span class="text-danger" id="ipd_received_byErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 col-12">
                                <div class="form-group">
                                    <label for="">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="ipl_amount" name="ipl_amount">
                                    <span class="text-danger" id="ipl_amountErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-12">
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <input type="text" class="form-control" id="ipl_desc" name="ipl_desc">
                                    <span class="text-danger" id="ipl_descErr"></span>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 mt-lg-3 mt-md-3">
                                <button class="btn btn-primary mt-lg-4 mt-md-4" id="addNewPayment">Add</button>
                            </div>
                        </div>
                        <input type="hidden" id="ipl_id" name="ipl_id" value="">
                        <!-- <button class="btn btn-primary" id="addNewPayment">Add</button> -->
                        <table class="table scrollable_table_custom" id="paymentReceivedDetailsTable">
                            <thead>
                                <tr>
                                    <th>Receipt No</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>MOP</th>
                                    <th>Paid By</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="paymentDetail"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <i title="Print Bill" class="flaticon flaticon2-print icon-3x cursor_pointer" id="printBillInModal"></i>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // setTimeout(() => {
    //     var table = $('#accountDetailsIpdTable').DataTable();
    //     table.destroy();
    //     $('#accountDetailsIpdTable').DataTable({
    //         autoWidth: true,
    //         searching: false,
    //         paging: false,
    //         info: false
    //     });
    // }, 1000);

    var filterData = "{{ $searchDataEncoded }}";

    /* Export IPD Details */
    function exportIPD() {
        let search_text = $('#search_text').val();
        let admit_date_range = $('#admit_date_range').val();
        let query = '?search_text=' + search_text + '&admit_date_range=' + admit_date_range;
        window.location.href = "{{ route('ipd.export') }}" + query;
    }
    /* Show Bill Amount Modal */
    $('body').on('click', '#billAmountView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd-acount-detail.bill-detail', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                $('#billAmountViewModal').modal('show');
                if (res.response === true) {
                    let data = res.data;
                    let ipdData = res.data.ipdData;
                    let chargeList = res.data.chargeList;
                    let patientData = res.data.patientData;
                    let chargeRow = '';

                    $('#ipdIdShow').text(ipdData.ipd_id);
                    $('#ipdPatientNameShow').text(patientData.pa_name);

                    let monthName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    var mydate = new Date(ipdData.ipd_admit_date);
                    let ipd_admit_date_format = mydate.getDate() + ' ' + monthName[mydate.getMonth()] + ' ' + mydate.getFullYear();
                    $('#ipd_admit_date_format').text(ipd_admit_date_format)

                    $('#billAmount').text(ipdData.ipd_bill_amount);
                    $('#receivedAmount').text(ipdData.ipd_received_amount);
                    if (chargeList.length > 0) {
                        for (let i = 0; i < chargeList.length; i++) {
                            chargeRow += '<tr id="row_' + chargeList[i].ic_id + '"> \
                                <td>' + chargeList[i].ic_text + '</td> \
                                <td>' + chargeList[i].ic_amount + '</td> \
                                <td> \
                                    <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editCharge(' + chargeList[i].ic_id + ')"></i> \
                                    <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removerCharge(' + chargeList[i].ic_id + ')"></i> \
                                </td> \
                            </tr>';
                        }
                    }

                    $('#addNewCharge').attr("onclick", "addCharge('" + ipd_id + "')");

                    var table = $('#chargeDetilsTable').DataTable();
                    table.destroy();
                    $('#chargeDetilsTable').DataTable({
                        autoWidth: true,
                        searching: false,
                        paging: false,
                        info: false
                    });

                    $('#chargeDetail').html(chargeRow);

                    let paymentList = res.data.paymentList;
                    let paymentRow = '';
                    if (paymentList.length > 0) {
                        for (let i = 0; i < paymentList.length; i++) {
                            let MOP = paymentList[i].ipl_received_by;
                            if (MOP != 'UPI') {
                                MOP = MOP.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                    return letter.toUpperCase();
                                });
                            }
                            var mydate1 = new Date(paymentList[i].ipl_received_date);
                            let ipl_received_date1 = mydate1.getDate() + ' ' + monthName[mydate1.getMonth()] + ' ' + mydate1.getFullYear();
                            paymentRow += '<tr id="row_' + paymentList[i].ipl_id + '"> \
                                <td>' + paymentList[i].ipl_id + '</td> \
                                <td>' + ipl_received_date1 + '</td> \
                                <td>' + paymentList[i].ipl_amount + '</td> \
                                <td>' + MOP + '</td> \
                                <td>' + paymentList[i].ipl_paid_by + '</td> \
                                <td>' + paymentList[i].ipl_desc + '</td> \
                                <td> \
                                    <i title="Edit" class="la la-edit icon-3x cursor_pointer" onclick="editPayment(' + paymentList[i].ipl_id + ', ' + paymentList[i].ipd_id + ')"></i> \
                                    <i title="Remove" class="la la-trash icon-3x cursor_pointer" onclick="removePayment(' + paymentList[i].ipl_id + ', ' + paymentList[i].ipd_id + ')"></i> \
                                    <i title="Print Receipt" class="flaticon flaticon2-print icon-3x cursor_pointer" onclick="printReceipt(' + paymentList[i].ipl_id + ', ' + paymentList[i].ipd_id + ')"></i> \
                                </td> \
                            </tr>';
                        }
                    }
                    $('#addNewPayment').attr("onclick", "addPayment('" + ipd_id + "')");

                    var table = $('#paymentReceivedDetailsTable').DataTable();
                    table.destroy();
                    $('#paymentReceivedDetailsTable').DataTable({
                        autoWidth: true,
                        searching: false,
                        paging: false,
                        info: false
                    });

                    $('#paymentDetail').html(paymentRow);

                    $('#ipd_discount').val(ipdData.ipd_discount);
                    $('#ipd_discount_approved_by').val(ipdData.ipd_discount_approved_by);

                    $('#billAmountViewModal').modal('show');
                    $('#ipd_id').val(ipd_id);
                    $('#printBillInModal').attr('onclick', 'printIPDBill("' + atob(ipd_id) + '")');
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
    /* Update Discount */
    $('#updateDiscount').click(function() {
        let ipd_discount = $('#ipd_discount').val();
        let ipd_discount_approved_by = $('#ipd_discount_approved_by').val();
        let ipd_id = $('#ipd_id').val();
        if (ipd_discount_approved_by == '') {
            $('#ipd_discount_approved_byErr').text('Please enter approved by');
        } else {
            $('#ipd_discount_approved_byErr').text('');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('ipd-acount-detail.bill-discount-update') }}",
                method: "POST",
                data: {
                    ipd_id: ipd_id,
                    ipd_discount: ipd_discount,
                    ipd_discount_approved_by: ipd_discount_approved_by
                },
                success: function(res) {
                    console.log(res);
                    if (res.response == true) {
                        sweetAlertSuccess(res.message, 3000);
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
    /* Add Charge */
    function addCharge(ipd_id) {
        let ic_text = $('#ic_text').val();
        let ic_amount = $('#ic_amount').val();
        let ic_id = $('#ic_id').val();
        if (ic_text == '') {
            $('#ic_textErr').text('Please enter charge for');
            timeoutID('ic_textErr', 3000);
            scrollTop('ic_text');
        } else if (ic_amount == '') {
            $('#ic_amountErr').text('Please enter amount');
            timeoutID('ic_amountErr', 3000);
            scrollTop('ic_amount');
        } else {
            let query = 'ic_text=' + ic_text + '&ic_amount=' + ic_amount + '&ic_id=' + ic_id;
            $.ajax({
                url: "{{ route('ipd-acount-detail.charge.add', '') }}" + "/" + ipd_id + "?" + query,
                method: "GET",
                success: function(res) {
                    if (res.response == true) {
                        let data = res.data;
                        if (ic_id == '') {
                            let chargeRow = '<tr id="row_' + data.ic_id + '"> \
                                <td>' + data.ic_text + '</td> \
                                <td>' + data.ic_amount + '</td> \
                                <td> \
                                    <i class="la la-edit icon-3x cursor_pointer" onclick="editCharge(' + data.ic_id + ')"></i> \
                                    <i class="la la-trash icon-3x cursor_pointer" onclick="removerCharge(' + data.ic_id + ')"></i> \
                                </td> \
                            </tr>';
                            $('#chargeDetail').append(chargeRow);
                            $('#ic_text').val('');
                            $('#ic_amount').val('');
                            $('#ic_id').val('');
                        } else {
                            $('#row_' + data.ic_id + ' td').eq(0).html(data.ic_id);
                            $('#row_' + data.ic_id + ' td').eq(1).html(data.ic_text);
                            $('#row_' + data.ic_id + ' td').eq(2).html(data.ic_amount);
                            $('#ic_text').val('');
                            $('#ic_amount').val('');
                            $('#ic_id').val('');
                        }

                        $('#addNewCharge').text('Add');
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
    }
    /* Remove Charge */
    function removerCharge(ic_id) {
        $.ajax({
            url: "{{ route('ipd-acount-detail.charge.remove', '') }}" + "/" + btoa(ic_id),
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    $('#row_' + ic_id).remove();
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
    /* Edit Charge */
    function editCharge(ic_id) {
        $.ajax({
            url: "{{ route('ipd-acount-detail.charge.single', '') }}" + "/" + btoa(ic_id),
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    let data = res.data;
                    $('#ic_text').val(data.ic_text);
                    $('#ic_amount').val(data.ic_amount);
                    $('#ic_id').val(data.ic_id);
                    $('#addNewCharge').text('Update');
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
    /* Add Payment */
    function addPayment(ipd_id) {
        let ipl_paid_by = $('#ipl_paid_by').val();
        let ipl_received_by = $('#ipd_received_by').val();
        let ipl_amount = $('#ipl_amount').val();
        let ipl_desc = $('#ipl_desc').val();
        let ipl_id = $('#ipl_id').val();
        if (ipl_paid_by == '') {
            $('#ipl_paid_byErr').text('Please enter how has paid aount');
            timeoutID('ipl_paid_byErr', 3000);
            scrollTop('ipl_paid_by');
        } else if (ipd_received_by == '') {
            $('#ipd_received_byErr').text('Please select received by');
            timeoutID('ipd_received_byErr', 3000);
            scrollTop('ipd_received_by');
        } else if (ipl_amount == '') {
            $('#ipl_amountErr').text('Please enter amount');
            timeoutID('ipl_amountErr', 3000);
            scrollTop('ipl_amount');
        } else {
            let query = "ipl_paid_by=" + ipl_paid_by + "&ipl_received_by=" + ipl_received_by + "&ipl_amount=" + ipl_amount + "&ipl_desc=" + ipl_desc + "&ipl_id=" + ipl_id + '&filterData=' + filterData;
            $.ajax({
                url: "{{ route('ipd-acount-detail.payment.add', '') }}" + "/" + ipd_id + "?" + query,
                method: "GET",
                success: function(res) {
                    if (res.response == true) {
                        let data = res.data;
                        if (ipl_id == '') {
                            let chargeRow = '<tr id="row_' + data.iplData.ipl_id + '"> \
                                <td>' + data.iplData.ipl_id + '</td> \
                                <td>' + data.iplData.ipl_received_date + '</td> \
                                <td>' + data.iplData.ipl_amount + '</td> \
                                <td>' + data.iplData.ipl_received_by + '</td> \
                                <td>' + data.iplData.ipl_paid_by + '</td> \
                                <td>' + data.iplData.ipl_desc + '</td> \
                                <td> \
                                    <i class="la la-edit icon-3x cursor_pointer" onclick="editPayment(' + data.iplData.ipl_id + ', ' + data.iplData.ipd_id + ')"></i> \
                                    <i class="la la-trash icon-3x cursor_pointer" onclick="removePayment(' + data.iplData.ipl_id + ', ' + data.iplData.ipd_id + ')"></i> \
                                    <i class="flaticon flaticon2-print icon-3x cursor_pointer" onclick="printReceipt(' + data.iplData.ipl_id + ', ' + data.iplData.ipd_id + ')"></i> \
                                </td> \
                            </tr>';
                            $('#paymentDetail').append(chargeRow);
                            $('#ipl_paid_by').val('');
                            $('#ipl_received_by').val('');
                            $('#ipl_amount').val('');
                            $('#ipl_desc').val('');
                            $('#ipl_id').val('');
                        } else {
                            $('#row_' + data.iplData.ipl_id + ' td').eq(0).html(data.iplData.ipl_id);
                            $('#row_' + data.iplData.ipl_id + ' td').eq(1).html(data.iplData.ipl_received_date);
                            $('#row_' + data.iplData.ipl_id + ' td').eq(2).html(data.iplData.ipl_amount);
                            $('#row_' + data.iplData.ipl_id + ' td').eq(3).html(data.iplData.ipl_received_by);
                            $('#row_' + data.iplData.ipl_id + ' td').eq(4).html(data.iplData.ipl_desc);
                            $('#row_' + data.iplData.ipl_id + ' td').eq(5).html(data.iplData.ipl_paid_by);
                            $('#ipl_paid_by').val('');
                            $('#ipl_received_by').val('');
                            $('#ipl_amount').val('');
                            $('#ipl_desc').val('');
                            $('#ipl_id').val('');
                        }
                        receivedPayment(data.iplData.ipd_id);
                        $('#addNewPayment').text('Add');

                        $('#total_fees_amount').text(data.total_fees);
                        $('#total_received_fees_amount').text(data.total_received_fees);
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
    }
    /* Remove Payment */
    function removePayment(ipl_id) {
        let query = 'filterData=' + filterData;
        $.ajax({
            url: "{{ route('ipd-acount-detail.payment.remove', '') }}" + "/" + btoa(ipl_id) + '?' + query,
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    let data = res.data;
                    $('#row_' + ipl_id).remove();
                    console.log(data);
                    $('#total_fees_amount').text(data.total_fees);
                    $('#total_received_fees_amount').text(data.total_received_fees);
                    receivedPayment(data.iplData.ipd_id);
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
    /* Print Receipt */
    function printReceipt(ipl_id, ipd_id) {
        let url = "{{ route('ipd-acount-detail.payment.receipt.print', ['ipl_id' => ':ipl_id', 'ipd_id' => ':ipd_id']) }}";
        url = url.replace(':ipl_id', btoa(ipl_id));
        url = url.replace(':ipd_id', btoa(ipd_id));
        $.ajax({
            url: url,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }
    /* Edit Payment */
    function editPayment(ipl_id) {
        $.ajax({
            url: "{{ route('ipd-acount-detail.payment.single', '') }}" + "/" + btoa(ipl_id),
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    let data = res.data;
                    $('#ipl_paid_by').val(data.ipl_paid_by);
                    $('#ipd_received_by').val(data.ipl_received_by);
                    $('#ipl_amount').val(data.ipl_amount);
                    $('#ipl_desc').val(data.ipl_desc);
                    $('#ipl_id').val(data.ipl_id);
                    $('#addNewPayment').text('Update');
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
    /* Received Payment */
    function receivedPayment(ipd_id) {
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + btoa(ipd_id),
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    let data = res.data;
                    $('#receivedAmount').text(data.ipd_received_amount);
                    $('#billReceivedAmountShow_' + ipd_id).text(data.ipd_received_amount);
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
    /* Print Bill */
    function printIPDBill(ipd_id) {
        let url = "{{ route('ipd-acount-detail.payment.bill.print', ['ipd_id' => ':ipd_id']) }}";
        url = url.replace(':ipd_id', btoa(ipd_id));
        $.ajax({
            url: url,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }
</script>
@endsection