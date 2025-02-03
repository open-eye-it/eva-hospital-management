@extends('layout.master');
@section('title', 'Appointment - Update')
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
                                    <h3 class="card-title">Update</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('appointment.update', base64_encode($data->ap_id)) }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Patient Name <span class="text-danger">*</span></label>
                                                    <select name="pa_id" id="ap_pa_search" class="form-control">
                                                        <option value="">Select</option>
                                                        @if(!empty($patientList))
                                                        @foreach($patientList as $list)
                                                        <option value="{{ $list->pa_id }}" {{ ($list->pa_id == $data->pa_id) ? 'selected' : '' }}>{{ $list->pa_name }} - {{ $list->pa_id }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="pa_idErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>Height__cm</label>
                                                    <input type="text" class="form-control" placeholder="Height__cm" name="ap_height" id="ap_height" value="{{ $data->ap_height }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>Weight__kg</label>
                                                    <input type="text" class="form-control" placeholder="Weight__kg" name="ap_weight" id="ap_weight" value="{{ $data->ap_weight }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label>BP(_/_)mmhg</label>
                                                    <input type="text" class="form-control" placeholder="BP(_/_)mmhg" name="ap_bp" id="ap_bp" value="{{ $data->ap_bp }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Appointment For Doctor <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="ap_doctor" id="ap_doctor_search">
                                                        <option value="">Select</option>
                                                        @if(!empty($doctors))
                                                        @foreach($doctors as $doctor)
                                                        <option value="{{$doctor['user_id'] }}" {{ ($doctor['user_id'] == $data->ap_doctor) ? 'selected' : '' }}>{{ $doctor['person_name'] }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="ap_doctorErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Appointment Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" placeholder="Appointment Date" name="ap_date" id="ap_date1" value="{{ $data->ap_date }}" />
                                                    <span class="text-danger" id="ap_dateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Appointment Booked Via</label>
                                                    <input type="text" class="form-control" placeholder="Appointment Booked Via" name="ap_book_via" id="ap_book_via" value="{{ $data->ap_book_via }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="ap_case_type">Workshop Attended? <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="ap_is_workshop" id="ap_is_workshop" onchange="changeIsWorkshop(this.value)">
                                                        <option value="no" {{ ($data->ap_is_workshop == 'no') ? 'selected' : '' }}>No</option>
                                                        <option value="yes" {{ ($data->ap_is_workshop == 'yes') ? 'selected' : '' }}>Yes</option>
                                                    </select>
                                                    <span class="text-danger" id="ap_cate_typeErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Case Type <span class="text-danger">*</span> {{ $data->ap_case_type }}</label>
                                                    <select class="form-control" name="ap_case_type" id="ap_case_type" onchange="changeFee(this.value)">
                                                        <option value="">Select</option>
                                                        @if(!empty($visitingFees))
                                                        @foreach($visitingFees as $fee)
                                                        <option value="{{ $fee->vf_case_type.'-'.$fee->vf_fees }}" {{ ($fee->vf_case_type == $data->ap_case_type) ? 'selected' : '' }}>{{ ucfirst($fee->vf_case_type) }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="ap_cate_typeErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label>Fees <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Fees" name="ap_charge" id="ap_charge" value="{{ $data->ap_charge }}" {{ ($data->ap_is_workshop == 'no') ? 'disabled' : '' }} />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="ap_case_type">Fee Status</label>
                                                    <select class="form-control" name="ap_charge_status" id="ap_charge_status">
                                                        <option value="pending" {{ ($data->ap_charge_status == 'pending') ? 'selected' : '' }}>Pending</option>
                                                        <option value="paid" {{ ($data->ap_charge_status == 'paid') ? 'selected' : '' }}>Paid</option>
                                                    </select>
                                                    <span class="text-danger" id="ap_charge_statusErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="ap_payment_mode">Mode of Payment <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="ap_payment_mode" id="ap_payment_mode" onchange="changePaymnt(this.value)">
                                                        <option value="">Select</option>
                                                        @foreach(PaymentMode() as $paymentType)
                                                        <option value="{{ $paymentType['ap_payment_mode'] }}" {{ ($paymentType['ap_payment_mode'] == $data->ap_payment_mode) ? 'selected' : '' }}>{{ ucfirst($paymentType['ap_payment_mode']) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 {{ ($data->ap_payment_mode == 'cash' ? 'd-none' : '') }}" id="payment_detail_box">
                                                <div class="form-group">
                                                    <label for="ap_payment_detail">Payment Detail <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Payment Detail" name="ap_payment_detail" id="ap_payment_detail" value="{{ $data->ap_payment_detail }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Last Menstrual Period</label>
                                                    <input type="text" class="form-control" placeholder="Last Menstrual Period" name="pa_last_monestrual_period" id="pa_last_monestrual_period" value="{{ $data->pa_last_monestrual_period }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Number of Pregnancy</label>
                                                    <input type="text" class="form-control" placeholder="Number of Pregnancy" name="pa_pregnancy_no" id="pa_pregnancy_no" value="{{ $data->pa_pregnancy_no }}" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Number of Miscarriages</label>
                                                    <input type="text" class="form-control" placeholder="Number of Miscarriages" name="pa_miscarriages_no" id="pa_miscarriages_no" value="{{ $data->pa_miscarriages_no }}" />
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Number of Abortion</label>
                                                    <input type="text" class="form-control" placeholder="Number of Abortion" name="pa_abortion_no" id="pa_abortion_no" />
                                                </div>
                                            </div> -->
                                            <div class="col-lg-3 col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Number of Living Children</label>
                                                    <input type="text" class="form-control" placeholder="Number of Living Children" name="pa_children_no" id="pa_children_no" value="{{ $data->pa_children_no }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 d-none">
                                                <h4>Do you consume any of below?</h4>
                                                <hr class="mt-1 mb-4">
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Tobacco</label>
                                                    <select name="pa_tobacco" id="pa_tobacco" class="form-control">
                                                        <option value="">-Select</option>
                                                        <option value="no" {{ ($data->pa_tobacco == 'no') ? 'selected' : '' }}>No</option>
                                                        <option value="occational" {{ ($data->pa_tobacco == 'occational') ? 'selected' : '' }}>Occational</option>
                                                        <option value="regular" {{ ($data->pa_tobacco == 'regular') ? 'selected' : '' }}>Regular</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Smoking</label>
                                                    <select name="pa_smoking" id="pa_smoking" class="form-control">
                                                        <option value="">-Select</option>
                                                        <option value="no" {{ ($data->pa_smoking == 'no') ? 'selected' : '' }}>No</option>
                                                        <option value="occational" {{ ($data->pa_smoking == 'occational') ? 'selected' : '' }}>Occational</option>
                                                        <option value="regular" {{ ($data->pa_smoking == 'regular') ? 'selected' : '' }}>Regular</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Alcohol</label>
                                                    <select name="pa_alcohol" id="pa_alcohol" class="form-control">
                                                        <option value="">-Select</option>
                                                        <option value="no" {{ ($data->pa_alcohol == 'no') ? 'selected' : '' }}>No</option>
                                                        <option value="occational" {{ ($data->pa_alcohol == 'occational') ? 'selected' : '' }}>Occational</option>
                                                        <option value="regular" {{ ($data->pa_alcohol == 'regular') ? 'selected' : '' }}>Regular</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Any medical or surgical history?</label>
                                                    <textarea name="pa_medical_history" id="pa_medical_history" class="form-control" cols="30" rows="5">{{ $data->pa_medical_history }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 d-none">
                                                <div class="form-group">
                                                    <label>Family member had any medical or surgical history?</label>
                                                    <textarea name="pa_family_medical_history" id="pa_family_medical_history" class="form-control" cols="30" rows="5">{{ $data->pa_family_medical_history }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary mr-2" id="createBtn">Update</button>
                                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
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
                                    <!-- <div class="card-footer">
                                        <button type="submit" class="btn btn-primary mr-2" id="createBtn">Update</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                                    </div> -->
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

        if(arr[0] == 'foc' || arr[0] == 'follow up'){
            $('#ap_charge_status').val('paid');
            $('#ap_charge_status').prop('disabled', true);
            $('#ap_payment_mode').val('cash');
            $('#ap_payment_mode').prop('disabled', true);
        }else{
            $('#ap_charge_status').val('pending');
            $('#ap_charge_status').prop('disabled', false);
            $('#ap_payment_mode').val('');
            $('#ap_payment_mode').prop('disabled', false);
        }
    }

    function changePaymnt(val){
        $('#ap_payment_detail').val();
        $('#ap_payment_detail').val('');
        if(val == 'cash'){
            $('#payment_detail_box').addClass('d-none');
            $('#payment_detail_box input').attr('placeholder', 'Cash');
        }else if(val == 'card'){
            $('#payment_detail_box').removeClass('d-none');
            $('#payment_detail_box label').text('Card Details');
            $('#payment_detail_box input').attr('placeholder', 'Card Details');
        }else if(val == 'upi'){
            $('#payment_detail_box').removeClass('d-none');
            $('#payment_detail_box label').text('Upi Details');
            $('#payment_detail_box input').attr('placeholder', 'Upi Details');
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
            $('#ap_charge').val('{{ $data->ap_charge }}');
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
        let ap_date = $('#ap_date1').val();
        let ap_book_via = $('#ap_book_via').val();
        let ap_case_type = $('#ap_case_type').val();
        let ap_charge = $('#ap_charge').val();
        let ap_charge_status = $('#ap_charge_status').val();
        let ap_is_workshop = $('#ap_is_workshop').val();
        let ap_payment_mode = $('#ap_payment_mode').val();
        let ap_payment_detail = $('#ap_payment_detail').val();
        let pa_last_monestrual_period = $('#pa_last_monestrual_period').val();
        let pa_pregnancy_no = $('#pa_pregnancy_no').val();
        let pa_miscarriages_no = $('#pa_miscarriages_no').val();
        //let pa_abortion_no = $('#pa_abortion_no').val();
        let pa_children_no = $('#pa_children_no').val();
        let pa_tobacco = $('#pa_tobacco').val();
        let pa_smoking = $('#pa_smoking').val();
        let pa_alcohol = $('#pa_alcohol').val();
        let pa_medical_history = $('#pa_medical_history').val();
        let pa_family_medical_history = $('#pa_family_medical_history').val();
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
            $('#createBtn').attr('disabled', false);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url:"{{ route('appointment.update', base64_encode($data->ap_id)) }}",
                method:"POST",
                data:{
                    pa_id:pa_id, 
                    ap_height:ap_height, 
                    ap_weight:ap_weight, 
                    ap_bp:ap_bp, 
                    ap_doctor:ap_doctor, 
                    ap_date:ap_date, 
                    ap_book_via:ap_book_via, 
                    ap_case_type:ap_case_type, 
                    ap_charge:ap_charge, 
                    ap_charge_status:ap_charge_status, 
                    ap_is_workshop:ap_is_workshop, 
                    ap_payment_mode:ap_payment_mode, 
                    ap_payment_detail:ap_payment_detail,
                    pa_last_monestrual_period:pa_last_monestrual_period,
                    pa_pregnancy_no: pa_pregnancy_no,
                    pa_miscarriages_no: pa_miscarriages_no,
                    //pa_abortion_no: pa_abortion_no,
                    pa_children_no: pa_children_no,
                    pa_tobacco: pa_tobacco,
                    pa_smoking: pa_smoking,
                    pa_alcohol: pa_alcohol,
                    pa_medical_history: pa_medical_history,
                    pa_family_medical_history: pa_family_medical_history
                },
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        // sweetAlertSuccess(res.message, 3000, "{{ route('appointment.list') }}");
                        let previous_url = "{{ Request::session()->previousUrl() }}";
                        previous_url = previous_url.replaceAll('amp;', '');
                        previous_url = previous_url.replaceAll('%20-%20', '+-+');
                        sweetAlertSuccess(res.message, 3000, previous_url);
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
@section('custom-script')
<script>
    // $("#ap_bp").inputmask('(_/_)', {
    //     numericInput: true
    // });
    $('#ap_bp').mask('(000/000)', {
        placeholder: "(_/_)"
    });

    $("#ap_weight").keypress(function (e) {
        if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
    });
</script>
@endsection