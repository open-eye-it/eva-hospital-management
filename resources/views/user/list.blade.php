@extends('layout.master');
@section('title', 'User - List')
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
                            <div class="card card-custom gutter-b p-5">
                                <form action="{{ route('user.list') }}">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 form-group">
                                            <label>Name, Email, Person Name</label>
                                            <input type="text" class="form-control" placeholder="Name, Email, Person Name" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('user.list') }}">Reset</a>
                                            <a class="btn btn-primary float-right" href="{{ route('user.create') }}">Add <i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b">
                                <div class="card-header flex-wrap py-2">
                                    <div class="card-title">
                                        <h3 class="card-label">List
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered" id="userListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Person Name</th>
                                                <th>User Name</th>
                                                <th>Category</th>
                                                <th>Contact No</th>
                                                <th>Added By</th>
                                                @can('user-status')
                                                <th>Status</th>
                                                @endcan
                                                @if(auth()->user()->can('user-read') || auth()->user()->can('user-update'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $user)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $user->person_name }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ implode('|', $user->getRoleDisplayNames()->toArray()) }}</td>
                                                <td>{{ $user->contactno }}</td>
                                                <td>{{ $user->AddedByData->person_name }}</td>
                                                @can('user-status')
                                                <td>
                                                    @if($user->getRoleNames()[0] != 'admin')
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($user->user_id) }}" {{ ($user->user_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                    @endif
                                                </td>
                                                @endcan
                                                @if(auth()->user()->can('user-read') || auth()->user()->can('user-update'))
                                                <td>
                                                    @if($user->getRoleNames()[0] != 'admin')
                                                    @can('user-update')
                                                    <a href="{{ route('user.edit', base64_encode($user->user_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                    @endcan
                                                    @can('user-read')
                                                    <span id="fullView" data-id="{{ base64_encode($user->user_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                    @endcan
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="4">Record not found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <!--end: Datatable-->
                                    @if(!$list->isEmpty())
                                    {{ $list->withQueryString()->onEachSide(1)->links() }}
                                    @endif
                                </div>
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
<div class="modal fade" id="fullViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="viewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    // setTimeout(() => {
    //     var table = $('#userListTable').DataTable();
    //     table.destroy();
    //     $('#userListTable').DataTable({
    //         autoWidth: true,
    //         searching: false,
    //         paging: false,
    //         info: false
    //     });
    // }, 1000);

    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        user_id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('user.status', '') }}" + "/" + user_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    sweetAlertSuccess(res.message, 3000);
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    $('body').on('click', '#fullView', function(event) {
        let user_id = $(this).data('id');
        $.ajax({
            url: "{{ route('user.view', '') }}" + "/" + user_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data
                    let view = '<tr> \
                        <th>User Name</th> \
                        <td>' + data.name + '</td> \
                    </tr> \
                    <tr> \
                        <th>Email</th> \
                        <td>' + data.email + '</td> \
                    </tr> \
                    <tr> \
                        <th>Person Name</th> \
                        <td>' + data.person_name + '</td> \
                    </tr> \
                    <tr> \
                        <th>Contact No</th> \
                        <td>' + data.contactno + '</td> \
                    </tr> \
                    <tr> \
                        <th>Address</th> \
                        <td>' + data.address + '</td> \
                    </tr> \
                    <tr> \
                        <th>Added By</th> \
                        <td>' + data.added_by_user + '</td> \
                    </tr> \
                    <tr> \
                        <th>Updated By</th> \
                        <td>' + data.updated_by_user + '</td> \
                    </tr>';

                    $('#viewDetail').html(view);
                    $('#fullViewModal').modal('show');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    })
</script>
@endsection