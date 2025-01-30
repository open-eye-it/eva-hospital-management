<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Appointment ID</th>
            <th>Date</th>
            <th>Doctor</th>
            <th>Patient ID</th>
            <th>Patient Name</th>
            <th>Patient DOB</th>
            <th>Patient Age</th>
            <th>Case Type</th>
            <th>Is FOC</th>
            <th>Fee</th>
            <th>Additional Charge</th>
            <th>Has Madiclaim</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @if(!$list->isEmpty())
        @php $i=1; @endphp
        @foreach($list as $key => $appointment)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $appointment->ap_id }}</td>
            <td>{{ $appointment->ap_date }}</td>
            <td>{{ $appointment->doctorData->person_name }}</td>
            <td>{{ $appointment->pa_id }}</td>
            <td>{{ $appointment->patientData->pa_name }}</td>
            <td>{{ date('d M Y', strtotime($appointment->patientData->pa_dob)) }}</td>
            <td>{{ $appointment->patientData->pa_age }}</td>
            <td>{{ $appointment->ap_case_type }}</td>
            <td>{{ ucFirst($appointment->ap_is_foc) }}</td>
            <td>{{ ucFirst($appointment->ap_charge) }}</td>
            <td>{{ ucFirst($appointment->ap_additional_charge) }}</td>
            <td>{{ ($appointment->ap_pament_mode == 'mediclaim') ? 'Yes' : 'No' }}</td>
            <td>{{ ucfirst($appointment->ap_status) }}</td>
            <td>{{ date('d M Y', strtotime($appointment->created_at)) }}</td>
        </tr>
        @php $i++; @endphp
        @endforeach
        @else
        <tr>
            <td colspan="15">Record not found</td>
        </tr>
        @endif
    </tbody>
</table>