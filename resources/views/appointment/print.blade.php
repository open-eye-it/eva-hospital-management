<!DOCTYPE html>
<html>

<head>
    <title>{{ $data->tr_name }}</title>
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
    </style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-style: italic;">
    <table>
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
                                OPD BILL
                            </h3>
                            Date: <strong>{{ date('d M Y') }}</strong>
                            <table style="margin:auto;">
                                <tr>
                                    <td style="padding:10px;"><strong>Patient ID</strong></td>
                                    <td style="padding:10px;">{{ $data->pa_id }}</td>
                                    <td style="padding:10px;"><strong>Patient Name</strong></td>
                                    <td style="padding:10px;">{{ $data->patientData->pa_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Bill No</Strong></td>
                                    <td style="padding:10px;">{{ $data->ap_id }}</td>
                                    <td style="padding:10px;"><strong>Address</strong></td>
                                    <td style="padding:10px;">{{ $data->patientData->pa_address.' '.$data->patientData->pa_city.' '.$data->patientData->pa_pincode.' '.$data->patientData->pa_state }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Appointment Date</Strong></td>
                                    <td style="padding:10px;">{{ date('d M Y', strtotime($data->ap_date)) }}</td>
                                    <td style="padding:10px;"><strong>Doctor</strong></td>
                                    <td style="padding:10px;">{{ $data->doctorData->person_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Refer By</Strong></td>
                                    <td style="padding:10px;">{{ ($data->patientData->pa_referred_by == 'doctor') ? $data->patientData->pa_referred_doctor : $data->patientData->pa_referred_text }}</td>
                                </tr>
                                <tr>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">Services / Charges Description</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:center;">Qty. / Visit</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">Rate / Charges (Rs.)</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; text-align:left;">Amount (Rs.)</th>
                                </tr>
                                <tr>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">Case - {{ ucfirst($data->ap_case_type) }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:center;">-</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:right;">{{ $data->ap_charge }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; text-align:right;">{{ $data->ap_charge }}</td>
                                </tr>
                                @if(!empty($data->appointmentAdditionalChargesList->toArray()))
                                @foreach($data->appointmentAdditionalChargesList as $additionalCharge)
                                <tr>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">{{ $additionalCharge->apac_desc }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:center;">{{ $additionalCharge->apac_qty }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:right;">{{ $additionalCharge->apac_charge }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; text-align:right;">{{ $additionalCharge->apac_final_charge }}</td>
                                </tr>
                                @endforeach
                                @endif
                                <!-- <tr>
                                    <td style="padding:10px;"></td>
                                    <td style="padding:10px; border-right:1px solid;"></td>
                                    <th style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:left;">Case - {{ ucfirst($data->ap_case_type) }}</th>
                                    <td style="padding:10px; border-bottom:1px solid;">{{ $data->ap_charge }}</td>
                                </tr> -->
                                <!-- <tr>
                                    <td style="padding:10px;"></td>
                                    <td style="padding:10px; border-right:1px solid;"></td>
                                    <th style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:left;">Total</th>
                                    <td style="padding:10px; border-bottom:1px solid;">{{ $data->ap_additional_charge }}</td>
                                </tr> -->
                                <tr>
                                    <td style="padding:10px; border-bottom:1px solid;"></td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;"></td>
                                    <th style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:left;">Final Amount</th>
                                    <td style="padding:10px; border-bottom:1px solid; text-align:right;">{{ $data->ap_charge+$data->ap_additional_charge }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding:10px; text-align:left;"><strong>Amount In Words:</strong>
                                        @php
                                        echo numberToWord($data->ap_charge+$data->ap_additional_charge);
                                        @endphp
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <table style="width:100%; margin-top:5px;">
                                <tr>
                                    <td><strong>Prepared By</strong></td>
                                    <td style="text-align:right;"><strong>Checked By</strong></td>
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