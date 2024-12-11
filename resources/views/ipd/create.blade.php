@extends('layout.master');
@section('title', 'IPD - Add')
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
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">Add</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('ipd.store') }}" id="createCatefgory">
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
                                                        <option value="{{ $list->pa_id }}" {{ ($pa_id == $list->pa_id) ? 'selected' : '' }}>{{ $list->pa_name }} - {{ $list->pa_id }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="pa_idErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ap_doctor_search">Doctor <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="ipd_doctor" id="ap_doctor_search">
                                                        <option value="">Select</option>
                                                        @if(!empty($doctors))
                                                        @foreach($doctors as $doctor)
                                                        <option value="{{$doctor['user_id'] }}">{{ $doctor['person_name'] }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="ipd_doctorErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="rm_id">Room <span class="text-danger">*</span></label>
                                                    <select class="form-control" name="rm_id" id="rm_id_search">
                                                        <option value="">Select</option>
                                                        @if(!empty($roomList))
                                                        @foreach($roomList as $room)
                                                        <option value="{{$room->rm_id }}">{{ $room->rm_building.'-'.$room->rm_floor.'-'.$room->rm_ward.'-'.$room->rm_no }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="rm_idErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ipd_admit_date">Date of Admit <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control" placeholder="Date of Admit" name="ipd_admit_date" id="ipd_admit_date" onchange="changeAdmitDate(this.value)" />
                                                    <span class="text-danger" id="ipd_admit_dateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ipd_surgery_date">Date of Surgery</label>
                                                    <input type="date" class="form-control" placeholder="Date of Surgery" name="ipd_surgery_date" id="ipd_surgery_date" />
                                                    <span class="text-danger" id="ipd_surgery_dateErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ipd_surgery_text">Type of Surgery</label>
                                                    <input type="text" class="form-control" placeholder="Type of Surgery" name="ipd_surgery_text" id="ipd_surgery_text" />
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
        let pa_id = $('#ap_pa_search').val();
        let ipd_doctor = $('#ap_doctor_search').val();
        let rm_id = $('#rm_id_search').val();
        let ipd_admit_date = $('#ipd_admit_date').val();
        let ipd_surgery_date = $('#ipd_surgery_date').val();
        let ipd_surgery_text = $('#ipd_surgery_text').val();
        if(pa_id == ''){
            $('#pa_idErr').text('Please select patient name');
            timeoutID('pa_idErr', 3000);
            scrollTop('pa_idErr');
        }else if(ipd_doctor == ''){
            $('#ipd_doctorErr').text('Please select doctor');
            timeoutID('ipd_doctorErr', 3000);
            scrollTop('ipd_doctorErr');
        }else if(rm_id == ''){
            $('#rm_idErr').text('Please select room');
            timeoutID('rm_idErr', 3000);
            scrollTop('rm_idErr');
        }else if(ipd_admit_date == ''){
            $('#ipd_admit_dateErr').text('Please select admit date');
            timeoutID('ipd_admit_dateErr', 3000);
            scrollTop('ipd_admit_dateErr');
        }else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url:"{{ route('ipd.store') }}",
                method:"POST",
                data:{pa_id:pa_id, ipd_doctor:ipd_doctor, rm_id:rm_id, ipd_admit_date:ipd_admit_date, ipd_surgery_date:ipd_surgery_date, ipd_surgery_text:ipd_surgery_text},
                success:function(res){console.log(res);
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('ipd.list') }}");
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

    function changeAdmitDate(val){
        $("#ipd_surgery_date").val(val);
    }
</script>
@endsection