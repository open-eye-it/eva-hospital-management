@extends('layout.master');
@section('title', 'Room - Add')
@section('breadcrumb-module', 'Room')
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
                                <form method="POST" action="{{ route('room.store') }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Building <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Building" name="rm_building" id="rm_building" value="A" disabled />
                                                    <span class="text-danger" id="rm_buildingErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Floor <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Floor" name="rm_floor" id="rm_floor" />
                                                    <span class="text-danger" id="rm_floorErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Ward <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Ward" name="rm_ward" id="rm_ward" />
                                                    <span class="text-danger" id="rm_wardErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Room Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Room No" name="rm_no" id="rm_no" />
                                                    <span class="text-danger" id="rm_noErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Room Charge <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" placeholder="Room Charge" name="rm_charge" id="rm_charge" />
                                                    <span class="text-danger" id="rm_chargeErr"></span>
                                                </div>
                                            </div>
                                            <!-- <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Is Busy <span class="text-danger">*</span></label>
                                                    <select name="rm_busy" id="rm_busy" class="form-control">
                                                        <option value="">-Select-</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>
                                                    <span class="text-danger" id="rm_busyErr"></span>
                                                </div>
                                            </div> -->
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
        let rm_building = $('#rm_building').val();
        let rm_floor = $('#rm_floor').val();
        let rm_ward = $('#rm_ward').val();
        let rm_no = $('#rm_no').val();
        let rm_charge = $('#rm_charge').val();
        // let rm_busy = $('#rm_busy').val();
        if(rm_building == ''){
            $('#rm_buildingErr').text('Please enter building no');
            timeoutID('rm_buildingErr', 3000);
            scrollTop('rm_buildingErr');
        }else if(rm_floor == ''){
            $('#rm_floorErr').text('Please enter floor no');
            timeoutID('rm_floorErr', 3000);
            scrollTop('rm_floorErr');
        }else if(rm_ward == ''){
            $('#rm_wardErr').text('Please enter ward no');
            timeoutID('rm_wardErr', 3000);
            scrollTop('rm_wardErr');
        }else if(rm_no == ''){
            $('#rm_noErr').text('Please enter room no');
            timeoutID('rm_noErr', 3000);
            scrollTop('rm_noErr');
        }else if(rm_charge == ''){
            $('#rm_chargeErr').text('Please enter room charge');
            timeoutID('rm_chargeErr', 3000);
            scrollTop('rm_chargeErr');
        }
        // else if(rm_busy == ''){
        //     $('#rm_busyErr').text('Please select room is busy or not');
        //     timeoutID('rm_busyErr', 3000);
        //     scrollTop('rm_busyErr');
        // }
        else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('room.store') }}",
                method:"POST",
                data:{rm_building:rm_building, rm_floor:rm_floor, rm_ward:rm_ward, rm_no:rm_no, rm_charge:rm_charge},
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('room.list') }}");
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