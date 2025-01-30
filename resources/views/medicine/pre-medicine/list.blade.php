@extends('layout.master');
@section('title', 'Pre Operation Medicine - List')
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
                            <div class="card card-custom gutter-b p-5">
                                <form action="{{ route('pre-medicine.list') }}">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <label>Search Recommendation</label>
                                            <input type="text" class="form-control" placeholder="Search Recommendation" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('pre-medicine.list') }}">Reset</a>
                                            @can('pre-operative-medicine-create')
                                            <a class="btn btn-primary float-right" href="{{ route('pre-medicine.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                                <th>Name</th>
                                                <th>Given or Not</th>
                                                <th>Description</th>
                                                <th>Added By</th>
                                                @can('pre-operative-medicine-status')
                                                <th>Status</th>
                                                @endcan
                                                @can('pre-operative-medicine-update')
                                                <th>Actions</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $pre_medicine)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $pre_medicine->recommendation }}</td>
                                                <td>{{ ($pre_medicine->given_or_not == 1) ? 'Yes' : 'No' }}</td>
                                                <td>{{ $pre_medicine->description }}</td>
                                                <td>{{ $pre_medicine->AddedByData->person_name }}</td>
                                                @can('pre-operative-medicine-status')
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($pre_medicine->pom_id) }}" {{ ($pre_medicine->pom_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                @endcan
                                                @can('pre-operative-medicine-update')
                                                <td>
                                                    <a href="{{ route('pre-medicine.edit', base64_encode($pre_medicine->pom_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
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
        var table = $('#generalMedicineTable').DataTable();
        table.destroy();
        $('#preMedicineTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        pom_id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('pre-medicine.status', '') }}" + "/" + pom_id,
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