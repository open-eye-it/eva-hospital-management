<!DOCTYPE html>
<html>

<head>
    <title>Operative Notes</title>
    <style>
        .header,
        .header-space {
            height: 180px;
        }

        .footer,
        .footer-space {
            height: 120px;
        }

        .header {
            position: fixed;
            top: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }
    </style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-style: italic;">
    <table style="margin:auto; width:100%">
        <thead>
            <tr>
                <td>
                    <div class="header-space">&nbsp;</div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <div style="border:2px solid; width:100%; text-align:center;">
                            <!-- <img src="{{ url('assets/eva/img/logo/eva-logo.png') }}" style="max-width:200px;" /> -->
                            <h3 style="margin-top:0px; margin-bottom:0px; padding-bottom:10px;">
                                Discharge Summary
                            </h3>
                            <h3 style="margin-bottom:0px; padding-bottom:10px;">
                                {{ date('d M Y') }}
                            </h3>
                            <table style="margin:auto; width:100%">
                                <tr>
                                    <td style="padding:10px;"><strong>Patient ID</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data1['patient_id'] }}</td>
                                    <td style="padding:10px;"><strong>Patient Name</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data1['patient_name'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Age</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data1['patient_age'] }}</td>
                                    <td style="padding:10px;"><strong>IPD Id</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data1['ipd_id'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Date of Admin</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ date('d M Y', strtotime($data1['ipd_admit_date'])) }}</td>
                                    <td style="padding:10px;"><strong>Date of Discharge</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ date('d M Y', strtotime($data1['ipd_discharge_date'])) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Diagnosis</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ $data1['ipd_diagnosis'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Investigation</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ $data1['ipd_investigations'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Operative Note</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ $data1['ion_note'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Treatment Given</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ $data1['ipd_treatment_given'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Treatment On Discharge</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ $data1['ipd_treatment_discharge'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>