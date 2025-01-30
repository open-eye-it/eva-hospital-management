@extends('layout.master');
@section('title', 'Visiting Fee - List')
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
                        <div class="col-12">
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
                                    <table class="table table-bordered scrollable_table_custom" id="">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Case Type</th>
                                                <th>Fee</th>
                                                <th>Added By</th>
                                                <th>Updated By</th>
                                                @can('visiting-fee-update')
                                                <th>Actions</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $fee)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ strtoupper($fee->vf_case_type) }}</td>
                                                <td>{{ $fee->vf_fees }}</td>
                                                <td>{{ $fee->AddedByData->person_name }}</td>
                                                <td>{{ $fee->UpdatedByData->person_name }}</td>
                                                @can('visiting-fee-update')
                                                <td>
                                                    <a href="{{ route('visiting_fee.edit', base64_encode($fee->vf_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
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
    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        cat_id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('category.status', '') }}" + "/" + cat_id,
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