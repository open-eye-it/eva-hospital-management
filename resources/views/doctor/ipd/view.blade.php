<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">IPD Detail
            </h3>
        </div>
        <div class="card-toolbar">
            <a href="{{ route('ipd.edit', base64_encode($data->ipd_id)) }}" title="Edit"><i class="la la-edit icon-3x px-1"></i></a>
            <span id="ipdBillAmountView" data-id="{{ base64_encode($data->ipd_id) }}" title="Bill Amount"><i class="la la-money-bill icon-3x cursor_pointer px-1"></i></span>
            <span id="operativeNoteView" data-id="{{ base64_encode($data->ipd_id) }}" title="Operative Notes"><i class="flaticon flaticon-notes icon-3x cursor_pointer px-1"></i></span>
            <span id="prescribeView" data-id="{{ base64_encode($data->ipd_id) }}" title="Prescribe"><i class="la la-pills icon-3x cursor_pointer px-1"></i></span>
            <span id="IPDPrint" data-id="{{ base64_encode($data->ipd_id) }}" title="IPD Detail"><i class="flaticon flaticon2-print icon-3x cursor_pointer px-1"></i></span>
        </div>
    </div>
    <div class="card-body">
        <h3>Patient Detail - {{ $data->patientData->pa_id }}</h3>
        <div class="d-flex align-items-center bg-light-success rounded p-5 mb-5">
            <table class="table">
                <tr>
                    <td><strong>Name</strong></td>
                    <td>{{ $data->patientData->pa_name }}</td>
                    <td><strong>Email</strong></td>
                    <td>{{ $data->patientData->pa_email }}</td>
                </tr>
                <tr>
                    <td><strong>DOB</strong></td>
                    <td>{{ $data->patientData->pa_dob }}</td>
                    <td><strong>Age</strong></td>
                    <td>{{ $data->patientData->pa_age }}</td>
                </tr>
                <tr>
                    <td><strong>Referred By</strong></td>
                    <td>{{ ucfirst($data->patientData->pa_referred_by) }}</td>
                    <td><strong>Referred Name</strong></td>
                    <td>{{ ($data->patientData->pa_recerred_by == 'doctor') ? $data->patientData->pa_referred_doctor : $data->patientData->pa_referred_text }}</td>
                </tr>
                <tr>
                    <td><strong>Contact No</strong></td>
                    <td>{{ $data->patientData->pa_contact_no }}</td>
                    <td><strong>City</strong></td>
                    <td>{{ $data->patientData->pa_city }}</td>
                </tr>
                <tr>
                    <td><strong>Pincode</strong></td>
                    <td>{{ $data->patientData->pa_pincode }}</td>
                    <td><strong>state</strong></td>
                    <td>{{ $data->patientData->pa_city }}</td>
                </tr>
                <tr>
                    <td><strong>Address</strong></td>
                    <td colspan="3">{{ $data->patientData->pa_address }}</td>
                </tr>
            </table>
        </div>
        <h3>IPD Detail - {{ $data->ipd_id }}</h3>
        <div class="d-flex align-items-center bg-light-success rounded p-5 mb-5">
            <table class="table">
                <tr>
                    <td><strong>Admit Date</strong></td>
                    <td>{{ date('d M Y', strtotime($data->ipd_admit_date)) }}</td>
                    <td><strong>Room No</strong></td>
                    <td>{{ $data->roomData->rm_building.'-'.$data->roomData->rm_floor.'-'.$data->roomData->rm_ward.'-'.$data->roomData->rm_no }}</td>
                </tr>
                <tr>
                    <td><strong>Date of Surgery</strong></td>
                    <td>{{ date('d M Y', strtotime($data->ipd_surgery_date)) }}</td>
                    <td><strong>Type of Surgery</strong></td>
                    <td>{{ $data->ipd_surgery_date }}</td>
                </tr>
                <tr>
                    <td><strong>Bill Amount</strong></td>
                    <td id="billAmountShow_{{ $data->ipd_id }}">{{ $data->ipd_bill_amount }}</td>
                    <td><strong>Received Amount</strong></td>
                    <td>{{ $data->ipd_received_amount }}</td>
                </tr>
                <tr>
                    <td><strong>Mediclaim</strong></td>
                    <td>{{ ($data->ipd_mediclaim == 'yes') ? 'Yes' : 'No' }}</td>
                    <td><strong>Id FOC</strong></td>
                    <td>{{ ($data->ipd_is_foc == 'yes') ? 'Yes' : 'No' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>