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
                            <img src="{{ url('assets/eva/img/logo/eva-logo.png') }}" style="max-width:200px;" />
                            <h3 style="margin-top:0px; margin-bottom:0px; padding-bottom:10px;">
                                Operative Notes
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
                                            Operative Note
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Print Date</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ date('d M Y', strtotime($data1['ion_date'])) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="6"><Strong>Note</Strong></td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="6">{{ $data1['ion_note'] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td colspan="2">
                                        Dr. {{ $data1['doctor'] }}
                                    </td>
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