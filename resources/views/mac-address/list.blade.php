@extends('layout.master');
@section('title', 'System IP Address - List')
@section('breadcrumb-module', 'System IP Address')
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
                                <form action="{{ route('mac_address.list') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" placeholder="Address" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('mac_address.list') }}">Reset</a>
                                            <a class="btn btn-primary float-right" href="{{ route('mac_address.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                    <table class="table table-bordered scrollable_table_custom" id="macAddressTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Added By</th>
                                                @can('mac-address-status')
                                                <th>Status</th>
                                                @endcan
                                                @if(auth()->user()->can('mac-address-update') || auth()->user()->can('mac-address-remove'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $mac_address)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $mac_address->ma_pc_name }}</td>
                                                <td>{{ $mac_address->ma_address }}</td>
                                                <td>{{ $mac_address->AddedByData->person_name }}</td>
                                                @can('mac-address-status')
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($mac_address->ma_id) }}" {{ ($mac_address->ma_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                @endcan
                                                @if(auth()->user()->can('mac-address-update') || auth()->user()->can('mac-address-remove'))
                                                <td>
                                                    @can('mac-address-update')
                                                    <a href="{{ route('mac_address.edit', base64_encode($mac_address->ma_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                    @endcan
                                                    @can('mac-address-remove')
                                                    <a href="{{ route('mac_address.remove', base64_encode($mac_address->ma_id)) }}" title="Remove"><i class="la la-trash icon-3x"></i></a>
                                                    @endcan
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
<script>
    setTimeout(() => {
        var table = $('#macAddressTable').DataTable();
        table.destroy();
        $('#macAddressTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        ma_id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('mac_address.status', '') }}" + "/" + ma_id,
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