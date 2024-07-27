<!DOCTYPE html>
<html>

<head>
    <title>IPD Detail</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-style: italic;">
    <div style="border:2px solid; width:100%; text-align:center; padding-top:20px; padding-bottom:20px;">
        <img src="{{ url('assets/eva/img/logo/eva-logo.png') }}" style="max-width:200px;" />
        <h3 style="margin-bottom:0px; padding-bottom:10px;">
            IPD Detail
        </h3>
        <h3 style="margin-bottom:0px; padding-bottom:10px;">
            {{ $data1['ipd_surgery_text'] }}
        </h3>
        <table style="margin:auto; width:100%">
            <tr>
                <td colspan="6">
                    <h3 style="margin-bottom:0px; padding-top:10px; padding-bottom:10px; text-align:left; border-top:1px solid; border-bottom:1px solid;">
                        Patient Detail
                    </h3>
                </td>
            </tr>
            <tr>
                <td style="padding:10px;"><strong>Patient ID</strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['patient_id'] }}</td>
                <td style="padding:10px;"><strong>Patient Name</strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['patient_name'] }}</td>
            </tr>
            <tr>
                <td style="padding:10px;"><Strong>Age</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['patient_age'] }}</td>
                <td style="padding:10px;"><strong>Date</strong></td>
                <td style="padding:10px;" colspan="2">{{ date('d M Y') }}</td>
            </tr>
            <tr>
                <td colspan="6">
                    <h3 style="margin-bottom:0px; padding-top:10px; padding-bottom:10px; text-align:left; border-top:1px solid; border-bottom:1px solid;">
                        IPD Detail
                    </h3>
                </td>
            </tr>
            <tr>
                <td style="padding:10px;"><Strong>IPD ID</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['ipd_id'] }}</td>
                <td style="padding:10px;"><Strong>Doctor</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['doctor'] }}</td>
            </tr>
            <tr>
                <td style="padding:10px;"><strong>Room</strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['room'] }}</td>
                <td style="padding:10px;"><Strong>Date of Admit</Strong></td>
                <td style="padding:10px;" colspan="2">{{ date('d M Y', strtotime($data1['ipd_admit_date'])) }}</td>
            </tr>
            <tr>
                <td style="padding:10px;"><strong>Date of Surgery</strong></td>
                <td style="padding:10px;" colspan="2">{{ ($data1['ipd_surgery_date'] != null && $data1['ipd_surgery_date'] != '0000-00-00') ? date('d M Y', strtotime($data1['ipd_surgery_date'])) : '' }}</td>
                <td style="padding:10px;"><Strong>Type of Surgery</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['ipd_surgery_text'] }}</td>
            </tr>
            <tr>
                <td style="padding:10px;"><strong>Discharge Date</strong></td>
                <td style="padding:10px;" colspan="2">{{ ($data1['ipd_discharge_date'] != null && $data1['ipd_discharge_date'] != '0000-00-00') ? date('d M Y', strtotime($data1['ipd_discharge_date'])) : '' }}</td>
                <td style="padding:10px;"><strong>Follow Up Date</strong></td>
                <td style="padding:10px;" colspan="2">{{ ($data1['ipd_follow_up_date'] != null && $data1['ipd_follow_up_date'] != '0000-00-00') ? date('d M Y', strtotime($data1['ipd_follow_up_date'])) : '' }}</td>
            </tr>
            <tr>
                <td style="padding:10px;"><Strong>Diagnosis</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['ipd_diagnosis'] }}</td>
                <td style="padding:10px;"><Strong>Investigatinos</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['ipd_investigations'] }}</td>
            </tr>
            <tr>
                <td style="padding:10px;"><Strong>Treatment Given</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['ipd_treatment_given'] }}</td>
                <td style="padding:10px;"><Strong>Treatment on Discharge</Strong></td>
                <td style="padding:10px;" colspan="2">{{ $data1['ipd_treatment_discharge'] }}</td>
            </tr>
        </table>
    </div>
</body>

</html>