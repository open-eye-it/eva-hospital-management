@extends('layout.master');
@section('title', 'Patient - List')
@section('breadcrumb-module', 'Patient')
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
                                <form action="{{ route('patient.list') }}">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <label>Search Patient <span class="text-danger">[Note: Search by patient id, name, contact no, alternate contact no, email, dob]</span></label>
                                            <input type="text" class="form-control" placeholder="Search Patient" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-12 form-group">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('patient.list') }}">Resst</a>
                                            <a class="btn btn-primary float-right" href="{{ route('patient.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                    <table class="table table-bordered table-separate scrollable_table_custom" id="">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient ID</th>
                                                <th>Name</th>
                                                <th>Contact No</th>
                                                <th>DOB</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Added By</th>
                                                @can('patient-status')
                                                <th>Status</th>
                                                @endcan
                                                @if(auth()->user()->can('patient-read') || auth()->user()->can('patient-update'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $patient)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $patient->pa_id }}</td>
                                                <td>{{ $patient->pa_name }}</td>
                                                <td>{{ $patient->pa_contact_no }}</td>
                                                <td>{{ ($patient->pa_dob != null && $patient->pa_dob != '') ? date('d M Y', strtotime($patient->pa_dob)) : '' }}</td>
                                                <td>{{ $patient->pa_city }}</td>
                                                <td>{{ $patient->pa_state }}</td>
                                                <td>{{ $patient->AddedByData->person_name }}</td>
                                                @can('patient-status')
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" class="updateStatus" data-id="{{ base64_encode($patient->pa_id) }}" {{ ($patient->pa_status==1)?'checked':'' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                @endcan
                                                @if(auth()->user()->can('patient-read') || auth()->user()->can('patient-update'))
                                                <td>
                                                    <div class="dropdown dropdown-inline">
                                                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"> <i class="ki ki-bold-more-hor icon-3x"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                            <ul class="nav nav-hoverable">
                                                                @can('patient-update')
                                                                <li class="nav-item"><a class="nav-link" href="{{ route('patient.edit', base64_encode($patient->pa_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a></li>
                                                                @endcan
                                                                @can('patient-read')
                                                                <li class="nav-item"><span class="nav-link" id="fullView" data-id="{{ base64_encode($patient->pa_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span></li>
                                                                @endcan

                                                                <li class="nav-item"><i title="Print Patient" class="flaticon flaticon2-print icon-3x cursor_pointer nav-link" id="printPatientModal" onclick="printPatientBill('{{ base64_encode($patient->pa_id) }}')"></i></li>
                                                                @can('appointment-create')
                                                                <li class="nav-item"><a class="nav-link" href="{{ route('appointment.create').'?patient='.base64_encode($patient->pa_id) }}"><i title="Book Appointment" class="flaticon-calendar-2 icon-3x cursor_pointer"></i></a></li>
                                                                @endcan
                                                                @if(empty($patient->ipdAdmit))
                                                                <li class="nav-item"><a class="nav-link" href="{{ route('ipd.create').'?patient='.base64_encode($patient->pa_id) }}"><i title="Book IPD" class="la la-bed icon-3x cursor_pointer"></i></a></li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="10">Record not found</td>
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
                <table class="table" id="viewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <i title="Print Bill" class="flaticon flaticon2-print icon-3x cursor_pointer" id="printPatientModal"></i>
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
                        photo = '<img src="' + data.photo + '" class="img-fluid" width="100px" />';
                    }
                    let dob = '';
                    if (data.pa_dob != null && data.pa_dob != '') {
                        dob = moment($.trim(data.pa_dob)).format('DD MMM YYYY');
                    }
                    let view = '<tr> \
                        <th>Patient ID</th> \
                        <td>' + $.trim(data.pa_id) + '</td> \
                        <th>Patient Name</th> \
                        <td>' + $.trim(data.pa_name) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Contact No</th> \
                        <td>' + $.trim(data.pa_contact_no) + '</td> \
                        <th>Alternate Contact No</th> \
                        <td>' + $.trim(data.pa_alt_contact_no) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Email</th> \
                        <td>' + $.trim(data.pa_email) + '</td> \
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
                        <td>' + dob + '</td> \
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

                    $('#printPatientModal').attr('onclick', 'printPatientBill("' + pa_id + '")');
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

    /* Print Bill */
    function printPatientBill(pa_id) {
        let url = "{{ route('patient.print', ['pa_id' => ':pa_id']) }}";
        url = url.replace(':pa_id', pa_id);
        $.ajax({
            url: url,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    /* Print Data */
    function printData(data) {
        $('<iframe>', {
                name: 'myiframe',
                class: 'printFrame'
            })
            .appendTo('body')
            .contents().find('body')
            .append(data);

        window.frames['myiframe'].focus();
        window.frames['myiframe'].print();

        setTimeout(() => {
            $(".printFrame").remove();
        }, 1000);
    };
</script>
@endsection