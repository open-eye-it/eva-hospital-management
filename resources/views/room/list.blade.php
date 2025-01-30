@extends('layout.master');
@section('title', 'Room - List')
@section('breadcrumb-module', 'Room')
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
                                <form action="{{ route('room.list') }}">
                                    <div class="row p-5">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label>Search room number or charge</label>
                                            <input type="text" class="form-control" placeholder="Search room number or charge" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="">BUilding</label>
                                            <select name="rm_building" id="rm_building" class="form-control" onchange="getFloorFilter(this.value)">
                                                <option value="">-Select-</option>
                                                @foreach($Buildings as $building)
                                                <option value="{{ $building->rm_building }}" {{ ($building->rm_building == $searchData['rm_building']) ? 'selected' : '' }}>{{ $building->rm_building }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group {{ ($Floors == '') ? 'd-none' : '' }}" id="floor_filter">
                                            @if($Floors != '')
                                            <label>Floor</label>
                                            <select name="rm_floor" id="rm_floor" class="form-control" onchange="getWardFilter('{{ $searchData['rm_building'] }}', this.value)">
                                                <option value="">-Select</option>
                                                @foreach($Floors as $flist)
                                                <option value="{{ $flist->rm_floor }}" {{ ($flist->rm_floor == $searchData['rm_floor']) ? 'selected' : '' }}>{{ $flist->rm_floor }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group {{ ($Wards == '') ? 'd-none' : '' }}" id="ward_filter">
                                            @if($Wards != '')
                                            <label>Ward</label>
                                            <select name="rm_ward" id="rm_ward" class="form-control" onchange="getRoomFilter('{{ $searchData['rm_building'] }}', '{{ $searchData['rm_floor'] }}', this.value)">
                                                <option value="">-Select</option>
                                                @foreach($Wards as $wlist)
                                                <option value="{{ $wlist->rm_ward }}" {{ ($wlist->rm_ward == $searchData['rm_ward']) ? 'selected' : '' }}>{{ $wlist->rm_ward }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 form-group {{ ($Rooms == '') ? 'd-none' : '' }}" id="room_filter">
                                            @if($Rooms != '')
                                            <label>Room</label>
                                            <select name="rm_no" id="rm_no" class="form-control">
                                                <option value="">-Select</option>
                                                @foreach($Rooms as $rlist)
                                                <option value="{{ $rlist->rm_no }}" {{ ($rlist->rm_no == $searchData['rm_no']) ? 'selected' : '' }}>{{ $rlist->rm_no }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary " type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('room.list') }}">Reset</a>
                                            <a class="btn btn-primary float-right" href="{{ route('room.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                    <table class="table table-bordered scrollable_table_custom" id="roomListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Building</th>
                                                <th>Floor</th>
                                                <th>Ward</th>
                                                <th>Room Number</th>
                                                <th>Charge</th>
                                                <th>Room Busy</th>
                                                <th>Added By</th>
                                                @can('room-status')
                                                <th>Status</th>
                                                @endcan
                                                @can('room-update')
                                                <th>Actions</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($list))
                                            @foreach($list as $key => $room)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $room->rm_building }}</td>
                                                <td>{{ $room->rm_floor }}</td>
                                                <td>{{ $room->rm_ward }}</td>
                                                <td>{{ $room->rm_no }}</td>
                                                <td>{{ $room->rm_charge }}</td>
                                                <td>
                                                    @php
                                                    $status = 'No';
                                                    if($room->rm_busy == 1){
                                                    $status = 'Yes';
                                                    }
                                                    @endphp
                                                    <span class="label label-lg font-weight-bold label-light-primary label-inline">{{ $status }}</span>
                                                </td>
                                                <td>{{ $room->AddedByData->person_name }}</td>
                                                @can('room-status')
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($room->rm_id) }}" {{ ($room->rm_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                @endcan
                                                @can('room-update')
                                                <td>
                                                    <a href="{{ route('room.edit', base64_encode($room->rm_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
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
    setTimeout(() => {
        var table = $('#roomListTable').DataTable();
        table.destroy();
        $('#roomListTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        rm_id = $(this).data('id')
        dis = $(this);
        $.ajax({
            url: "{{ route('room.status', '') }}" + "/" + rm_id,
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

    function getFloorFilter(rm_building) {
        $.ajax({
            url: "{{ route('room.floor.filter', '') }}/" + btoa(rm_building),
            method: "get",
            success: function(res) {
                if (rm_building == '') {
                    $('#floor_filter').html('');
                    $('#floor_filter').addClass('d-none');
                    $('#ward_filter').html('');
                    $('#ward_filter').addClass('d-none');
                    $('#room_filter').html('');
                    $('#room_filter').addClass('d-none');
                } else {
                    if (res.response === true) {
                        $('#floor_filter').html(res.data);
                        $('#floor_filter').removeClass('d-none');
                        $('#ward_filter').html('');
                        $('#ward_filter').addClass('d-none');
                        $('#room_filter').html('');
                        $('#room_filter').addClass('d-none');
                    }
                }
            }
        });
    }

    function getWardFilter(rm_building, rm_floor) {
        let rm_building_base64 = btoa(rm_building);
        let rm_floor_base64 = btoa(rm_floor);
        let urlFinal = "{{ route('room.ward.filter',  ['rm_building' => ':rm_building_base64', 'rm_floor' => ':rm_floor_base64']) }}";
        urlFinal = urlFinal.replace(':rm_building_base64', rm_building_base64);
        urlFinal = urlFinal.replace(':rm_floor_base64', rm_floor_base64);
        $.ajax({
            url: urlFinal,
            method: "get",
            success: function(res) {
                if (rm_floor == '') {
                    $('#ward_filter').html('');
                    $('#ward_filter').addClass('d-none');
                    $('#room_filter').html('');
                    $('#room_filter').addClass('d-none');
                } else {
                    if (res.response === true) {
                        $('#ward_filter').html(res.data);
                        $('#ward_filter').removeClass('d-none');
                        $('#room_filter').html('');
                        $('#room_filter').addClass('d-none');
                    }
                }
            }
        });
    }

    function getRoomFilter(rm_building, rm_floor, rm_ward) {
        let rm_building_base64 = btoa(rm_building);
        let rm_floor_base64 = btoa(rm_floor);
        let rm_ward_base64 = btoa(rm_ward);
        let urlFinal = "{{ route('room.room.filter',  ['rm_building' => ':rm_building_base64', 'rm_floor' => ':rm_floor_base64', 'rm_ward' => ':rm_ward_base64']) }}";
        urlFinal = urlFinal.replace(':rm_building_base64', rm_building_base64);
        urlFinal = urlFinal.replace(':rm_floor_base64', rm_floor_base64);
        urlFinal = urlFinal.replace(':rm_ward_base64', rm_ward_base64);
        $.ajax({
            url: urlFinal,
            method: "get",
            success: function(res) {
                if (rm_ward == '') {
                    $('#room_filter').html('');
                    $('#room_filter').addClass('d-none');
                } else {
                    if (res.response === true) {
                        $('#room_filter').html(res.data);
                        $('#room_filter').removeClass('d-none');
                    }
                }
            }
        });
    }
</script>
@endsection