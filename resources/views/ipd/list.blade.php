@extends('layout.master');
@section('title', 'IPD - List')
@section('breadcrumb-module', 'IPD')
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
                                <form action="{{ route('ipd.list') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="search_text">IPD ID</label>
                                            <input type="text" class="form-control" placeholder="IPD ID" name="search_text" id="search_text" value="{{ $searchData['search_text'] }}">
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="appointment_date">Admit Date</label>
                                            <div class='input-group' id='appointment_date_range'>
                                                <input type='text' name="admit_date_range" id="admit_date_range" class="form-control" placeholder="Select date range" value="{{ $searchData['admit_date_range'] }}" />
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12 form-group">
                                            <label for="patient">Doctor</label>
                                            <select name="ipd_doctor" id="ipd_doctor" class="form-control">
                                                <option value="">Select</option>
                                                @if(!empty($doctors))
                                                @foreach($doctors as $doctor)
                                                <option value="{{ $doctor['user_id'] }}" {{ ($doctor['user_id'] == $searchData['ipd_doctor']) ? 'selected' : '' }}>{{ $doctor['person_name'] }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
                                            <label for="">Status</label>
                                            <select name="ipd_status" id="ipd_status" class="form-control" onchange="changeStatusVal(this.value)">
                                                <option value="">-Select-</option>
                                                <option value="admit" {{ ($searchData['ipd_status'] == 'admit') ? 'selected' : '' }}>Admitted</option>
                                                <option value="discharged" {{ ($searchData['ipd_status'] == 'discharged') ? 'selected' : '' }}>Discharge</option>
                                                <option value="cancelled" {{ ($searchData['ipd_status'] == 'cancelled') ? 'selected' : '' }}>Cancel</option>
                                                <option value="all" {{ ($searchData['ipd_status'] == '') ? 'selected' : '' }}>All</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Search</button>
                                            <a class="btn btn-danger" href="{{ route('ipd.list') }}">Reset</a>
                                            <button type="button" class="btn btn-info" onclick="exportIPD()"><i class="fa fa-file-export"></i> Export</button>
                                            <a class="btn btn-primary float-right" href="{{ route('ipd.create') }}">Add <i class="fa fa-plus"></i></a>
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
                                <div class="card-body overflow_visible">
                                    <!--begin: Datatable-->
                                    <table class="table table-bordered scrollable_table_custom" id="ipdListTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient ID</th>
                                                <th>Patient Name</th>
                                                <th>Room No</th>
                                                <th>Dr. Name</th>
                                                <th>Surgery Detail</th>
                                                <th>Date of Admit</th>
                                                <th>Dat of Surgery</th>
                                                <th>Age</th>
                                                <th>Contact No</th>
                                                <!-- <th>Bill Amount</th>
                                                <th>Received Amount</th> -->
                                                @can('ipd-status')
                                                <th>Status</th>
                                                @endcan
                                                @can('ipd-opd-history')
                                                <th>OPD</th>
                                                @endcan
                                                @can('ipd-ipd-history')
                                                <th>IPD</th>
                                                @endcan
                                                @if(auth()->user()->can('ipd-edit') || auth()->user()->can('ipd-full-view') || auth()->user()->can('ipd-bill-amount') || auth()->user()->can('ipd-operative-note') || auth()->user()->can('ipd-prescribe') || auth()->user()->can('ipd-detail-print'))
                                                <th>Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!$list->isEmpty())
                                            @foreach($list as $key => $ipd)
                                            <tr>
                                                <td>{{ $list->firstItem() + $key }}</td>
                                                <td>{{ $ipd->pa_id }}</td>
                                                <td>{{ $ipd->patientData->pa_name }}</td>
                                                <td>{{ $ipd?->roomData?->rm_building.'-'.$ipd?->roomData?->rm_floor.'-'.$ipd?->roomData?->rm_ward.'-'.$ipd?->roomData?->rm_no }}</td>
                                                <td>{{ $ipd?->doctorData?->name }}</td>
                                                <td>{{ $ipd?->ipd_surgery_text }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->ipd_admit_date)) }}</td>
                                                <td>{{ date('d M Y', strtotime($ipd->ipd_surgery_date)) }}</td>
                                                <td>{{ $ipd->patientData->pa_age }}</td>
                                                <td>{{ $ipd->patientData->pa_contact_no }}</td>
                                                <!-- <td id="billAmountShow_{{ $ipd->ipd_id }}">{{ $ipd->ipd_bill_amount }}</td>
                                                <td>{{ $ipd->ipd_received_amount }}</td> -->
                                                @can('ipd-status')
                                                <td>
                                                    @if($ipd->ipd_status == 'admit')
                                                    @php $statusClass = 'btn-primary'; @endphp
                                                    @elseif($ipd->ipd_status == 'discharged')
                                                    @php $statusClass = 'btn-success'; @endphp
                                                    @else
                                                    @php $statusClass = 'btn-danger'; @endphp
                                                    @endif
                                                    <span class="btn {{ $statusClass }}" id="status_{{ $ipd->ipd_id }}" onclick="statusModal('{{ base64_encode($ipd->ipd_id) }}')">{{ ($ipd->ipd_status == 'admit') ? 'Admitted' : ucfirst($ipd->ipd_status) }}</span>
                                                </td>
                                                @endcan
                                                @can('ipd-opd-history')
                                                <td>
                                                    <span id="opdHistoryView" data-id="{{ base64_encode($ipd->pa_id) }}" title="OPD History"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                </td>
                                                @endcan
                                                @can('ipd-ipd-history')
                                                <td>
                                                    <span id="ipdHistoryView" data-id="{{ base64_encode($ipd->pa_id) }}" title="IPD History"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                </td>
                                                @endcan
                                                @if(auth()->user()->can('ipd-edit') || auth()->user()->can('ipd-full-view') || auth()->user()->can('ipd-bill-amount') || auth()->user()->can('ipd-operative-note') || auth()->user()->can('ipd-prescribe') || auth()->user()->can('ipd-detail-print'))
                                                <td>
                                                    <div class="dropdown dropdown-inline">
                                                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown" aria-expanded="false"> <i class="ki ki-bold-more-hor icon-3x"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                            <ul class="nav nav-hoverable">
                                                                <!-- <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Status</span></a></li>
                                                                <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-print"></i><span class="nav-text">Print</span></a></li> -->
                                                                @can('ipd-edit')
                                                                <li class="nav-item"><a class="nav-link" href="{{ route('ipd.edit', base64_encode($ipd->ipd_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a></li>
                                                                @endcan
                                                                @can('ipd-full-view')
                                                                <li class="nav-item"><span class="nav-link" id="fullView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span> </li>
                                                                @endcan
                                                                @can('ipd-bill-amount')
                                                                <li class="nav-item"><span class="nav-link" id="billAmountView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Bill Amount"><i class="la la-money-bill icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                                @can('ipd-operative-note')
                                                                <li class="nav-item"><span class="nav-link" id="operativeNoteView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Operative Notes"><i class="flaticon flaticon-notes icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                                @can('ipd-prescribe')
                                                                <li class="nav-item"><span class="nav-link" id="prescribeView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Prescribe"><i class="la la-pills icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                                @can('ipd-detail-print')
                                                                <li class="nav-item"><span class="nav-link" id="IPDPrint" data-id="{{ base64_encode($ipd->ipd_id) }}" title="IPD Detail"><i class="flaticon flaticon2-print icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                                @can('ipd-documents')
                                                                <li class="nav-item"><span class="nav-link" id="IPDDocument" data-id="{{ base64_encode($ipd->ipd_id) }}" title="IPD Documents"><i class="flaticon flaticon-file icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                                @can('ipd-indoor-sheet')
                                                                <li class="nav-item"><span class="nav-link" id="IndoorSheet" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Indoor Sheet"><i class="flaticon flaticon2-sheet icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                                @can('ipd-examination-sheet')
                                                                <li class="nav-item"><span class="nav-link" id="exSheet" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Examination Sheet"><i class="flaticon flaticon2-document icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                                @can('ipd-pre-operative-medicine')
                                                                <li class="nav-item"><span class="nav-link" id="PreOperativeMedicine" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Pre Operative Medicine"><i class="flaticon flaticon-file-1 icon-3x cursor_pointer"></i></span></li>
                                                                @endcan
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <!-- <a href="{{ route('ipd.edit', base64_encode($ipd->ipd_id)) }}" title="Edit"><i class="la la-edit icon-3x"></i></a>
                                                    <span id="fullView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Full View"><i class="la la-eye icon-3x cursor_pointer"></i></span>
                                                    <span id="billAmountView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Bill Amount"><i class="la la-money-bill icon-3x cursor_pointer"></i></span>
                                                    <span id="operativeNoteView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Operative Notes"><i class="flaticon flaticon-notes icon-3x cursor_pointer"></i></span>
                                                    <span id="prescribeView" data-id="{{ base64_encode($ipd->ipd_id) }}" title="Prescribe"><i class="la la-pills icon-3x cursor_pointer"></i></span>
                                                    <span id="IPDPrint" data-id="{{ base64_encode($ipd->ipd_id) }}" title="IPD Detail"><i class="flaticon flaticon2-print icon-3x cursor_pointer"></i></span> -->
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="16">Record not found</td>
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
<div class="modal fade" id="PreOperativeMedicineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg popup-80" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pre OperativeMedicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeIndoorSheet()">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body max-h-500 overflow-auto">

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Patient Name:</strong> <span id="PreMedicinePatient"></span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Type of surgery:</strong> <span id="PreMedicineSurgery"></span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Date:</strong> {{ Date('d M Y') }}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Medicine/Recommendation <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Medicine/Recommendation" name="recommendation" id="recommendation" />
                            <span class="text-danger" id="recommendationErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group">
                            <label>Given or Not?</label>
                            <!-- <input type="text" class="form-control" placeholder="Company Name" name="gm_company_name" id="gm_company_name" /> -->
                            <input type="checkbox" id="given_or_not" name="given_or_not" class="form-control checkbox">
                            <span class="text-danger" id="given_or_notErr"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                            <span class="text-danger" id="descriptionErr"></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <input type="hidden" id="ipom_id" name="ipom_id" value="">
                        <button type="submit" id="preMedicineAdd" class="btn btn-primary mt-4">Add <i class="la la-plus"></i></button>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Recommendation</th>
                            <th>Given or Not</th>
                            <th>Description</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ipomDataTable"></tbody>
                </table>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="IndoorSheetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg popup-80" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Indoor Sheet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeIndoorSheet()">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body max-h-500 overflow-auto">

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Patient Name:</strong> <span id="IndoorSheetPatient"></span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Type of surgery:</strong> <span id="IndoorSheetSurgery"></span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Date:</strong> {{ Date('d M Y') }}
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <label for="patient_name">Findings</label>
                        <!-- <input type="text" class="form-control" name="is_findings" id="is_findings" value="" placeholder="Findings" /> -->
                        <textarea class="form-control" rows="3" name="is_findings" id="is_findings"></textarea>
                        <span class="text-danger" id="is_findings_err"></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <input type="hidden" id="is_id" name="is_id" value="">
                        <button type="submit" id="IndoorSheetAdd" class="btn btn-primary mt-4">Add <i class="la la-plus"></i></button>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Findings</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="isDataTable"></tbody>
                </table>
                <hr>
                <div class="row d-none" id="recommendationMoadl1">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <label for="patient_name">Recommendation</label>
                        <input type="text" class="form-control" name="ism_recommendation" id="ism_recommendation" value="" placeholder="Recommendation" />
                        <span class="text-danger" id="ism_recommendation_err"></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mt-4">
                        <input type="hidden" id="is_id1" name="is_id1" value="">
                        <input type="hidden" id="ism_id" name="ism_id" value="">
                        <button id="IndoorSheetMedicineAdd" class="btn btn-primary mt-4">Add <i class="la la-plus"></i></button>
                    </div>
                </div>
                <table class="table d-none" id="recommendationMoadl2">
                    <thead>
                        <tr>
                            <th>Recommendation</th>
                            <th>Added By</th>
                            <th>Added On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ismDataTable"></tbody>
                </table>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="exSheetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Examination Sheet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeEaxminationSheet()">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body max-h-500 overflow-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Patient Name:</strong> <span id="exSheetPatient"></span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Type of surgery:</strong> <span id="exSheetSurgery"></span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <strong>Date:</strong> {{ Date('d M Y') }}
                    </div>
                </div>
                <h4 class="mt-4">Findings</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Findings</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="exDataTable"></tbody>
                </table>
                <hr>
                <div class="row d-none" id="exRecommendationMoadl">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h4>Recommendation</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button class="btn btn-primary float-right" id="esmRecommendationBtn" onclick="AddExaminationMeicine()">Add <i class="la la-plus icon-3x cursor_pointer"></i></button>
                    </div>
                </div>
                <table class="table d-none" id="exRecommendationMoad2">
                    <thead>
                        <tr>
                            <th>Recommendation</th>
                            <th>Added By</th>
                            <th>Date Time</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="exmDataTable"></tbody>
                </table>
                <hr>
                <div class="row d-none" id="examinationModall">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h4>Exmination</h4>
                    </div>
                </div>
                <div class="row d-none" id="examinationModal2">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 form-group">
                        <label for="isme_given_datetime1">Date Time</label>
                        <input type="datetime-local" name="isme_given_datetime1" id="isme_given_datetime1" class="form-control" value="22-12-2024 10:37:00">
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 form-group">
                        <label for="ramerakData1">Remark</label>
                        <textarea name="ramerakData1" rows="5" class="remarkMessage1 form-control" id="ramerakData1" value=""></textarea>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 form-group mt-4">
                        <input type="hidden" name="isme_id1" id="isme_id1" value="">
                        <button class="btn btn-primary" id="updateExaminationBtn">Update <i class="la la-plus icon-3x cursor_pointer"></i></button>
                    </div>
                </div>
                <table class="table d-none" id="examinationModal3">
                    <thead>
                        <tr>
                            <th>Recomendation</th>
                            <th>Attended Time</th>
                            <th>Entry Time</th>
                            <th>Remark</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="exm1DataTable"></tbody>
                </table>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="fullViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Detail</h5>
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
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="statusDetail">
                    <div class="form-group">
                        <label for="">Status</label>
                        <select name="ip_status_val" id="ip_status_val" class="form-control" onchange="changeStatusVal(this.value)">
                            <option value="">-Select-</option>
                            <option value="admit">Admitted</option>
                            <option value="discharged">Discharge</option>
                            <option value="cancelled">Cancel</option>
                        </select>
                    </div>
                    <!-- <span class="btn btn-primary mr-2" id="admitStatus">Admit</span>
                    <hr /> -->
                    <div class="d-none" id="dischargeStatusVal">
                        <div class="form-group pt-4">
                            <label for="ipd_discharge_date">Discharge Date</label>
                            <input type="date" class="form-control" name="ipd_discharge_date" id="ipd_discharge_date" />
                            <span class="text-primary cursor_pointer" onclick="ResetDischargeDate()">Reset</span>
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_discharge_date">Follow Up Date</label>
                            <input type="date" class="form-control" name="ipd_follow_up_date" id="ipd_follow_up_date" />
                            <span class="text-primary cursor_pointer" onclick="ResetFollowUpDate()">Reset</span>
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_diagnosis">Diagnosis</label>
                            <input type="text" class="form-control" name="ipd_diagnosis" id="ipd_diagnosis" />
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_investigations">Invastigations</label>
                            <input type="text" class="form-control" name="ipd_investigations" id="ipd_investigations" />
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_treatment_given">Treatment Given</label>
                            <textarea class="form-control" name="ipd_treatment_given" id="ipd_treatment_given" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group pt-4">
                            <label for="ipd_treatment_discharge">Treatment On Discharge</label>
                            <textarea class="form-control" name="ipd_treatment_discharge" id="ipd_treatment_discharge" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <!-- <span class="btn btn-success mr-2" id="dischargedStatus">Discharge</span>
                    <hr /> -->
                    <div class="d-none" id="cancelStatusVal">
                        <div class="form-group pt-4">
                            <label for="ipd_cancel_reason">Cancel Reason</label>
                            <textarea class="form-control" name="ipd_cancel_reason" id="ipd_cancel_reason" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <!-- <span class="btn btn-danger mr-2" id="cancelledStatus">Cancel</span> -->
                    <div>
                        <button class="btn btn-primary" id="statusButton">Submit</button>
                    </div>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ipdDocViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enc-type="multipart/form-data" id="submitDocument">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="patient_name">Document Name</label>
                            <input type="text" class="form-control" name="ipd_doc_name" id="ipd_doc_name" value="" placeholder="Document Name" />
                            <span class="text-danger" id="ipd_doc_name_err"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <label for="patient_name">Document File</label>
                            <input type="file" class="form-control" name="ipd_doc" id="ipd_doc" value="" placeholder="Document" />
                            <span class="text-danger" id="ipd_doc_err"></span>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <input type="hidden" id="ipd_id_doc" name="ipd_id_doc" value="">
                            <button type="submit" id="docAdd" class="btn btn-primary mt-4">Add <i class="la la-plus"></i></button>
                        </div>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ipdDocData"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="billAmountViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Bill Amount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="billAmountViewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="operativeNoteViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Operative Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="operativeNoteViewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="prescribeViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Operation Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table" id="prescribeViewDetail">

                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="opdHistoryViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl popup-90" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">OPD Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4>Total Fees: <span id="opd_total_fees"></span></h4>
                <table class="table table-bordered scrollable_table_custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Appointment ID</th>
                            <th>Date</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <!-- <th>Contact No</th> -->
                            <th>Case Type</th>
                            <th>Is FOC</th>
                            <th>Fee</th>
                            <th>Additional Charge</th>
                            <th>Follow Up Date</th>
                            <th>Decided Date of Surgery</th>
                        </tr>
                    </thead>
                    <tbody id="opdHistoryViewDetail"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="ipdHistoryViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl popup-90" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">IPD Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <h4>Bill Amount: <span id="ipd_total_bill"></span></h4>
                <h4>Received Amount: <span id="ipd_total_received"></span></h4>
                <table class="table table-bordered scrollable_table_custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IPD ID</th>
                            <th>Admit Date</th>
                            <th>Room No</th>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                            <th>AGE</th>
                            <th>Contact No</th>
                            <th>Surgery Type</th>
                            <th>Surgery Date</th>
                            <th>Doctor</th>
                            <th>Discharge Date</th>
                            <th>Follow Up Date</th>
                            <th>Is Foc</th>
                            <th>Status</th>
                            <th>Mediclaim</th>
                            <th>Bill Amount</th>
                            <th>Received Amount</th>
                        </tr>
                    </thead>
                    <tbody id="ipdHistoryViewDetail"></tbody>
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
        var table = $('#ipdListTable').DataTable();
        table.destroy();
        $('#ipdListTable').DataTable({
            autoWidth: true,
            searching: false,
            paging: false,
            info: false
        });
    }, 1000);

    $('body').on('click', '#PreOperativeMedicine', function(event) {
        $('#PreOperativeMedicineModal').modal('show');
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.pre_operative_medicine.list', '') }}/" + ipd_id,
            method: "GET",
            success: function(res) {
                $('#preMedicineAdd').attr('onclick', "addPreMedicine('" + ipd_id + "')");
                if (res.response == true) {
                    $('#PreMedicinePatient').text(res?.data?.patientName);
                    $('#PreMedicineSurgery').text(res?.data?.ipdDetail?.ipd_surgery_text);
                    $('#ipomDataTable').html(res?.data?.html);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    function addPreMedicine(ipd_id) {
        let ipom_id = $('#ipom_id').val();
        let recommendation = $('#recommendation').val();
        let given_or_not = 0;
        let given_or_not_text = 'No';
        if ($("#given_or_not").prop('checked') == true) {
            given_or_not = 1;
            given_or_not_text = 'Yes';
        }
        let description = $('#description').val();
        if (recommendation == '') {
            scrollTop('recommendation');
            $('#recommendationErr').text('Please enter recommendation');
            timeoutID('recommendationErr', 3000);
        } else {
            $('#preMedicineAdd').addClass('spinner spinner-white spinner-right');
            $('#preMedicineAdd').attr('disabled', true);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                url: "{{ route('ipd.pre_operative_medicine.add') }}",
                method: "POST",
                data: {
                    ipd_id: ipd_id,
                    ipom_id: ipom_id,
                    recommendation: recommendation,
                    given_or_not: given_or_not,
                    description: description
                },
                success: function(res) {
                    if (res.response == true) {
                        if (ipom_id == '') {
                            $('#recommendation').val('');
                            $('#given_or_not').prop('checked', false);
                            $('#description').val('');
                            $('#ipomDataTable').prepend(res.data.html);
                        } else {
                            $('#ipom_id').val('');
                            $('#recommendation').val('');
                            $('#given_or_not').prop('checked', false);
                            $('#description').val('');
                            $('#ipom_row_' + ipom_id + ' td:nth-child(1)').text(recommendation);
                            $('#ipom_row_' + ipom_id + ' td:nth-child(2)').text(given_or_not_text);
                            $('#ipom_row_' + ipom_id + ' td:nth-child(3)').text(description);
                        }
                        $('#preMedicineAdd').html('Add <i class="la la-plus"></i>');
                        sweetAlertSuccess(res.message, 3000);
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                    $('#preMedicineAdd').removeClass('spinner spinner-white spinner-right');
                    $('#preMedicineAdd').attr('disabled', false);
                },
                error: function(r) {
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                    $('#preMedicineAdd').removeClass('spinner spinner-white spinner-right');
                    $('#preMedicineAdd').attr('disabled', false);
                }
            });
        }
    }

    function editPreMedicine(ipom_id) {
        let ipom_id1 = atob(ipom_id);
        let recommendation = $('#ipom_row_' + ipom_id1 + ' td:nth-child(1)').text();
        let given_or_not = $('#ipom_row_' + ipom_id1 + ' td:nth-child(2)').text();
        let description = $('#ipom_row_' + ipom_id1 + ' td:nth-child(3)').text();
        $('#recommendation').val(recommendation);
        if (given_or_not == 'Yes') {
            $('#given_or_not').prop('checked', true);
        } else {
            $('#given_or_not').prop('checked', false);
        }
        $('#description').val(description);
        $('#ipom_id').val(ipom_id1);
        $('#preMedicineAdd').html('Update <i class="la la-plus"></i>');
    }

    function removerPreMedicine(ipom_id) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            url: "{{ route('ipd.pre_operative_medicine.remove', '') }}/" + ipom_id,
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    if (res.response == true) {
                        $('#ipom_row_' + atob(ipom_id)).remove();
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    /* Start:: Indoor Sheet */
    $('body').on('click', '#IndoorSheet', function(event) {
        $('#IndoorSheetModal').modal('show');
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.indoor_sheet.list', '') }}/" + ipd_id,
            method: "GET",
            success: function(res) {
                $('#IndoorSheetAdd').attr('onclick', "addFindings('" + ipd_id + "')");
                if (res.response == true) {
                    $('#IndoorSheetPatient').text(res?.data?.patientName);
                    $('#IndoorSheetSurgery').text(res?.data?.ipdDetail?.ipd_surgery_text);
                    $('#isDataTable').html(res?.data?.html);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    function addFindings(ipd_id) {
        let is_id = $('#is_id').val();
        let is_findings = $('#is_findings').val();
        if (is_findings == '') {
            scrollTop('is_findings');
            $('#is_findings_err').text('Please enter findings');
            timeoutID('is_findings_err', 3000);
        } else {
            $('#IndoorSheetAdd').addClass('spinner spinner-white spinner-right');
            $('#IndoorSheetAdd').attr('disabled', true);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                url: "{{ route('ipd.indoor_sheet.findings.add') }}",
                method: "POST",
                data: {
                    ipd_id: ipd_id,
                    is_id: is_id,
                    is_findings: is_findings
                },
                success: function(res) {
                    console.log(res);
                    if (res.response == true) {
                        if (is_id == '') {
                            $('#is_findings').val('');
                            $('#isDataTable').prepend(res.data.html);
                        } else {
                            $('#is_id').val('');
                            $('#is_findings').val('');
                            $('#is_row_' + is_id + ' td:nth-child(2)').text(is_findings);
                        }
                        $('#IndoorSheetAdd').html('Add <i class="la la-plus"></i>');
                        sweetAlertSuccess(res.message, 3000);
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                    $('#IndoorSheetAdd').removeClass('spinner spinner-white spinner-right');
                    $('#IndoorSheetAdd').attr('disabled', false);
                },
                error: function(r) {
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                    $('#IndoorSheetAdd').removeClass('spinner spinner-white spinner-right');
                    $('#IndoorSheetAdd').attr('disabled', false);
                }
            });
        }
    }

    function editFindings(is_id) {
        let is_id1 = atob(is_id);
        let findings = $('#is_row_' + is_id1 + ' td:nth-child(2)').text();
        $('#is_findings').val(findings);
        $('#is_id').val(is_id1);
        $('#IndoorSheetAdd').html('Update <i class="la la-plus"></i>');
    }

    function removerFindings(is_id) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            url: "{{ route('ipd.indoor_sheet.findings.remove', '') }}/" + is_id,
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    if (res.response == true) {
                        $('#is_row_' + atob(is_id)).remove();
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    function closeIndoorSheet() {
        $('#isDataTable').html('');
        $('#recommendationMoadl1').addClass('d-none');
        $('#recommendationMoadl2').addClass('d-none');
        $('#ismDataTable').html('');
    }
    /* End:: Indoor Sheet */
    /* Start:: Indoor Sheet Medicine */
    function showRecommenadtion(is_id) {
        $('#recommendationMoadl1').removeClass('d-none');
        $('#recommendationMoadl2').removeClass('d-none');
        $('#isDataTable tr').removeClass('bg-primary text-white');
        $('#isDataTable tr i').removeClass('text-white');
        $('#is_row_' + atob(is_id)).addClass('bg-primary text-white');
        $('#is_row_' + atob(is_id) + ' i').addClass('text-white');
        let is_id1 = atob(is_id);
        $('#is_id1').val(is_id1);
        $.ajax({
            url: "{{ route('ipd.indoor_sheet.medicine.list', '') }}/" + is_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                $('#IndoorSheetMedicineAdd').attr('onclick', "addRecommendation('" + is_id + "')");
                if (res.response == true) {
                    $('#ismDataTable').html(res?.data?.html);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    function addRecommendation(is_id) {
        let ism_id = $('#ism_id').val();
        let ism_recommendation = $('#ism_recommendation').val();
        if (ism_recommendation == '') {
            scrollTop('ism_recommendation');
            $('#ism_recommendation_err').text('Please enter recommendation');
            timeoutID('ism_recommendation_err', 3000);
        } else {
            $('#IndoorSheetMedicineAdd').addClass('spinner spinner-white spinner-right');
            $('#IndoorSheetMedicineAdd').attr('disabled', true);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                url: "{{ route('ipd.indoor_sheet.medicine.add') }}",
                method: "POST",
                data: {
                    is_id: is_id,
                    ism_id: ism_id,
                    ism_recommendation: ism_recommendation
                },
                success: function(res) {
                    if (res.response == true) {
                        if (ism_id == '') {
                            $('#ism_recommendation').val('');
                            $('#ismDataTable').prepend(res.data.html);
                        } else {
                            $('#ism_id').val('');
                            $('#ism_recommendation').val('');
                            $('#ism_row_' + ism_id + ' td:nth-child(1)').text(ism_recommendation);
                        }
                        $('#IndoorSheetMedicineAdd').html('Add <i class="la la-plus"></i>');
                        sweetAlertSuccess(res.message, 3000);
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                    $('#IndoorSheetMedicineAdd').removeClass('spinner spinner-white spinner-right');
                    $('#IndoorSheetMedicineAdd').attr('disabled', false);
                },
                error: function(r) {
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                    $('#IndoorSheetMedicineAdd').removeClass('spinner spinner-white spinner-right');
                    $('#IndoorSheetMedicineAdd').attr('disabled', false);
                }
            });
        }
    }

    function editRecommendation(ism_id) {
        let ism_id1 = atob(ism_id);
        console.log(ism_id1);
        let recommendation = $('#ism_row_' + ism_id1 + ' td:nth-child(1)').text();
        console.log(recommendation);
        $('#ism_recommendation').val(recommendation);
        $('#ism_id').val(ism_id1);
        $('#IndoorSheetMedicineAdd').html('Update <i class="la la-plus"></i>');
    }

    function removeRecommendation(ism_id) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            url: "{{ route('ipd.indoor_sheet.medicine.remove', '') }}/" + ism_id,
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    if (res.response == true) {
                        $('#ism_row_' + atob(ism_id)).remove();
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }
    /* End:: Indoor Sheet Medicine */
    /* Start:: Examination Sheet */
    $('body').on('click', '#exSheet', function(event) {
        $('#exSheetModal').modal('show');
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.examination_sheet.list', '') }}/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    $('#exSheetPatient').text(res?.data?.patientName);
                    $('#exSheetSurgery').text(res?.data?.ipdDetail?.ipd_surgery_text);
                    $('#exDataTable').html(res?.data?.html);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    function showExaminationRecommenadtion(is_id) {
        $('#exRecommendationMoadl').removeClass('d-none');
        $('#exRecommendationMoad2').removeClass('d-none');
        $('#examinationModall').removeClass('d-none');
        $('#examinationModal2').removeClass('d-none');
        $('#examinationModal3').removeClass('d-none');
        $('#exDataTable tr').removeClass('bg-primary text-white');
        $('#exDataTable tr i').removeClass('text-white');
        $('#exs_row_' + atob(is_id)).addClass('bg-primary text-white');
        $('#exs_row_' + atob(is_id) + ' i').addClass('text-white');
        $.ajax({
            url: "{{ route('ipd.examination_sheet.medicine.list', '') }}/" + is_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                if (res.response == true) {
                    $('#exmDataTable').html(res?.data?.html);
                    $('#exm1DataTable').html(res?.data?.html1);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    function AddExaminationMeicine() {
        let exm_id = [];
        $('input[name="exm_id[]"]').each(function() {
            exm_id.push($(this).val());
        });
        let is_id = [];
        $('input[name="is_id[]"]').each(function() {
            is_id.push($(this).val());
        });
        let exm_checked = [];
        $('input[name="exm_checked[]"]').each(function() {
            if ($(this).prop('checked') == true) {
                exm_checked.push(1);
            } else {
                exm_checked.push(0);
            }
        });
        let isme_given_datetime = [];
        $('input[name="isme_given_datetime[]"]').each(function() {
            isme_given_datetime.push($(this).val());
        });
        var remark = [];
        $("textarea.remarkMessage").each(function() {
            remark.push($(this).val());
        })
        $('#esmRecommendationBtn').addClass('spinner spinner-white spinner-right');
        $('#esmRecommendationBtn').attr('disabled', true);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            url: "{{ route('ipd.examination_sheet.medicine.add') }}",
            method: "POST",
            data: {
                is_id: is_id,
                exm_id: exm_id,
                exm_checked: exm_checked,
                remark: remark,
                isme_given_datetime: isme_given_datetime
            },
            success: function(res) {
                console.log(res);
                if (res.response == true) {
                    //$('#exmDataTable').html(res?.data?.html);
                    $('#exm1DataTable').prepend(res?.data?.html);
                    $('#exmDataTable textarea').val('');
                    $('#exmDataTable tr td:nth-child(3) input').val('');
                    $('#exmDataTable input[type="checkbox"]').prop('checked', false);
                }
                sweetAlertSuccess(res.message, 3000);
                $('#esmRecommendationBtn').removeClass('spinner spinner-white spinner-right');
                $('#esmRecommendationBtn').attr('disabled', false);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
                $('#esmRecommendationBtn').removeClass('spinner spinner-white spinner-right');
                $('#esmRecommendationBtn').attr('disabled', false);
            }
        });

    }

    function removeExamination(isme_id) {
        $.ajax({
            url: "{{ route('ipd.examination_sheet.medicine.remove', '') }}/" + isme_id,
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    if (res.response == true) {
                        $('#isme_row_' + atob(isme_id)).remove();
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    function editExamination(isme_id) {
        let isme_id1 = atob(isme_id);
        $.ajax({
            url: "{{ route('ipd.examination_sheet.medicine.edit', '') }}/" + isme_id,
            method: "GET",
            success: function(res) {
                console.log(res);
                if (res.response == true) {
                    console.log(res.data.examinationData.remark);
                    $('#isme_given_datetime1').val(res.data.given_date);
                    $('#ramerakData1').val(res.data.examinationData.remark);
                    $('#isme_id1').val(res.data.examinationData.isme_id);
                    modalScrollTop('exSheetModal', 'ramerakData1');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    $('#updateExaminationBtn').on('click', function() {
        let isme_id = $('#isme_id1').val();
        if (isme_id == '') {
            sweetAlertError('Please edit examination first', 3000);
        } else {
            let isme_given_datetime = $('#isme_given_datetime1').val();
            let remark = $('#ramerakData1').val();
            $('#updateExaminationBtn').addClass('spinner spinner-white spinner-right');
            $('#updateExaminationBtn').attr('disabled', true);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('ipd.examination_sheet.medicine.update') }}",
                method: "POST",
                data: {
                    isme_id: isme_id,
                    isme_given_datetime: isme_given_datetime,
                    remark: remark
                },
                success: function(res) {
                    if (res.response == true) {
                        console.log(res.data);
                        $('#isme_row_' + isme_id + ' td:nth-child(3)').text(res.data.datetime);
                        $('#isme_row_' + isme_id + ' td:nth-child(4)').text(res.data.isme_created_datetime);
                        $('#isme_row_' + isme_id + ' td:nth-child(5)').text(res.data.remark);
                        $('#isme_row_' + isme_id + ' td:nth-child(6)').text(res.data.added_by);

                        $('#isme_given_datetime1').val('');
                        $('#ramerakData1').val('');
                        $('#isme_id1').val('');
                        sweetAlertSuccess(res.message, 3000);
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                    $('#updateExaminationBtn').removeClass('spinner spinner-white spinner-right');
                    $('#updateExaminationBtn').attr('disabled', false);
                },
                error: function(r) {
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                    $('#updateExaminationBtn').removeClass('spinner spinner-white spinner-right');
                    $('#updateExaminationBtn').attr('disabled', false);
                }
            });
        }
    });

    function closeEaxminationSheet() {
        $('#exDataTable').html('');
        $('#exRecommendationMoadl').addClass('d-none');
        $('#exRecommendationMoad2').addClass('d-none');
        $('#exmDataTable').html('');
        $('#examinationModall').addClass('d-none');
        $('#examinationModal2').addClass('d-none');
        $('#examinationModal3').addClass('d-none');
        $('#exm1DataTable').html('');
    }
    /* End:: Examination Sheet */

    /* Export IPD Details */
    function exportIPD() {
        let search_text = $('#search_text').val();
        let admit_date_range = $('#admit_date_range').val();
        let query = '?search_text=' + search_text + '&admit_date_range=' + admit_date_range;
        window.location.href = "{{ route('ipd.export') }}" + query;
    }

    $('body').on('click', '#fullView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let photo = '';
                    if (data.photo != '') {
                        photo = '<img src="' + data.photo + '" class="img-fluid" />';
                    }
                    let mediclaim = 'No';
                    let foc = 'No';
                    if (data.ipd_mediclaim == 'yes') {
                        mediclaim = 'Yes';
                    }
                    if (data.ipd_is_foc == 'yes') {
                        foc = 'Yes';
                    }
                    let view = '<tr> \
                        <th>IPD ID</th> \
                        <td>' + $.trim(data.ipd_id) + '</td> \
                        <th>Admit Date</th> \
                        <td>' + $.trim(data.ipd_admit_date) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Room No</th> \
                        <td>' + $.trim(data.room_no) + '</td> \
                        <th>Doctor</th> \
                        <td>' + $.trim(data.doctor_name) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Patient ID</th> \
                        <td>' + $.trim(data.pa_id) + '</td> \
                        <th>Patient Name</th> \
                        <td>' + $.trim(data.patient_name) + '</td> \
                    </tr> \
                    <tr> \
                        <th>DOB</th> \
                        <td>' + $.trim(data.patient_dob) + '</td> \
                        <th>Age</th> \
                        <td>' + $.trim(data.patient_age) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Contact No</th> \
                        <td>' + $.trim(data.patient_contact_no) + '</td> \
                        <th>Date of Surgery</th> \
                        <td>' + $.trim(data.ipd_surgery_date) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Type of Surgery</th> \
                        <td>' + $.trim(data.ipd_surgery_text) + '</td> \
                        <th>Bill Amount</th> \
                        <td>' + $.trim(data.ipd_bill_amount) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Received Amount</th> \
                        <td>' + $.trim(data.ipd_received_amount) + '</td> \
                        <th>Mediclaim</th> \
                        <td>' + $.trim(mediclaim) + '</td> \
                    </tr> \
                    <tr> \
                        <th>Is FOC</th> \
                        <td>' + $.trim(foc) + '</td> \
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
    });

    function statusModal(ipd_id) {
        $('#statusModal').modal('show');
        // $('#admitStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "admit")');
        // $('#dischargedStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "discharged")');
        // $('#cancelledStatus').attr('onclick', 'changeStatus("' + ipd_id.toString() + '", "cancelled")');
        $('#statusButton').attr('onclick', 'changeStatus("' + ipd_id.toString() + '")');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(result) {
                if (result.response === true) {
                    let data = result.data;
                    $('#ip_status_val').val(data.ipd_status);
                    if (data.ipd_status == 'discharged') {
                        $('#dischargeStatusVal').removeClass('d-none');
                        $('#cancelStatusVal').addClass('d-none');
                    } else if (data.ipd_status == 'cancelled') {
                        $('#dischargeStatusVal').addClass('d-none');
                        $('#cancelStatusVal').removeClass('d-none');
                    } else {
                        $('#dischargeStatusVal').addClass('d-none');
                        $('#cancelStatusVal').addClass('d-none');
                    }
                    $('#ipd_discharge_date').val(data.ipd_discharge_date);
                    $('#ipd_diagnosis').val(data.ipd_diagnosis);
                    $('#ipd_investigations').val(data.ipd_investigations);
                    $('#ipd_treatment_given').val(data.ipd_treatment_given);
                    $('#ipd_treatment_discharge').val(data.ipd_treatment_discharge);
                    $('#ipd_cancel_reason').val(data.ipd_cancel_reason);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    function changeStatusVal(ip_status_val) {
        if (ip_status_val == 'cancelled') {
            $('#dischargeStatusVal').addClass('d-none');
            $('#cancelStatusVal').removeClass('d-none');
        } else if (ip_status_val == 'discharged') {
            $('#dischargeStatusVal').removeClass('d-none');
            $('#cancelStatusVal').addClass('d-none');
        } else {
            $('#dischargeStatusVal').addClass('d-none');
            $('#cancelStatusVal').addClass('d-none');
        }
    }

    function ResetDischargeDate() {
        $('#ipd_discharge_date').val('');
    }

    function ResetFollowUpDate() {
        $('#ipd_follow_up_date').val('');
    }

    function changeStatus(ipd_id) {
        let ip_status_val = $('#ip_status_val').val();
        let ipd_discharge_date = $('#ipd_discharge_date').val();
        let ipd_follow_up_date = $('#ipd_follow_up_date').val();
        let ipd_diagnosis = $('#ipd_diagnosis').val();
        let ipd_investigations = $('#ipd_investigations').val();
        let ipd_treatment_given = $('#ipd_treatment_given').val();
        let ipd_treatment_discharge = $('#ipd_treatment_discharge').val();
        let ipd_cancel_reason = $('#ipd_cancel_reason').val();
        let stringVal = btoa(ipd_id + '[]' + ip_status_val + '[]' + ipd_cancel_reason + '[]' + ipd_discharge_date + '[]' + ipd_diagnosis + '[]' + ipd_investigations + '[]' + ipd_treatment_given + '[]' + ipd_treatment_discharge + '[]' + ipd_follow_up_date);
        $.ajax({
            url: "{{ route('ipd.status', '') }}" + "/" + stringVal,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let removeClass = 'bg-primary bg-success bg-danger';
                    let addClass = '';
                    let addText = '';
                    if (ip_status_val == 'admit') {
                        addClass = 'bg-primary';
                        addText = 'Admit';
                    } else if (ip_status_val == 'discharged') {
                        addClass = 'bg-success';
                        addText = 'Discharged';
                    } else {
                        addClass = 'bg-danger';
                        addText = 'Cancelled';
                    }
                    $('#status_' + atob(ipd_id)).removeClass(removeClass);
                    $('#status_' + atob(ipd_id)).addClass(addClass);
                    $('#status_' + atob(ipd_id)).text(addText);
                    sweetAlertSuccess(res.message, 3000);
                    $('#statusModal').modal('hide');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    /* IPD Document */
    $('body').on('click', '#IPDDocument', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.doc.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                $('#ipd_id_doc').val(ipd_id);
                $('#ipdDocData').html(res.data);
                $('#ipdDocViewModal').modal('show');
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    $('#submitDocument').on('submit', function(e) {
        e.preventDefault();
        let name = $('#ipd_doc_name').val();
        let file = $('#ipd_doc').val();
        if (name == '') {
            $('#ipd_doc_name_err').text('Please enter doc name');
        } else if (file == '') {
            $('#ipd_doc_err').text('Please select document');
        } else {
            $('#docAdd').addClass('spinner spinner-white spinner-right');
            $('#docAdd').attr('disabled', true);
            let formData = new FormData(this);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                url: "{{ route('ipd.doc.send') }}",
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: (res) => {
                    if (res.response == true) {
                        $('#ipdDocData').prepend(res.data);
                    } else {
                        sweetAlertError(res.message, 3000);
                    }
                    $('#docAdd').removeClass('spinner spinner-white spinner-right');
                    $('#docAdd').attr('disabled', false);
                },
                error: function(r) {
                    let res = r.responseJSON;
                    sweetAlertError(res.message, 3000);
                    $('#docAdd').removeClass('spinner spinner-white spinner-right');
                    $('#docAdd').attr('disabled', false);
                }
            });
        }
    });

    function removerDoc(id) {
        $.ajax({
            url: "{{ route('ipd.doc.remove') }}/" + id,
            method: "GET",
            success: function(res) {
                if (res.response == true) {
                    $('#doc_row_' + id).remove();
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    /* Show Bill Amount Modal */
    $('body').on('click', '#billAmountView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let view = '<div class="row"> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_name">Patient Name</label> \
                            <input type="text" class="form-control" name="patient_name" id="patient_name" value="' + data.patient_name + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="surgery_type">Type of Surgery</label> \
                            <input type="text" class="form-control" name="surgery_type" id="surgery_type" value="' + data.ipd_surgery_text + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="ipd_bill_amount_update">Bill Amount</label> \
                            <input type="text" class="form-control" name="ipd_bill_amount_update" id="ipd_bill_amount_update" value="' + data.ipd_bill_amount + '" /> \
                        </div> \
                        <div class="col-12 form-group"> \
                            <button class="btn btn-primary" id="bill_amount_update_btn" onclick="updateBillAmount(' + atob(ipd_id) + ')">Update</button> \
                        </div> \
                    </div>';

                    $('#billAmountViewDetail').html(view);
                    $('#billAmountViewModal').modal('show');
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
    /* Update Bill Amount */
    function updateBillAmount(ipd_id) {
        let ipd_bill_amount = $('#ipd_bill_amount_update').val();
        $.ajax({
            url: "{{ route('ipd.bill_amount.update', '') }}" + '/' + btoa(ipd_id) + '?ipd_bill_amount=' + ipd_bill_amount,
            method: "get",
            success: function(res) {
                if (res.response === true) {
                    $('#billAmountShow_' + ipd_id).text(ipd_bill_amount);
                    $('#billAmountViewModal').modal('hide');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    /* Operative Note Show */
    $('body').on('click', '#operativeNoteView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.operative_note.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data;
                    let view = '<div class="row"> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_name">Patient Name</label> \
                            <input type="text" class="form-control" name="patient_name" id="patient_name" value="' + data.patient_name + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_age">Patient Age</label> \
                            <input type="text" class="form-control" name="patient_age" id="patient_age" value="' + data.patient_age + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="surgery_type">Type of Surgery</label> \
                            <input type="text" class="form-control" name="surgery_type" id="surgery_type" value="' + data.ipd_surgery_text + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="ion_date">Print Date <span class="text-danger">*</span></label> \
                            <input type="date" class="form-control" name="ion_date" id="ion_date" value="' + data.ion_date + '" /> \
                            <span class="text-danger" id="ion_dateErr"></span> \
                        </div> \
                        <div class="col-12 form-group"> \
                            <label for="ion_note">Operative Note <span class="text-danger">*</span></label> \
                            <textarea class="form-control" name="ion_note" id="ion_note" rows="15">' + data.ion_note + '</textarea> \
                            <span class="text-danger" id="ion_noteErr"></span> \
                        </div> \
                        <div class="col-12 form-group"> \
                            <button class="btn btn-primary" id="operative_note_update_btn" onclick="updateOperativeNote(' + atob(ipd_id) + ')">Update</button> \
                            <button class="btn btn-info" id="operativeNotPrint" data-id="' + btoa(data.ipd_id) + '">Print <i class="flaticon flaticon2-print cursor_pointer"></i></button> \
                        </div> \
                    </div>';

                    $('#operativeNoteViewDetail').html(view);
                    $('#operativeNoteViewModal').modal('show');
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

    /* Operative not print */
    $('body').on('click', '#operativeNotPrint', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.operative_note.print', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Operation Medicine print */
    $('body').on('click', '#operationMedicinePrint', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.operation_medicine.print', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Update Operative Note */
    function updateOperativeNote(ipd_id) {
        let ion_date = $('#ion_date').val();
        let ion_note = $('#ion_note').val();
        $.ajax({
            url: "{{ route('ipd.operative_note.update', '') }}" + '/' + btoa(ipd_id) + '?ion_date=' + ion_date + '&ion_note=' + ion_note,
            method: "get",
            success: function(res) {
                if (res.response === true) {
                    sweetAlertSuccess(res.message, 3000);
                    //$('#operativeNoteViewModal').modal('hide');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    /* Prescription Show */
    $('body').on('click', '#prescribeView', function(event) {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.prescription.view', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let medicineList = res.data.medicineList;
                    let data = res.data.data;
                    let ipdMedicine = data.ipd_operation_medicine;

                    let list = '';

                    if (medicineList.length > 0) {
                        for (let i = 0; i < medicineList.length; i++) {
                            let medicineVal = 0;
                            if (ipdMedicine != null) {
                                ipdMedicine.map(function(val) {
                                    if (val.medicine_id == medicineList[i].om_id) {
                                        medicineVal = val.medicine_val;
                                    }
                                });
                            }
                            // list += '<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12"> \
                            //     <label for="medicine_' + medicineList[i].om_id + '">' + medicineList[i].om_name + ' (' + medicineList[i].om_company_name + ')</label> \
                            //     <input type="number" class="form-control" name="medicine[]" id="medicine_' + medicineList[i].om_id + '" value="' + medicineVal + '"  /> \
                            // </div>';
                            list += '<table> \
                                <tr> \
                                <td for="medicine_' + medicineList[i].om_id + '">' + medicineList[i].om_name + ' (' + medicineList[i].om_company_name + ')</td> \
                                <td> \
                                <input type="number" class="form-control" name="medicine[]" id="medicine_' + medicineList[i].om_id + '" value="' + medicineVal + '"  /> \
                                </td> \
                                </tr> \
                            </table>';
                        }
                    }

                    let view = '<div class="row"> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_name">Patient Name</label> \
                            <input type="text" class="form-control" name="patient_name" id="patient_name" value="' + data.patient_name + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="patient_age">Patient Age</label> \
                            <input type="text" class="form-control" name="patient_age" id="patient_age" value="' + data.patient_age + '" disabled /> \
                        </div> \
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-2 form-group"> \
                            <label for="ipd_operation_medicine_date">Print Date <span class="text-danger">*</span></label> \
                            <input type="date" class="form-control" name="ipd_operation_medicine_date" id="ipd_operation_medicine_date" value="' + data.ipd_operation_medicine_date + '" /> \
                            <span class="text-primary cursor_pointer" onclick="ResetOperationMedicineDate()">Reset</span> \
                        </div> \
                        <hr> \
                        <div class="col-12 form-group"> \
                            <strong class="">Medicine</strong> \
                        </div> \
                        <div class="col-12"> \
                            <div class="row">' + list + '</div> \
                        </div> \
                        <div class="col-12 form-group pt-4"> \
                            <button class="btn btn-primary" id="operative_note_update_btn" onclick="updateOperationMedicine(' + atob(ipd_id) + ')">Update</button> \
                            <button class="btn btn-info" id="operationMedicinePrint" data-id="' + btoa(data.ipd_id) + '">Print <i class="flaticon flaticon2-print cursor_pointer"></i></button> \
                        </div> \
                    </div>';

                    $('#prescribeViewDetail').html(view);
                    $('#prescribeViewModal').modal('show');
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

    /* IPD Print */
    $('body').on('click', '#IPDPrint', function() {
        let ipd_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.bill.print', '') }}" + "/" + ipd_id,
            method: "GET",
            success: function(res) {
                printData(res);
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    });

    /* Reset Operation Medicine Date */
    function ResetOperationMedicineDate() {
        $('#ipd_operation_medicine_date').val('');
    }

    /* Operation Medicine Update */
    function updateOperationMedicine(ipd_id) {
        let ipd_operation_medicine_date = $('#ipd_operation_medicine_date').val();
        let medicine_arr = [];
        $('input[name^=medicine]').map(function(idx, elem) {
            medicine_arr.push($(elem).val());
        }).get();
        $.ajax({
            url: "{{ route('ipd.prescription.update', '') }}" + '/' + btoa(ipd_id) + '?ipd_operation_medicine_date=' + ipd_operation_medicine_date + '&medicine_arr=' + btoa(medicine_arr),
            method: "get",
            success: function(res) {
                if (res.response === true) {
                    sweetAlertSuccess(res.message, 3000);
                    //$('#operativeNoteViewModal').modal('hide');
                } else {
                    sweetAlertError(res.message, 3000);
                }
            },
            error: function(r) {
                let res = r.responseJSON;
                sweetAlertError(res.message, 3000);
            }
        });
    }

    /* OPD History Show */
    $('body').on('click', '#opdHistoryView', function(event) {
        let pa_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.opd_history', '') }}" + "/" + pa_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data.list;
                    let total_fees = res.data.total_fees;
                    let total_additional_fees = res.data.total_additional_fees;
                    $('#opd_total_fees').text(total_fees + total_additional_fees);
                    $('#opdHistoryViewDetail').html(data);
                    $('#opdHistoryViewModal').modal('show');
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

    /* IPD History Show */
    $('body').on('click', '#ipdHistoryView', function(event) {
        let pa_id = $(this).data('id');
        $.ajax({
            url: "{{ route('ipd.ipd_history', '') }}" + "/" + pa_id,
            method: "GET",
            success: function(res) {
                if (res.response === true) {
                    let data = res.data.list;
                    let total_bill = res.data.total_bill;
                    let total_received = res.data.total_received;
                    $('#ipd_total_bill').text(total_bill);
                    $('#ipd_total_received').text(total_received);
                    $('#ipdHistoryViewDetail').html(data);
                    $('#ipdHistoryViewModal').modal('show');
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