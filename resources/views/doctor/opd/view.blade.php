<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">OPD Detail
            </h3>
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
                    <td>{{ ($data->patientData->pa_referred_by == 'doctor') ? $data->patientData->pa_referred_doctor : $data->patientData->pa_referred_text }}</td>
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
        <h3>Appointment Detail - {{ $data->ap_id }}</h3>
        <div class="d-flex align-items-center bg-light-success rounded p-5 mb-5">
            <table class="table">
                <tr>
                    <td><strong>Date</strong></td>
                    <td>{{ date('d M Y', strtotime($data->ap_date)) }}</td>
                    <td><strong>Height</strong></td>
                    <td>{{ $data->ap_height }}</td>
                </tr>
                <tr>
                    <td><strong>Weight</strong></td>
                    <td>{{ $data->ap_weight }}</td>
                    <td><strong>BP</strong></td>
                    <td>{{ $data->ap_bp }}</td>
                </tr>
                <tr>
                    <td><strong>Booked Via</strong></td>
                    <td>{{ $data->ap_book_via }}</td>
                    <td><strong>Case Type</strong></td>
                    <td>{{ ucfirst($data->ap_case_type) }}</td>
                </tr>
                <tr>
                    <td><strong>Fees</strong></td>
                    <td>{{ $data->ap_charge }}</td>
                    <td><strong>Additional Charge</strong></td>
                    <td>{{ $data->ap_additional_charge }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>