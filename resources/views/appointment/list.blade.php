@extends('layout.master');
@section('title', 'Appointment - List')
@section('breadcrumb-module', 'Appointment')
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
                                <form action="{{ route('appointment.list') }}">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <label>Search Appointment <span class="text-danger">[Note: Search by patient id, name, contact no alternate contact no, email, dob]</span></label>
                                            <input type="text" class="form-control" placeholder="Search Patient" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('appointment.list') }}">Resst</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b">
                                <div class="card-header flex-wrap py-3">
                                    <div class="card-title">
                                        <h3 class="card-label">List
                                        </h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered" id="">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Appointment ID</th>
                                                <th>Date</th>
                                                <th>Case Type</th>
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <th>DOB</th>
                                                <th>Has Madiclaim</th>
                                                @can('patient-status')
                                                <th>Status</th>
                                                @endcan
                                                @if(auth()->user()->can('appointment-read') || auth()->user()->can('appointment-update'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $appointment)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $appointment->ap_id }}</td>
                                                <td>{{ $appointment->ap_date }}</td>
                                                <td>{{ $appointment->ap_case_type }}</td>
                                                <td>{{ $appointment->pa_id }}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $appointment->ap_pament_mode }}</td>
                                                @can('patient-status')
                                                <td>

                                                </td>
                                                @endcan
                                                @if(auth()->user()->can('patient-read') || auth()->user()->can('patient-update'))
                                                <td>
                                                    @can('appointment-update')
                                                    <a href="{{ route('appointment.edit', base64_encode($appointment->ap_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                    @endcan
                                                    @can('appointment-read')
                                                    <span id="fullView" data-id="{{ base64_encode($appointment->ap_id) }}" title="Full View"><i class="la la-eye icon-3x"></i></span>
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
<div class="modal fade" id="fullViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Patient Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="viewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('body').on('change', '.updateStatus', function(event) {
        event.preventDefault();
        pa_id = $(this).data('id')
        dis = $(this);

        $.ajax({
            url: "{{ route('patient.status', '') }}" + "/" + pa_id,
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
        let pa_id = $(this).data('id');
        $.ajax({
            url: "{{ route('patient.view', '') }}" + "/" + pa_id,
            method: "GET",
            success: function(res) {
                $('#fullViewModal').modal('show');
                if (res.response === true) {
                    let data = res.data;
                    let photo = '';
                    if (data.photo != '') {
                        photo = '<img src="' + data.photo + '" class="img-fluid" />';
                    }
                    let view = '<tr> \
                        <th>Patient Name</th> \
                        <td>' + $.trim(data.pa_name) + '</td> \
                        <th>Contact No</th> \
                        <td>' + $.trim(data.pa_contact_no) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Alternate Contact No</th> \
                        <td>' + $.trim(data.pa_alt_contact_no) + '</td> \
                        <th>Email</th> \
                        <td>' + $.trim(data.pa_email) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Address</th> \
                        <td colspan="3">' + $.trim(data.pa_address) + '</td> \
                    </tr> \
                    <tr> \
                        <th>City</th> \
                        <td>' + $.trim(data.pa_city) + '</td> \
                        <th>Pin Code</th> \
                        <td>' + $.trim(data.pa_pincode) + '</td> \
                    </tr> \
                    <tr> \
                        <th>State</th> \
                        <td>' + $.trim(data.pa_state) + '</td> \
                        <th>DOB</th> \
                        <td>' + $.trim(data.pa_dob) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Age</th> \
                        <td>' + $.trim(data.pa_age) + '</td> \
                        <th>Gender</th> \
                        <td>' + $.trim(data.pa_gender) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Marital Status</th> \
                        <td>' + $.trim(data.pa_marital_status) + '</td> \
                        <th>Occupation</th> \
                        <td>' + $.trim(data.pa_occupation) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Mode of Payment</th> \
                        <td>' + $.trim(data.pa_payment_mode) + '</td> \
                        <th>Payment Detail</th> \
                        <td>' + $.trim(data.pa_payment_detail) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Last Menstrual Period</th> \
                        <td>' + $.trim(data.pa_last_monestrual_period) + '</td> \
                        <th>Number of Pregnancy</th> \
                        <td>' + $.trim(data.pa_pregnancy_no) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Number of Miscarriages</th> \
                        <td>' + $.trim(data.pa_miscarriages_no) + '</td> \
                        <th>Number of Abortion</th> \
                        <td>' + $.trim(data.pa_abortion_no) + '</td> \
                    </tr> \
                        <th>Number of Living Children</th> \
                        <td>' + $.trim(data.pa_children_no) + '</td> \
                        <th>Photo</th> \
                        <td>' + photo + '</td> \
                    </tr> \
                        <th colspan="4"><h4><strong>Do you consume any of below?</strong></h4></th> \
                    </tr> \
                        <th>Tobacco</th> \
                        <td>' + $.trim(data.pa_tobacco) + '</td> \
                        <th>Smoking</th> \
                        <td>' + $.trim(data.pa_smoking) + '</td> \
                    </tr> \
                        <th>Alcohol</th> \
                        <td colspan="3">' + $.trim(data.pa_alcohol) + '</td> \
                    </tr> \
                        <th>Any medical or surgical history?</th> \
                        <td colspan="3">' + $.trim(data.pa_medical_history) + '</td> \
                    </tr> \
                        <th>Family member had any medical or surgical history?</th> \
                        <td colspan="3">' + $.trim(data.pa_family_medical_history) + '</td> \
                    </tr> \
                        <th>Referred By</th> \
                        <td>' + $.trim(data.pa_referred_by) + '</td> \
                        <th>Referred Doctor</th> \
                        <td>' + $.trim(data.pa_referred_doctor) + '</td> \
                    </tr> \
                        <th>Referred Name</th> \
                        <td colspan="3">' + $.trim(data.pa_referred_text) + '</td> \
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