@extends('layout.master');
@section('title', 'Operation Medicine - Add')
@section('breadcrumb-module', 'Operation Medicine')
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
                                <form method="POST" action="{{ route('operation-medicine.store') }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Medicine Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Medicine Name" name="om_name" id="om_name" />
                                                    <span class="text-danger" id="om_nameErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Company Name</label>
                                                    <input type="text" class="form-control" placeholder="Company Name" name="om_company_name" id="om_company_name" />
                                                    <span class="text-danger" id="om_company_nameErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="om_description" id="om_description" class="form-control" cols="30" rows="10"></textarea>
                                                    <span class="text-danger" id="om_company_nameErr"></span>
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
        let om_name = $('#om_name').val();
        let om_company_name = $('#om_company_name').val();
        let om_description = $('#om_description').val();
        if(om_name == ''){
            $('#om_nameErr').text('Please enter medicine name');
            timeoutID('om_nameErr', 3000);
            scrollTop('om_nameErr');
        }
        // else if(om_company_name == ''){
        //     $('#om_company_nameErr').text('Please enter company name');
        //     timeoutID('om_company_nameErr', 3000);
        //     scrollTop('om_company_nameErr');
        // }
        else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('operation-medicine.store') }}",
                method:"POST",
                data:{om_name:om_name, om_company_name:om_company_name, om_description:om_description},
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('operation-medicine.list') }}");
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