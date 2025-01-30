@extends('layout.master');
@section('title', 'Visiting Fee - Create')
@section('breadcrumb-module', 'Visiting Fee')
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
                        <div class="col-md-6">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                <div class="card-header">
                                    <h3 class="card-title">Update</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('visiting_fee.update', base64_encode($data->vf_id)) }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Case Type <span class="text-danger">*</span></label>
                                            <select name="vf_case_type" id="vf_case_type" class="form-control" disabled>
                                                <option value="old" {{ ($data->vf_case_type == 'old') ? 'selected' : '' }}>OLD</option>
                                                <option value="new" {{ ($data->vf_case_type == 'new') ? 'selected' : '' }}>NEW</option>
                                                <option value="emergency" {{ ($data->vf_case_type == 'emergency') ? 'selected' : '' }}>EMERGENCY</option>
                                            </select>
                                            <span class="text-danger" id="fv_case_typeErr"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Fee <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Fees" name="vf_fees" id="vf_fees" value="{{ $data->vf_fees }}" />
                                            <span class="text-danger" id="vf_feesErr"></span>
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
                                        <button type="submit" class="btn btn-primary mr-2" id="createBtn">Update</button>
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
        let vf_case_type = $('#vf_case_type').val();
        let vf_fees = $('#vf_fees').val();
        if(vf_case_type == ''){
            $('#fv_case_typeErr').text('Please select case type');
            timeoutID('fv_case_typeErr', 3000);
            scrollTop('fv_case_typeErr');
        }else if(vf_fees == ''){
            $('#vf_feesErr').text('Please enter fees');
            timeoutID('vf_feesErr', 3000);
            scrollTop('vf_feesErr');
        }else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('visiting_fee.update', base64_encode($data->vf_id)) }}",
                method:"POST",
                data:{vf_case_type:vf_case_type, vf_fees:vf_fees},
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('visiting_fee.list') }}");
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