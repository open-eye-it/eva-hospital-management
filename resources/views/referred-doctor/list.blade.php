@extends('layout.master');
@section('title', 'Referred Doctor - List')
@section('breadcrumb-module', 'Referred Doctor')
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
                                <form action="{{ route('referred-doctor.list') }}">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label>Doctor/Other Name</label>
                                            <input type="text" class="form-control" placeholder="Doctor/Other Name" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 form-group">
                                            <label for="patient_date">Patient Count Range</label>
                                            <div class='input-group' id='patient_date_range'>
                                                <input type='text' name="patient_date_range" class="form-control" readonly="readonly" placeholder="Select date range" value="{{ $searchData['patient_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('referred-doctor.list') }}">Reset</a>
                                            <a class="btn btn-primary float-right" href="{{ route('referred-doctor.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                    <table class="table table-bordered scrollable_table_custom" id="referDoctorListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Patient Count</th>
                                                <th>Added By</th>
                                                @can('referred-doctor-update')
                                                <th>Actions</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $referred_doctor)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $referred_doctor->rd_name }}</td>
                                                @if($searchData['patient_date_range'] == '')
                                                <td>{{ $referred_doctor?->patientData()->count() }}</td>
                                                @else
                                                @php
                                                $patients = $referred_doctor?->patientData;
                                                $count = 0;
                                                foreach ($patients as $patient) {
                                                $dateArr = explode(' - ', $searchData['patient_date_range']);
                                                $dateArr[0] = date('Y-m-d', strtotime($dateArr[0]));
                                                $dateArr[1] = date('Y-m-d', strtotime($dateArr[1]));

                                                if (date('Y-m-d', strtotime($patient->created_at)) >= $dateArr[0] && date('Y-m-d', strtotime($patient->created_at)) <= $dateArr[1]) {
                                                    $count +=1;
                                                    }
                                                    }
                                                    @endphp
                                                    <td>{{ $count }}</td>
                                                    @endif
                                                    <td>{{ $referred_doctor->AddedByData->person_name }}</td>
                                                    @can('referred-doctor-update')
                                                    <td>
                                                        <a href="{{ route('referred-doctor.edit', base64_encode($referred_doctor->rd_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
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
@endsection
<script>
    setTimeout(() => {
        var table = $('#referDoctorListTable').DataTable();
        table.destroy();
        $('#referDoctorListTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);
</script>