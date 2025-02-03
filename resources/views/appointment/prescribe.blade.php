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
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <strong>Patient ID: </strong>{{ $data->patientData->pa_name }}
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <strong>Patient Name: </strong>{{ $data->patientData->pa_id }}
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <strong>Age: </strong>{{ $data->patientData->pa_age }}
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-12">
                                                <strong>Adress: </strong>{{ $data->patientData->pa_address }}
                                            </div>
                                            @php $pa_referred_by = ''; @endphp
                                            @if($data->patientData->pa_referred_by == 'doctor')
                                            @php $pa_referred_by = ucFirst($data->patientData->pa_referred_by).'-'.$data->patientData->pa_referred_doctor @endphp
                                            @endif
                                            @if($data->patientData->pa_referred_by == 'other')
                                            @php $pa_referred_by = ucFirst($data->patientData->pa_referred_text); @endphp
                                            @endif
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <strong>Referred By: </strong>{{ $pa_referred_by }}
                                            </div>
                                        </div>
                                        <hr />
                                        <h4>Appointment Detail <button type="button" class="btn btn-primary" onclick="checkAllHeightWeightBP('{{ base64_encode($data->pa_id) }}')">Check Ht-Wt-BP</button></h4>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <strong>Height__cm: </strong>{{ $data->ap_height }}
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <strong>Weight__kg: </strong>{{ $data->ap_weight }}
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-12">
                                                <strong>BP(_/_)mmhg: </strong>{{ $data->ap_bp }}
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_complaint">Complaints</label>
                                                    <textarea class="form-control" name="ap_complaint" id="ap_complaint" cols="30" rows="3">{{ $data->ap_complaint }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_any_advice">Any Advice</label>
                                                    <textarea class="form-control" name="ap_any_advice" id="ap_any_advice" cols="30" rows="3">{{ $data->ap_any_advice }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_other_detail">Other Details</label>
                                                    <textarea class="form-control" name="ap_other_detail" id="ap_other_detail" cols="30" rows="5">@php if($data->ap_other_detail != ''){
                                                        echo $data->ap_other_detail;
                                                        }else{
                                                            echo 'MENSTRUAL HISTORY
- LMP
- CYCLES : REGULAR / IRREGULAR
- NO. OF DAYS
- LASTING FOR
- BLOOD FLOW : AVERAGE / NORMAL / HEAVY
- CLOTS : Yes / No
- DYSMENNORHAGIA

OBSTETRIC HISTORY

PERSONAL HISTORY

PAST HISTORY

FAMILY HISTORY

EXAMINATION

INVESTIGATIONS
- USG
- CT/MRI

PROVISIONAL DIAGNOSIS
';
                                                        } @endphp</textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="ap_follow_up_date">Follow Up Date</label>
                                                            <input type="date" class="form-control" name="ap_follow_up_date" id="ap_follow_up_date" value="{{ $data->ap_follow_up_date }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="ap_is_foc">Is FOC?</label>
                                                            <select class="form-control" name="ap_is_foc" id="ap_is_foc">
                                                                <option value="yes" {{ ($data->ap_is_foc == 'yes') ? 'selected' : '' }}>Yes</option>
                                                                <option value="no" {{ ($data->ap_is_foc == 'no') ? 'selected' : '' }}>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="form-group">
                                                            <label for="ap_surg_required">Surgery Required?</label>
                                                            <select class="form-control" name="ap_surg_required" id="ap_surg_required" onchange="changeSurgeryRequired(this.value)">
                                                                <option value="yes" {{ ($data->ap_surg_required == 'yes') ? 'selected' : '' }}>Yes</option>
                                                                <option value="no" {{ ($data->ap_surg_required == 'no') ? 'selected' : '' }}>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 {{ ($data->ap_surg_required != 'yes') ? 'd-none' : '' }}" id="surgeryDate">
                                                        <div class="form-group">
                                                            <label for="ap_surg_date">Surgery Date</label>
                                                            <input type="date" class="form-control" name="ap_surg_date" id="ap_surg_date" value="{{ $data->ap_surg_date }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 {{ ($data->ap_surg_required != 'yes') ? 'd-none' : '' }}" id="surgeryType">
                                                        <div class="form-group">
                                                            <label for="ap_surg_type">Type of Surgery</label>
                                                            <input type="text" class="form-control" name="ap_surg_type" id="ap_surg_type" value="{{ $data->ap_surg_type }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <h4>Medicine Detail</h4>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group search_bar">
                                                    <label>Medicine</label>
                                                    <input type="text" id="gm_id" name="gm_id" placeholder="Medicine" class="form-control" onkeyup="searchGeneralMedicine(this.value)" />
                                                    <input type="hidden" name="gm_id_original" id="gm_id_original" value="">
                                                    <ul id="search_medicine_list" class="d-none" style="z-index:999;"></ul>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="gm_prescribe_id">Medicine <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="gm_id" id="gm_prescribe_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($generalMedicines))
                                                        @foreach($generalMedicines as $gmedicine)
                                                        <option value="{{ $gmedicine->gm_id }}">{{ $gmedicine->gm_name }} ({{ $gmedicine->gm_company_name }})</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="gm_idErr"></span>
                                                </div>
                                            </div> -->
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="am_days">No of Days <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" value="" name="am_days" id="am_days">
                                                    <span class="text-danger" id="am_daysErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="am_timing">Timing <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" value="" name="am_timing" id="am_timing">
                                                    <span class="text-danger" id="am_timingErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="ap_morning">Morning</label>
                                                    <select class="form-control" name="am_morning" id="am_morning">
                                                        <option value="no">No</option>
                                                        <option value="yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="ap_afternoon">Afternoon</label>
                                                    <select class="form-control" name="am_afternoon" id="am_afternoon">
                                                        <option value="no">No</option>
                                                        <option value="yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="ap_evening">Evening</label>
                                                    <select class="form-control" name="am_evening" id="am_evening">
                                                        <option value="no">No</option>
                                                        <option value="yes">Yes</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 pb-4">
                                                <button type="button" class="btn btn-primary mr-2" id="addBtn" onclick="addMedicine('{{ base64_encode($data->ap_id) }}')">Add</button>
                                            </div>
                                            <div class="col-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Medicine Name</th>
                                                            <th>No. of Days</th>
                                                            <th>Timing</th>
                                                            <th>Morning</th>
                                                            <th>Afternoon</th>
                                                            <th>Evening</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="medicine_detail">
                                                        @if(!empty($prescribeMedicineList))
                                                        @foreach($prescribeMedicineList as $prescribeMedicine)
                                                        <tr id="table_row_{{ $prescribeMedicine->am_id }}">
                                                            <td>{{ $prescribeMedicine->medicineData->gm_name.' ('.$prescribeMedicine->medicineData->gm_company_name.')' }}</td>
                                                            <td>{{ $prescribeMedicine->am_days }}</td>
                                                            <td>{{ $prescribeMedicine->am_timing }}</td>
                                                            <td>{{ $prescribeMedicine->am_morning }}</td>
                                                            <td>{{ $prescribeMedicine->am_afternoon }}</td>
                                                            <td>{{ $prescribeMedicine->am_evening }}</td>
                                                            <td>
                                                                <i onclick="removeMedicine('{{ $prescribeMedicine->am_id }}')" title="Remove" class="icon-2x la la-trash cursor_pointer"></i>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
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
<div class="modal fade" id="patientHeightWeightBP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">All Height Weight BP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>BP</th>
                        </tr>
                    </thead>
                    <tbody id="allHeightWeightBP">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--end::Row-->
<script>
    function searchGeneralMedicine(text){
        if(text != ''){
            $.ajax({
                url:"{{ route('appointment.prescribe-medicine.search.list', '') }}" + '/' + btoa(text),
                method:"get",
                success:function(res){
                    if(res.response === true){
                        let data = res.data;
                        if(data.length == 0){
                            $('#gm_id_original').val('');
                            $('#search_medicine_list').addClass('d-none');
                        }else{
                            let option = '';
                            data.map((val) => option += '<li onclick="selectGeneralMedicineName(`'+val.gm_name+'`, `'+val.gm_id+'`)">'+val.gm_name+'</li>');
                            $('#search_medicine_list').html(option);
                            $('#search_medicine_list').removeClass('d-none');
                        }
                    }else{
                        sweetAlertError(res.message, 3000);
                        $('#search_medicine_list').addClass('d-none');
                    }
                },
                error: function(r){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                    $('#search_medicine_list').addClass('d-none');
                }
            });
        }else{
            $('#search_medicine_list').html('');
            $('#search_medicine_list').addClass('d-none');
        }
    }

    function selectGeneralMedicineName(text, gm_id){
        $('#gm_id').val(text);
        $('#gm_id_original').val(gm_id);
        $('#search_medicine_list').html('');
        $('#search_medicine_list').addClass('d-none');
    }

    function changeFee(val){
        let arr = val.split('-');
        //ap_charge
        $('#ap_charge').val(arr[1]);
    }

    function changeSurgeryRequired(ap_surg_required){
        if(ap_surg_required == 'yes'){
            $('#surgeryDate').removeClass('d-none');
            $('#surgeryType').removeClass('d-none');
            $('#ap_surg_date').val('{{ $data->ap_surg_date }}');
            $('#ap_surg_type').val('{{ $data->ap_surg_type }}');
        }else{
            $('#surgeryDate').addClass('d-none');
            $('#surgeryType').addClass('d-none');
            $('#ap_surg_date').val('');
            $('#ap_surg_type').val('');
        }
    }

    $("form").submit(function(e) {
        e.preventDefault();
        let ap_follow_up_date = $('#ap_follow_up_date').val();
        let ap_surg_required = $('#ap_surg_required').val();
        let ap_surg_date = $('#ap_surg_date').val();
        let ap_surg_type = $('#ap_surg_type').val();
        let ap_is_foc = $('#ap_is_foc').val();
        let ap_complaint = $('#ap_complaint').val();
        let ap_other_detail = $('#ap_other_detail').val();
        let ap_any_advice = $('#ap_any_advice').val();
        $('#createBtn').addClass('spinner spinner-white spinner-right');
        $('#createBtn').attr('disabled', true);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url:"{{ route('appointment.prescribe.store', base64_encode($data->ap_id)) }}",
            method:"POST",
            data:{ap_follow_up_date:ap_follow_up_date, ap_surg_required:ap_surg_required,ap_surg_date:ap_surg_date,ap_surg_type:ap_surg_type, ap_is_foc:ap_is_foc, ap_complaint:ap_complaint, ap_other_detail:ap_other_detail, ap_any_advice:ap_any_advice},
            success:function(res){
                $('#createBtn').removeClass('spinner spinner-white spinner-right');
                $('#createBtn').attr('disabled', false);
                if(res.response === true){
                    //sweetAlertSuccess(res.message, 3000, "{{ route('appointment.list') }}");
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
    })

    /* Medicine Add */
    function addMedicine(ap_id){
        let gm_id = $('#gm_id').val();
        let gm_id_original = $('#gm_id_original').val();
        let am_days = $('#am_days').val();
        let am_timing = $('#am_timing').val();
        let am_morning = $('#am_morning').val();
        let am_afternoon = $('#am_afternoon').val();
        let am_evening = $('#am_evening').val();
        if(gm_id == ''){
            $('#gm_idErr').text('Please select medicine');
            timeoutID('gm_idErr', 3000);
            scrollTop('gm_idErr');
        }else if(am_days == ''){
            $('#am_daysErr').text('Please fillup days');
            timeoutID('am_daysErr', 3000);
            scrollTop('am_daysErr');
        }else if(am_timing == ''){
            $('#am_timingErr').text('Please fillup timing');
            timeoutID('am_timingErr', 3000);
            scrollTop('am_timingErr');
        }else{
            $('#addBtn').addClass('spinner spinner-white spinner-right');
            $('#addBtn').attr('disabled', true);
            let data = 'ap_id='+ap_id+'&gm_id='+gm_id+'&gm_id_original='+gm_id_original+'&am_days='+am_days+'&am_timing='+am_timing+'&am_morning='+am_morning+'&am_afternoon='+am_afternoon+'&am_evening='+am_evening;
            $.ajax({
                url:"{{ route('appointment.medicine.store') }}"+'?'+data,
                method:"get",
                success:function(res){
                    $('#addBtn').removeClass('spinner spinner-white spinner-right');
                    $('#addBtn').attr('disabled', false);
                    if(res.response === true){
                        let data = res.data;
                        
                        let tableData = '<tr id="table_row_'+data.am_id+'"> \
                        <td>'+data.medicine_name+'</td> \
                        <td>'+data.am_days+'</td> \
                        <td>'+data.am_timing+'</td> \
                        <td>'+data.am_morning+'</td> \
                        <td>'+data.am_afternoon+'</td> \
                        <td>'+data.am_evening+'</td> \
                        <td><i onclick="removeMedicine('+data.am_id+')" title="Remove" class="icon-2x la la-trash cursor_pointer"></i></td> \
                        </tr>';

                        $('#gm_id').val('');
                        $('#am_days').val('');
                        $('#am_timing').val('');
                        $('#am_morning').val('no');
                        $('#am_afternoon').val('no');
                        $('#am_evening').val('no');

                        $('#medicine_detail').prepend(tableData);
                        sweetAlertSuccess(res.message, 2000);
                    }else{
                        sweetAlertError(res.message, 2000); 
                    }
                },
                error:function(r){
                    $('#addBtn').removeClass('spinner spinner-white spinner-right');
                    $('#addBtn').attr('disabled', false);
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 2000); 
                }
            });
        }
    }

    /* Medicine Remove */
    function removeMedicine(am_id){
        $.ajax({
            url:"{{ route('appointment.medicine.remove', '') }}"+'/'+btoa(am_id),
            method:"get",
            success:function(res){
                if(res.response === true){
                    $('#table_row_'+am_id).remove();
                    sweetAlertSuccess(res.message, 2000);
                }else{
                    sweetAlertError(res.message, 2000); 
                }
            },
            error:function(r){
                let res = r.responseJSON;
                sweetAlertError(res.message, 2000); 
            }
        });
    }

    /* Get All height weight bp of current patient */
    function checkAllHeightWeightBP(pa_id){
        $.ajax({
            url:"{{ route('appointment.all_poointment', '') }}"+'/'+pa_id,
            method:"GET",
            success:function(res){
                if(res.response === true){
                    let data = res.data;
                    $('#allHeightWeightBP').html(data);
                    $('#patientHeightWeightBP').modal('show');
                }else{
                    sweetAlertError(res.message, 2000); 
                }
            },
            error:function(r){
                let res = r.responseJSON;
                sweetAlertError(res.message, 2000);
            }
        });
    }
</script>
@endsection