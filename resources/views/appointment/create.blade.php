@extends('layout.master');
@section('title', 'Appointment - Add')
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
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">Add</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('referred-doctor.store') }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_pa_search">Patient Name <span class="text-danger">*</span></label>
                                                    <select name="pa_id" id="ap_pa_search" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(!empty($patientList))
                                                        @foreach($patientList as $list)
                                                        <option value="{{ $list->pa_id }}">{{ $list->pa_name }} - {{ $list->pa_id }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="pa_idErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_height">Height</label>
                                                    <input type="text" class="form-control" placeholder="Height" name="ap_height" id="ap_height" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_weight">Weight</label>
                                                    <input type="text" class="form-control" placeholder="Weight" name="ap_weight" id="ap_weight" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_bp">BP</label>
                                                    <input type="text" class="form-control" placeholder="BP" name="ap_bp" id="ap_bp" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_doctor_search">Appointment For Doctor <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="ap_doctor" id="ap_doctor_search">
                                                        <option value="">Select</option>
                                                        @if(!empty($doctors))
                                                        @foreach($doctors as $doctor)
                                                        <option value="{{$doctor['user_id'] }}">{{ $doctor['person_name'] }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="ap_doctorErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_date">Appointment Date <span class="text-danger">*</span></label>
                                                    <div class="input-group date">
                                                        <input type="text" class="form-control" placeholder="Appointment Date" name="ap_date" id="ap_date" value="{{ date('Y-m-d') }}" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <i class="la la-calendar-check-o"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <span class="text-danger" id="ap_dateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_book_via">Appointment Booked Via</label>
                                                    <input type="text" class="form-control" placeholder="Appointment Booked Via" name="ap_book_via" id="ap_book_via" />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_case_type">Case Type <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="ap_case_type" id="ap_case_type" onchange="changeFee(this.value)">
                                                        <option value="">Select</option>
                                                        @if(!empty($visitingFees))
                                                        @foreach($visitingFees as $fee)
                                                        <option value="{{ $fee->vf_case_type.'-'.$fee->vf_fees }}">{{ ucfirst($fee->vf_case_type) }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="ap_cate_typeErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_charge">Fees <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Fees" name="ap_charge" id="ap_charge" disabled />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_case_type">Workshop Attended? <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="ap_is_workshop" id="ap_is_workshop" onchange="changeIsWorkshop(this.value)">
                                                        <option value="no">No</option>
                                                        <option value="yes">Yes</option>
                                                    </select>
                                                    <span class="text-danger" id="ap_cate_typeErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_payment_mode">Mode of Payment</label>
                                                    <select class="form-control" name="ap_payment_mode" id="ap_payment_mode" onchange="changePaymnt(this.value)">
                                                        <option value="">Select</option>
                                                        @foreach(PaymentMode() as $paymentType)
                                                        <option value="{{ $paymentType['ap_payment_mode'] }}">{{ ucfirst($paymentType['ap_payment_mode']) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none" id="payment_detail_box">
                                                <div class="form-group">
                                                    <label for="ap_payment_detail">Payment Detail</label>
                                                    <input type="text" class="form-control" placeholder="Payment Detail" name="ap_payment_detail" id="ap_payment_detail" />
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
    function changeFee(val){
        let arr = val.split('-');
        //ap_charge
        $('#ap_charge').val(arr[1]);
    }

    function changePaymnt(val){
        $('#ap_payment_detail').val();
        if(val == 'cash'){
            $('#payment_detail_box').addClass('d-none');
            $('#payment_detail_box input').attr('placeholder', 'Cash');
        }else if(val == 'card'){
            $('#payment_detail_box').removeClass('d-none');
            $('#payment_detail_box label').text('Card Details');
            $('#payment_detail_box input').attr('placeholder', 'Card Details');
        }else if(val == 'mediclaim'){
            $('#payment_detail_box').removeClass('d-none');
            $('#payment_detail_box label').text('Mediclaim Company Name');
            $('#payment_detail_box input').attr('placeholder', 'Mediclaim Company Name');
        }else if(val == 'corporate'){
            $('#payment_detail_box').removeClass('d-none');
            $('#payment_detail_box label').text('Company Name / Other Details');
            $('#payment_detail_box input').attr('placeholder', 'Company Name / Other Details');
        }
    }

    function changeIsWorkshop(val){
        if(val == 'yes'){
            $('#ap_charge').prop('disabled', false);
        }else{
            $('#ap_charge').prop('disabled', true);
            let val = $('#ap_case_type :selected').val();
            let arr = val.split('-');
            $('#ap_charge').val(arr[1]);
        }
    }

    $("form").submit(function(e) {
        e.preventDefault();
        let pa_id = $('#ap_pa_search').val();
        let ap_height = $('#ap_height').val();
        let ap_weight = $('#ap_weight').val();
        let ap_bp = $('#ap_bp').val();
        let ap_doctor = $('#ap_doctor_search').val();
        let ap_date = $('#ap_date').val();
        let ap_book_via = $('#ap_book_via').val();
        let ap_case_type = $('#ap_case_type').val();
        let ap_charge = $('#ap_charge').val();
        let ap_is_workshop = $('#ap_is_workshop').val();
        let ap_payment_mode = $('#ap_payment_mode').val();
        let ap_payment_detail = $('#ap_payment_detail').val();
        if(pa_id == ''){
            $('#pa_idErr').text('Please select patient name');
            timeoutID('pa_idErr', 3000);
            scrollTop('pa_idErr');
        }else if(ap_doctor == ''){
            $('#ap_doctorErr').text('Please select doctor');
            timeoutID('ap_doctorErr', 3000);
            scrollTop('ap_doctorErr');
        }else if(ap_date == ''){
            $('#ap_dateErr').text('Please select date');
            timeoutID('ap_dateErr', 3000);
            scrollTop('ap_dateErr');
        }else if(ap_case_type == ''){
            $('#ap_cate_typeErr').text('Please select cate type');
            timeoutID('ap_cate_typeErr', 3000);
            scrollTop('ap_cate_typeErr');
        }else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url:"{{ route('appointment.store') }}",
                method:"POST",
                data:{pa_id:pa_id, ap_height:ap_height, ap_weight:ap_weight, ap_bp:ap_bp, ap_doctor:ap_doctor, ap_date:ap_date, ap_book_via:ap_book_via, ap_case_type:ap_case_type, ap_charge:ap_charge, ap_is_workshop:ap_is_workshop, ap_payment_mode:ap_payment_mode, ap_payment_detail:ap_payment_detail},
                success:function(res){console.log(res);
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('appointment.list') }}");
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