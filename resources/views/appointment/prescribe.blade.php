@extends('layout.master');
@section('title', 'Appointment - Prescription')
@section('breadcrumb-module', 'Prescription')
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
                                    <h3 class="card-title">Prescription</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('referred-doctor.store') }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <h4>Patient Detail</h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Patient Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $data->patientData->pa_name }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Patient ID <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $data->patientData->pa_id }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Patient Age <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $data->patientData->pa_age }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Address <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="{{ $data->patientData->pa_address }}" disabled>
                                                </div>
                                            </div>
                                            @php $pa_referred_by = ''; @endphp
                                            @if($data->patientData->pa_referred_by == 'doctor')
                                            @php $pa_referred_by = ucFirst($data->patientData->pa_referred_by).'-'.$data->patientData->pa_referred_doctor @endphp
                                            @endif
                                            @if($data->patientData->pa_referred_by == 'other')
                                            @php $pa_referred_by = ucFirst($data->patientData->pa_referred_text); @endphp
                                            @endif
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Referred By</label>
                                                    <input type="text" class="form-control" value="{{ $pa_referred_by }}" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <h4>Appointment Detail</h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Height</label>
                                                    <input type="text" class="form-control" value="{{ $data->ap_height }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Weight</label>
                                                    <input type="text" class="form-control" value="{{ $data->ap_weight }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>BP</label>
                                                    <input type="text" class="form-control" value="{{ $data->ap_bp }}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_follow_up_date">Follow Up Date</label>
                                                    <input type="date" class="form-control" name="ap_follow_up_date" id="ap_follow_up_date" value="{{ $data->ap_follow_up_date }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_surg_required">Surgery Required?</label>
                                                    <select class="form-control" name="ap_surg_required" id="ap_surg_required">
                                                        <option value="yes" {{ ($data->ap_surg_required == 'yes') ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ ($data->ap_surg_required == 'no') ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_is_foc">Is FOC?</label>
                                                    <select class="form-control" name="ap_is_foc" id="ap_is_foc">
                                                        <option value="yes" {{ ($data->ap_is_foc == 'yes') ? 'selected' : '' }}>Yes</option>
                                                        <option value="no" {{ ($data->ap_is_foc == 'no') ? 'selected' : '' }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_complaint">Complaints</label>
                                                    <textarea class="form-control" name="ap_complaint" id="ap_complaint" cols="30" rows="5">{{ $data->ap_complaint }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_other_detail">Other Details</label>
                                                    <textarea class="form-control" name="ap_other_detail" id="ap_other_detail" cols="30" rows="5">@php if($data->ap_other_detail != ''){
                                                        echo $data->ap_other_detail;
                                                        }else{
                                                            echo 'MENSTRUAL HISTORY
- LMP : asd
- CYCLES : REGULAR / IRREGULAR
- NO. OF DAYS : qwe
- LASTING FOR : zxc
- BLOOD FLOW : AVERAGE / NORMAL / HEAVY
- CLOTS : Yes / No
- DYSMENNORHAGIA : asdqwe

OBSTETRIC HISTORY : qwezxc

PERSONAL HISTORY : zxcasd

PAST HISTORY : asqw

FAMILY HISTORY : qwzx

EXAMINATION : zxas

INVESTIGATIONS
- USG : asdqw
- CT/MRI : qwezx

PROVISIONAL DIAGNOSIS : zxcas
';
                                                        } @endphp</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_any_advice">Any Advice</label>
                                                    <textarea class="form-control" name="ap_any_advice" id="ap_any_advice" cols="30" rows="5">{{ $data->ap_any_advice }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <h4>Medicine Detail</h4>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12"></div>
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
                                        <button type="submit" class="btn btn-primary mr-2" id="createBtn">Prescribe</button>
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

    $("form").submit(function(e) {
        e.preventDefault();
        let ap_follow_up_date = $('#ap_follow_up_date').val();
        let ap_surg_required = $('#ap_surg_required').val();
        let ap_is_foc = $('#ap_is_foc').val();
        let ap_complaint = $('#ap_complaint').val();
        let ap_other_detail = $('#ap_other_detail').val();
        let ap_any_advice = $('#ap_any_advice').val();
        $('#createBtn').addClass('spinner spinner-white spinner-right');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url:"{{ route('appointment.prescribe.store', base64_encode($data->ap_id)) }}",
            method:"POST",
            data:{ap_follow_up_date:ap_follow_up_date, ap_surg_required:ap_surg_required, ap_is_foc:ap_is_foc, ap_complaint:ap_complaint, ap_other_detail:ap_other_detail, ap_any_advice:ap_any_advice},
            success:function(res){
                $('#createBtn').removeClass('spinner spinner-white spinner-right');
                if(res.response === true){
                    sweetAlertSuccess(res.message, 3000, "{{ url()->previous() }}");
                }else{
                    sweetAlertError(res.message, 3000); 
                }
            },
            error: function(r){
                $('#createBtn').removeClass('spinner spinner-white spinner-right');
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000); 
            }
        });
    })
</script>
@endsection