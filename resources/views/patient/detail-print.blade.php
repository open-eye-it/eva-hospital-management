<!DOCTYPE html>
<html>

<head>
    <title>IPD Bill</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-style: italic;">
    <div style="border:2px solid; width:100%; text-align:center; padding-top:20px; padding-bottom:20px;">
        <img src="{{ url('assets/eva/img/logo/eva-logo.png') }}" style="max-width:200px;" />
        <h3 style="margin-bottom:0px; padding-bottom:7px;">
            Patient Details
        </h3>
        Date: <strong>{{ date('d M Y') }}</strong>
        <table style="margin:auto; width:100%;">
            <tr>
                <td style="padding:7px;"><strong>Patient ID</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_id }}</td>
                <td style="padding:7px;"><strong>Patient Name</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_name }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Contact No</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_contact_no }}</td>
                <td style="padding:7px;"><strong>Alternate Contact No</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_alt_contact_no }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Email</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_email }}</td>
                <td style="padding:7px;"><strong>Address</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_address }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>City</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_city }}</td>
                <td style="padding:7px;"><strong>Pin Code</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_pincode }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>State</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_state }}</td>
                <td style="padding:7px;"><strong>DOB</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_dob }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Age</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_age }}</td>
                <td style="padding:7px;"><strong>Gender</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_gender }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Marital Status</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_marital_status }}</td>
                <td style="padding:7px;"><strong>Occupation</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_occupation }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Last Menstrual Period</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_last_monestrual_period }}</td>
                <td style="padding:7px;"><strong>Number of Pregnancy</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_pregnancy_no }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Number of Miscarriages</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_miscarriages_no }}</td>
                <td style="padding:7px;"><strong>Number of Abortion</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_abortion_no }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Number of Living Children</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_children_no }}</td>
                <td style="padding:7px;"><strong>Photo</strong></td>
                <td style="padding:7px;"><img src="{{ ImagePath($patientData->pa_photo) }}" width="100px" /></td>
            </tr>
            <tr>
                <td style="padding:7px;" colspan="4"><Strong>Do you consume any of below?</Strong></td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Tobacco</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_tobacco }}</td>
                <td style="padding:7px;"><strong>Smoking</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_smoking }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Alcohol</Strong></td>
                <td style="padding:7px;" colspan="3">{{ $patientData->pa_alcohol }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Any medical or surgical history?</Strong></td>
                <td style="padding:7px;" colspan="3">{{ $patientData->pa_medical_history }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Family member had any medical or surgical history?</Strong></td>
                <td style="padding:7px;" colspan="3">{{ $patientData->pa_family_medical_history }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Referred By</Strong></td>
                <td style="padding:7px;">{{ $patientData->pa_referred_by }}</td>
                <td style="padding:7px;"><strong>Referred Doctor</strong></td>
                <td style="padding:7px;">{{ $patientData->pa_referred_doctor }}</td>
            </tr>
            <tr>
                <td style="padding:7px;"><Strong>Referred Name</Strong></td>
                <td style="padding:7px;" colspan="3">{{ $patientData->pa_referred_text }}</td>
            </tr>
        </table>
    </div>
</body>

</html>