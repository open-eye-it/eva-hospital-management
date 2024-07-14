<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>IPD ID</th>
            <th>Admit Date</th>
            <th>Room No</th>
            <th>Doctor</th>
            <th>Patient ID</th>
            <th>Patient Name</th>
            <th>DOB</th>
            <th>Age</th>
            <th>Contact No</th>
            <th>Bill Amount</th>
            <th>Received Amount</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @if(!$list->isEmpty())
        @php $i=1; @endphp
        @foreach($list as $key => $ipd)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $ipd->ipd_id }}</td>
            <td>{{ date('d M Y', strtotime($ipd->ipd_admit_date)) }}</td>
            <td>{{ $ipd->roomData->rm_building.'-'.$ipd->roomData->rm_floor.'-'.$ipd->roomData->rm_ward.'-'.$ipd->roomData->rm_no }}</td>
            <td>{{ $ipd->doctorData->person_name }}</td>
            <td>{{ $ipd->pa_id }}</td>
            <td>{{ $ipd->patientData->pa_name }}</td>
            <td>{{ date('d M Y', strtotime($ipd->patientData->pa_dob)) }}</td>
            <td>{{ $ipd->patientData->pa_age }}</td>
            <td>{{ $ipd->patientData->pa_contact_no }}</td>
            <td>{{ $ipd->ipd_bill_amount }}</td>
            <td>{{ $ipd->ipd_received_amount }}</td>
            <td>{{ ucfirst($ipd->ipd_status) }}</td>
            <td>{{ date('d M Y', strtotime($ipd->created_at)) }}</td>
        </tr>
        @php $i++; @endphp
        @endforeach
        @else
        <tr>
            <td colspan="13">Record not found</td>
        </tr>
        @endif
    </tbody>
</table>