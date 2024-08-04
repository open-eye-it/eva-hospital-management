<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">IPD Detail
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
            </table>
        </div>
    </div>
</div>