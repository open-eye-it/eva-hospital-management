@extends('layout.master');
@section('title', 'User - Create')
@section('breadcrumb-module', 'User')
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
                                    <h3 class="card-title">Create</h3>
                                </div>
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('user.update', base64_encode($data->user_id)) }}" id="createCatefgory">
                                    <meta name="csrf-token" content="{{ csrf_token() }}">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    @php $userRoles = $data->getRoleNames()->toArray(); @endphp
                                                    <label>Category <span class="text-danger">*</span></label>
                                                    <select name="cat_id" id="cat_id" class="form-control">
                                                        <option value="">-Select-</option>
                                                        @if(!empty($roleData))
                                                        @foreach($roleData as $role_id => $role_name)
                                                        <option value="{{ $role_id }}" {{ (in_array($role_id, $userRoles)) ? 'selected' : '' }}>{{ $role_name }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                    <span class="text-danger" id="cat_idErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>User Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Username" name="uname" id="uname" value="{{ $data->name }}" />
                                                    <span class="text-danger" id="unameErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Email" name="email" id="email" value="{{ $data->email }}" />
                                                    <span class="text-danger" id="emailErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Password <span class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" placeholder="Password" name="password" id="password" disabled />
                                                    <span class="text-danger" id="passwordErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Person Name <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" placeholder="Person Name" name="person_name" id="person_name" value="{{ $data->person_name }}" />
                                                    <span class="text-danger" id="person_nameErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Contact No <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" placeholder="Contact No" name="contactno" id="contactno" value="{{ $data->contactno }}" />
                                                    <span class="text-danger" id="contactnoErr"></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <textarea name="address" id="address" class="form-control" cols="30" rows="10">{{ $data->address }}</textarea>
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
        let cat_id = $('#cat_id').val();
        let uname = $('#uname').val();
        let email = $('#email').val();
        let person_name = $('#person_name').val();
        let contactno = $('#contactno').val();
        let address = $('#address').val();
        var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i
        if(cat_id == ''){
            $('#cat_idErr').text('Please select category');
            timeoutID('cat_idErr', 3000);
            scrollTop('cat_idErr');
        }else if(uname == ''){
            $('#unameErr').text('Please enter user name');
            timeoutID('unameErr', 3000);
            scrollTop('unameErr');
        }else if(email == ''){
            $('#emailErr').text('Please enter email');
            timeoutID('emailErr', 3000);
            scrollTop('emailErr');
        }else if(!pattern.test(email)){
            $('#emailErr').text('Please enter valid email');
            timeoutID('emailErr', 3000);
            scrollTop('emailErr');
        }else if(person_name == ''){
            $('#person_nameErr').text('Please enter person name');
            timeoutID('person_nameErr', 3000);
            scrollTop('person_nameErr');
        }else if(contactno == ''){
            $('#contactnoErr').text('Please enter contact no');
            timeoutID('contactnoErr', 3000);
            scrollTop('contactnoErr');
        }else if(contactno.length < 10 || contactno.length > 10){
            $('#contactnoErr').text('Enter only 10 digit');
            timeoutID('contactnoErr', 3000);
            scrollTop('contactnoErr');
        }else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('user.update', base64_encode($data->user_id)) }}",
                method:"POST",
                data:{cat_id:cat_id, uname:uname, email:email, person_name:person_name, contactno:contactno, address:address},
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('user.list') }}");
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