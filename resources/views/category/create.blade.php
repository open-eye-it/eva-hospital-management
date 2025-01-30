@extends('layout.master');
@section('title', 'User Category - Add')
@section('breadcrumb-module', 'User Category')
@section('page-content')
<!--begin::Row-->
<div class="row">
    <div class="col-lg-12 col-xxl-12">
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">

                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">Add</h3>
                        </div>
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('category.store') }}" id="createCatefgory">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Name <span class="text-danger">* (Role name can only contain small letters, numbers, and underscores.)</span></label>
                                            <input type="text" class="form-control" placeholder="Name" name="name" id="name" value="{{old('name')}}" />
                                            <span class="text-danger" id="nameErr"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Display Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Display Name" name="display_name" id="display_name" value="{{old('display_name')}}">
                                            <span class="text-danger" id="display_nameErr"></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">

                                            <label>Permission</label>
                                            <hr>
                                            <div class="permission_checkbox">
                                                @if(!$permission->isEmpty())

                                                @php $oldsection = $permission[0]->section; @endphp
                                                @foreach($permission as $key => $value)
                                                @php $section = $value->section; @endphp
                                                @if($section != $oldsection)
                                                <div class="clear_both"></div>
                                                <hr>
                                                @endif

                                                <label class="checkbox">
                                                    <input type="checkbox" value="{{ $value->name }}" id="permission_{{$key}}" name="permission[]" {{ (old('permission') != null && in_array($value->name, old('permission'))) ? 'checked' : ''; }}>
                                                    <span></span>{{ $value->display_name }}
                                                </label>


                                                @php $oldsection = $value->section; @endphp
                                                @endforeach

                                                @endif
                                            </div>
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
        let name = $('#name').val();
        let display_name = $('#display_name').val();
        let regex = /^[a-z0-9_]+$/;

        var permission = [];
        $(':checkbox:checked').each(function(i){
            permission[i] = $(this).val();
        });

        if(name == ''){
            $('#nameErr').text('Please enter name');
            timeoutID('nameErr', 3000);
            scrollTop('nameErr');
        }else if(!regex.test(name)){
            $('#nameErr').text('Allow only small letters, numbers and underscore');
            timeoutID('nameErr', 3000);
            scrollTop('nameErr');
        }else if(display_name == ''){
            $('#display_nameErr').text('Please enter name');
            timeoutID('display_nameErr', 3000);
            scrollTop('display_nameErr');
        }else{
            $('#createBtn').addClass('spinner spinner-white spinner-right');
            $('#createBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"{{ route('category.store') }}",
                method:"POST",
                data:{name:name,display_name:display_name,permission:permission},
                success:function(res){
                    $('#createBtn').removeClass('spinner spinner-white spinner-right');
                    $('#createBtn').attr('disabled', false);
                    if(res.response === true){
                        sweetAlertSuccess(res.message, 3000, "{{ route('category.list') }}");
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