@extends('layout.master');
@section('title', 'Pre Operation Medicine - Add')
@section('breadcrumb-module', 'Pre Operation Medicine')
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
                                <form method="POST" action="{{ route('pre-medicine.store') }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Medicine/Recommendation <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Medicine/Recommendation" name="recommendation" id="recommendation" />
                                                    <span class="text-danger" id="recommendationErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Given or Not?</label>
                                                    <!-- <input type="text" class="form-control" placeholder="Company Name" name="gm_company_name" id="gm_company_name" /> -->
                                                    <input type="checkbox" id="given_or_not" name="given_or_not" class="form-control checkbox">
                                                    <span class="text-danger" id="given_or_notErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                                                    <span class="text-danger" id="descriptionErr"></span>
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
        let recommendation = $('#recommendation').val();
        let given_or_not = 0;
        if($("#given_or_not").prop('checked') == true){
            given_or_not = 1;
        }
        let description = $('#description').val();
        if(recommendation == ''){
            $('#recommendationErr').text('Please enter medicine/recommendation');
            timeoutID('recommendationErr', 3000);
            scrollTop('recommendationErr');
        }
        else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('pre-medicine.store') }}",
                method:"POST",
                data:{recommendation:recommendation, given_or_not:given_or_not, description:description},
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('pre-medicine.list') }}");
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