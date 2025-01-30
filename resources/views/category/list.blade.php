@extends('layout.master');
@section('title', 'User Category - List')
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
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-custom gutter-b">
                                <form action="{{ route('category.list') }}">
                                    <div class="row p-5">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <input type="text" class="form-control" placeholder="Search Text" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('category.list') }}">Reset</a>
                                            <a class="btn btn-primary float-right" href="{{ route('category.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                    <table class="table table-bordered scrollable_table_custom" id="categoryListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Display Name</th>
                                                <th>Name</th>
                                                @can('category-status')
                                                <th>Status</th>
                                                @endcan
                                                @can('category-update')
                                                <th>Actions</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$roles->isEmpty())
                                            @foreach($roles as $key => $role)
                                            <tr>
                                                <td>{{ $roles->firstItem() + $key }}</td>
                                                <td>{{ $role->display_name }}</td>
                                                <td>{{ $role->name }}</td>
                                                @can('category-status')
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($role->id) }}" {{ ($role->role_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                @endcan
                                                @can('category-update')
                                                <td>
                                                    <a href="{{ route('category.edit', base64_encode($role->id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                </td>
                                                @endcan
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
                                    @if(!$roles->isEmpty())
                                    {{ $roles->withQueryString()->onEachSide(1)->links() }}
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
<script>
    setTimeout(() => {
        var table = $('#categoryListTable').DataTable();
        table.destroy();
        $('#categoryListTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('category.status', '') }}" + "/" + id,
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
</script>
@endsection