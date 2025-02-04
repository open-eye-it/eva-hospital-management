@extends('layout.master');
@section('title', 'Operation Medicine - List')
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
                            <div class="card card-custom gutter-b p-5">
                                <form action="{{ route('operation-medicine.list') }}">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label>Medicine Name, Company Name</label>
                                            <input type="text" class="form-control" placeholder="Medicine Name, Company Name" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('operation-medicine.list') }}">Reset</a>
                                            @can('operation-medicine-read')
                                            <a class="btn btn-primary float-right" href="{{ route('operation-medicine.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                    <table class="table table-bordered" id="operationMedicineTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Company Name</th>
                                                <th>Added By</th>
                                                @can('operation-medicine-status')
                                                <th>Status</th>
                                                @endcan
                                                @can('operation-medicine-update')
                                                <th>Actions</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $operation_medicine)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $operation_medicine->om_name }}</td>
                                                <td>{{ $operation_medicine->om_company_name }}</td>
                                                <td>{{ $operation_medicine->AddedByData->person_name }}</td>
                                                @can('operation-medicine-status')
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($operation_medicine->om_id) }}" {{ ($operation_medicine->om_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                @endcan
                                                @can('operation-medicine-update')
                                                <td>
                                                    <a href="{{ route('operation-medicine.edit', base64_encode($operation_medicine->om_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
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
    // setTimeout(() => {
    //     var table = $('#operationMedicineTable').DataTable();
    //     table.destroy();
    //     $('#operationMedicineTable').DataTable({
    //         autoWidth: true,
    //         searching: false,
    //         paging: false,
    //         info: false
    //     });
    // }, 1000);

    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        om_id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('operation-medicine.status', '') }}" + "/" + om_id,
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