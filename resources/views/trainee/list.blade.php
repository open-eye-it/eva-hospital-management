@extends('layout.master');
@section('title', 'Trainee - List')
@section('breadcrumb-module', 'Trainee')
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
                            <div class="card card-custom gutter-b">
                                <form action="{{ route('trainee.list') }}">
                                    <div class="row p-5">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label>Search ID or Name or Contact No</label>
                                            <input type="text" class="form-control" placeholder="Search ID or Name or Contact No" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                                            <label>Start Date</label>
                                            <input type="date" name="start_date" id="start_date" value="{{ $searchData['start_date'] }}" class="form-control">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                                            <label>End Date</label>
                                            <input type="date" name="end_date" id="end_date" value="{{ $searchData['end_date'] }}" class="form-control">
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('trainee.list') }}">Resst</a>
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
                                    <table class="table table-bordered scrollable_table_custom" id="">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Trainee ID</th>
                                                <th>Name</th>
                                                <th>Contact No</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Added By</th>
                                                @can('trainee-status')
                                                <th>Status</th>
                                                @endcan
                                                @if(auth()->user()->can('trainee-read') || auth()->user()->can('trainee-update') || auth()->user()->can('trainee-certificate'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $trainee)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $trainee->tr_real_id }}</td>
                                                <td>{{ $trainee->tr_name }}</td>
                                                <td>{{ $trainee->tr_contact_no }}</td>
                                                <td>{{ date('d M Y', strtotime($trainee->tr_start_date)) }}</td>
                                                <td>{{ date('d M Y', strtotime($trainee->tr_end_date)) }}</td>
                                                <td>{{ $trainee->AddedByData->person_name }}</td>
                                                @can('trainee-status')
                                                <td>
                                                    @php
                                                    $status = 'Pending';
                                                    $status_class = 'label-light-info';
                                                    if($trainee->tr_status == 2){
                                                    $status = 'Completed';
                                                    $status_class = 'label-light-success';
                                                    }else if($trainee->tr_status == 3){
                                                    $status = 'Cancelled';
                                                    $status_class = 'label-light-danger';
                                                    }else{
                                                    $status = 'Pending';
                                                    $status_class = 'label-light-primary';
                                                    }
                                                    @endphp
                                                    <span onclick="showStatus('{{ base64_encode($trainee->tr_id) }}')" id="updateStatus_{{$trainee->tr_id}}" class="label label-lg font-weight-bold {{ $status_class }} label-inline">{{ $status }}</span>
                                                </td>
                                                @endcan
                                                @if(auth()->user()->can('trainee-read') || auth()->user()->can('trainee-update') || auth()->user()->can('trainee-certificate'))
                                                <td>
                                                    @can('trainee-update')
                                                    <a href="{{ route('trainee.edit', base64_encode($trainee->tr_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                    @endcan
                                                    @can('trainee-read')
                                                    <span id="fullView" data-id="{{ base64_encode($trainee->tr_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                    @endcan
                                                    @can('trainee-certificate')
                                                    <a href="{{ route('trainee.certificate.pdf', base64_encode($trainee->tr_id)) }}" title="Certificate"><i class="la la-certificate icon-3x"></i></a>
                                                    @endcan
                                                </td>
                                                @endif
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Trainee Detail</h5>
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Trainee Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Status</label>
                    <select name="tr_status" id="tr_status" class="form-control">

                    </select>
                </div>
                <div class="form-group">
                    <label>Reason for cancel</label>
                    <textarea name="tr_reason_cancel" id="tr_reason_cancel" class="form-control" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="statusBtn" class="btn btn-primary font-weight-bold">Update</button>
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function showStatus(tr_id) {
        $.ajax({
            url: "{{ route('trainee.view', '') }}" + "/" + tr_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let option = '';
                    if (data.tr_status == 1) {
                        option += '<option value="1" selected>Pending</option>';
                    } else {
                        option += '<option value="1">Pending</option>';
                    }
                    if (data.tr_status == 2) {
                        option += '<option value="2" selected>Completed</option>';
                    } else {
                        option += '<option value="2">Completed</option>';
                    }
                    if (data.tr_status == 3) {
                        option += '<option value="3" selected>Cancelled</option>';
                    } else {
                        option += '<option value="3">Cancelled</option>';
                    }
                    $('#tr_status').html(option);
                    $('#tr_reason_cancel').text(data.tr_reason_cancel);
                    $('#statusBtn').attr('onclick', 'changeStatus("' + tr_id + '")');
                    $('#statusModal').modal('show');
                    //sweetAlertSuccess(res.message, 3000);
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

    function changeStatus(tr_id) {
        let tr_status = $('#tr_status').val();
        let tr_reason_cancel = $('#tr_reason_cancel').val();
        let tr_id1 = atob(tr_id);
        let id = btoa(tr_id1 + '[]' + tr_status + '[]' + tr_reason_cancel);
        $.ajax({
            url: "{{ route('trainee.status', '') }}" + "/" + id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let statusText = 'Pending';
                    let statusClass = 'label-light-primary';
                    if (tr_status == 2) {
                        statusText = 'Completed';
                        statusClass = 'label-light-success';
                    } else if (tr_status == 3) {
                        statusText = 'Cancelled';
                        statusClass = 'label-light-danger';
                    } else {
                        statusText = 'Pending';
                        statusClass = 'label-light-primary';
                    }
                    $('#updateStatus_' + atob(tr_id)).text(statusText);
                    $('#updateStatus_' + atob(tr_id)).removeClass('label-light-primary');
                    $('#updateStatus_' + atob(tr_id)).removeClass('label-light-success');
                    $('#updateStatus_' + atob(tr_id)).removeClass('label-light-danger');
                    $('#updateStatus_' + atob(tr_id)).addClass(statusClass);
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

    $('body').on('click', '#fullView', function(event) {
        let tr_id = $(this).data('id');
        $.ajax({
            url: "{{ route('trainee.view', '') }}" + "/" + tr_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let is_advance_received = 'No';
                    if (data.tr_is_advance_received == 1) {
                        is_advance_received = 'Yes';
                    }
                    let fileList = '';
                    if (data.tr_documents != '' && data.tr_documents != null) {
                        let fileArr = JSON.parse(data.tr_documents);
                        let filepath = window.location.origin + '/storage/app/public/';
                        for (let i = 0; i < fileArr.length; i++) {
                            // fileList += '<p class="btn btn-primary" onclick="downloadFile(`' + fileArr[i] + '`)">' + fileArr[i] + '</p>';
                            fileList += '<a title="download" class="btn btn-primary mt-4" download href="{{ route("trainee.file.download", "") }}/' + btoa(fileArr[i]) + '">' + fileArr[i] + ' <i class="fa fa-download"></i></a>';
                        }
                    }
                    let view = '<tr> \
                        <th>TraineeID</th> \
                        <td>' + data.tr_real_id + '</td> \
                    </tr> \
                    <tr> \
                        <th>Name</th> \
                        <td>' + data.tr_name + '</td> \
                    </tr> \
                    <tr> \
                        <th>Contact No</th> \
                        <td>' + data.tr_contact_no + '</td> \
                    </tr> \
                    <tr> \
                        <th>Start Date</th> \
                        <td>' + moment(data.tr_start_date).format('DD MMM YYYY') + '</td> \
                    </tr> \
                    <tr> \
                        <th>End Date</th> \
                        <td>' + moment(data.tr_end_date).format('DD MMM YYYY') + '</td> \
                    </tr> \
                    <tr> \
                        <th>Total Amount</th> \
                        <td>' + data.tr_total_amount + '</td> \
                    </tr> \
                    <tr> \
                        <th>Paid Amount</th> \
                        <td>' + data.tr_paid_amount + '</td> \
                    </tr> \
                    <tr> \
                        <th>Is Advance Received?</th> \
                        <td>' + is_advance_received + '</td> \
                    </tr> \
                    <tr> \
                        <th>Advance Received Date</th> \
                        <td>' + data.tr_advance_received_date + '</td> \
                    </tr> \
                    <tr> \
                        <th>Advance Received Date</th> \
                        <td>' + data.tr_address + '</td> \
                    </tr> \
                    <tr> \
                        <th>Advance Received Date</th> \
                        <td>' + data.tr_remarks + '</td> \
                    </tr> \
                    <tr> \
                        <th>Documents</th> \
                        <td>' + fileList + '</td> \
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

    function downloadFile(fileName) {
        let urlPath = "{{ route('trainee.file.download', '') }}" + '/' + btoa(fileName);

        $.ajax({
            url: urlPath,
            method: "GET",
            success: function(res) {
                console.log(res);
            }
        });
    }
</script>
@endsection