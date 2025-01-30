@extends('layout.master');
@section('title', 'Trainee - Add')
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
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">Add</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" enctype="multipart/form-data" action="{{ route('trainee.store', base64_encode($tr_real_id)) }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Trainee ID <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Trainee ID" name="tr_real_id" id="tr_real_id" value="{{ $tr_real_id }}" disabled />
                                                    <span class="text-danger" id="tr_real_idErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Name" name="tr_name" id="tr_name" />
                                                    <span class="text-danger" id="tr_nameErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Contact No <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" placeholder="Contact No" name="tr_contact_no" id="tr_contact_no" />
                                                    <span class="text-danger" id="tr_contact_noErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Start Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" placeholder="Start Date" name="tr_start_date" id="tr_start_date" />
                                                    <span class="text-danger" id="tr_start_dateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>End Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" placeholder="End Date" name="tr_end_date" id="tr_end_date" />
                                                    <span class="text-danger" id="tr_end_dateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Total Amount <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" placeholder="Total Amount" name="tr_total_amount" id="tr_total_amount" />
                                                    <span class="text-danger" id="tr_total_amountErr"></span>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Paid Amount</label>
                                                    <input type="number" class="form-control" placeholder="Paid Amount" name="tr_paid_amount" id="tr_paid_amount" />
                                                    <span class="text-danger" id="tr_paid_amountErr"></span>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Is Advance Received? <span class="text-danger">*</span></label>
                                                    <select name="tr_is_advance_received" id="tr_is_advance_received" class="form-control">
                                                        <option value="">-Select-</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    <span class="text-danger" id="tr_is_advance_receivedErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Advance Received Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" placeholder="End Date" name="tr_advance_received_date" id="tr_advance_received_date" />
                                                    <span class="text-danger" id="tr_advance_received_dateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Documents</label>
                                                    <input type="file" class="form-control" name="tr_documents[]" id="tr_documents" multiple>
                                                    <span class="text-danger" id="tr_documentsErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Address <span class="text-danger">*</span></label>
                                                    <textarea name="tr_address" id="tr_address" class="form-control" cols="30" rows="10"></textarea>
                                                    <span class="text-danger" id="tr_addressErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Remarks</label>
                                                    <textarea name="tr_remarks" id="tr_remarks" class="form-control" cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin: Code-->
                                        <div class="example-code mt-10">
                                            <div class="example-highlight">
                                                <pre style="height:400px">
                                            </div>
                                        </div>
                                        <!--end: Code-->
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" id="createBtn">Add</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                                <!--end::Form-->
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
    $("form").submit(function(e) {
        e.preventDefault();
        let tr_name = $('#tr_name').val();
        let tr_contact_no = $('#tr_contact_no').val();
        let tr_start_date = $('#tr_start_date').val();
        let tr_end_date = $('#tr_end_date').val();
        let tr_total_amount = $('#tr_total_amount').val();
        let tr_paid_amount = $('#tr_paid_amount').val();
        let tr_is_advance_received = $('#tr_is_advance_received').val();
        let tr_advance_received_date = $('#tr_advance_received_date').val();
        let tr_address = $('#tr_address').val();
        let tr_remarks = $('#tr_remarks').val();
        let tr_documents = $('#tr_documents').prop('files');
        let fileExt = ['jpg', 'jpeg', 'png'];
        let fileValidation = false;
        if(tr_documents.length > 0){
            for(let i=0; i<tr_documents.length; i++){
                let fileName = tr_documents[i].name;
                let nameArr = fileName.split('.');
                let nameArrLength = nameArr.length;
                if(!fileExt.includes(nameArr[nameArrLength-1])){
                    fileValidation = true;
                }
            }
        }
        
        if(tr_name == ''){
            $('#tr_nameErr').text('Please enter name');
            timeoutID('tr_nameErr', 3000);
            scrollTop('tr_nameErr');
        }
        else if(tr_contact_no == ''){
            $('#tr_contact_noErr').text('Please enter contact no');
            timeoutID('tr_contact_noErr', 3000);
            scrollTop('tr_contact_noErr');
        }else if(tr_contact_no.length > 10 || tr_contact_no.length < 10){
            $('#tr_contact_noErr').text('Please enter only 10 digits');
            timeoutID('tr_contact_noErr', 3000);
            scrollTop('tr_contact_noErr');
        }else if(tr_start_date == ''){
            $('#tr_start_dateErr').text('Please start date');
            timeoutID('tr_start_dateErr', 3000);
            scrollTop('tr_start_dateErr');
        }else if(tr_end_date == ''){
            $('#tr_end_dateErr').text('Please select end date');
            timeoutID('tr_end_dateErr', 3000);
            scrollTop('tr_end_dateErr');
        }else if(tr_start_date > tr_end_date){
            $('#tr_start_dateErr').text('start date should be greate than end date');
            timeoutID('tr_start_dateErr', 3000);
            scrollTop('tr_start_dateErr');
        }else if(tr_total_amount == ''){
            $('#tr_total_amountErr').text('Please enter total amount');
            timeoutID('tr_total_amountErr', 3000);
            scrollTop('tr_total_amountErr');
        }else if(tr_is_advance_received == ''){
            $('#tr_is_advance_receivedErr').text('Please select is adavance received or not');
            timeoutID('tr_is_advance_receivedErr', 3000);
            scrollTop('tr_is_advance_receivedErr');
        }else if(tr_is_advance_received == 1 && tr_paid_amount == ''){
            $('#tr_paid_amountErr').text('Please enter paid amount');
            timeoutID('tr_paid_amountErr', 3000);
            scrollTop('tr_paid_amountErr');
        }else if(tr_is_advance_received == 1 && tr_advance_received_date == ''){
            $('#tr_advance_received_dateErr').text('Please select adavance received date');
            timeoutID('tr_advance_received_dateErr', 3000);
            scrollTop('tr_advance_received_dateErr');
        }else if(tr_address == ''){
            $('#tr_addressErr').text('Please enter trainee address');
            timeoutID('tr_addressErr', 3000);
            scrollTop('tr_addressErr');
        }else if(fileValidation === true){
            $('#tr_documentsErr').text('Accept only jpg, jpgeg, png file');
            timeoutID('tr_documentsErr', 3000);
            scrollTop('tr_documentsErr');
        }
        else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url:"{{ route('trainee.store', base64_encode($tr_real_id)) }}",
                method:"POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('trainee.list') }}");
                    }else{
                        sweetAlertError(res.message, 3000); 
                    }
                },
                error: function(r){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000); 
                }
            });
        }
    })
</script>
@endsection