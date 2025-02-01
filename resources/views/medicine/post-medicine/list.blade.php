@extends('layout.master');
@section('title', 'Post Operation Medicine - List')
@section('breadcrumb-module', 'Post Operation Medicine')
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
                                <form action="{{ route('post-medicine.list') }}">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label>Recommendation</label>
                                            <input type="text" class="form-control" placeholder="Recommendation" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('post-medicine.list') }}">Reset</a>
                                            @can('post-operative-medicine-create')
                                            <a class="btn btn-primary float-right" href="{{ route('post-medicine.create') }}">Add <i class="fa fa-plus"></i></a>
                                            @endcan
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
                                    <table class="table table-bordered scrollable_table_custom" id="generalMedicineTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Recommendation</th>
                                                <th>Added By</th>
                                                @can('post-operative-medicine-status')
                                                <th>Status</th>
                                                @endcan
                                                @can('post-operative-medicine-update')
                                                <th>Actions</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $post_medicine)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $post_medicine->recommendation }}</td>
                                                <td>{{ $post_medicine->AddedByData->person_name }}</td>
                                                @can('post-operative-medicine-status')
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($post_medicine->poom_id) }}" {{ ($post_medicine->poom_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                @endcan
                                                @can('post-operative-medicine-update')
                                                <td>
                                                    <a href="{{ route('post-medicine.edit', base64_encode($post_medicine->poom_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                </td>
                                                @endcan
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5">Record not found</td>
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
<script>
    setTimeout(() => {
        var table = $('#postMedicineTable').DataTable();
        table.destroy();
        $('#generalMedicineTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        poom_id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('post-medicine.status', '') }}" + "/" + poom_id,
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