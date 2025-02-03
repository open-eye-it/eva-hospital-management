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
                                Prescription
                            </h3>
                            Date: <strong>{{ date('d M Y') }}</strong>

                            <table style="margin:auto;">
                                <tr>
                                    <td colspan="6">
                                        <h3 style="margin-bottom:0px; padding-top:10px; padding-bottom:10px; text-align:left; border-top:1px solid; border-bottom:1px solid;">
                                            Patient Detail
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><strong>Patient ID</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->pa_id }}</td>
                                    <td style="padding:10px;"><strong>Patient Name</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->patientData->pa_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Bill No</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->ap_id }}</td>
                                    <td style="padding:10px;"><strong>Address</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->patientData->pa_address.' '.$data->patientData->pa_city.' '.$data->patientData->pa_pincode.' '.$data->patientData->pa_state }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Appointment Date</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ date('d M Y', strtotime($data->ap_date)) }}</td>
                                    <td style="padding:10px;"><strong>Doctor</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->doctorData->person_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Refer By</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ ($data->patientData->pa_referred_by == 'doctor') ? $data->patientData->pa_referred_doctor : $data->patientData->pa_referred_text }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <h3 style="margin-bottom:0px; padding-top:10px; padding-bottom:10px; text-align:left; border-top:1px solid; border-bottom:1px solid;">
                                            Appointment Detail
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Height__cm</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->ap_height }}</td>
                                    <td style="padding:10px;"><strong>Weight__kg</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->ap_weight }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>BP(_/_)mmhg</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->ap_bp }}</td>
                                    <td style="padding:10px;"><strong>Follow Up Date</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ ($data->ap_follow_up_date != null && $data->ap_follow_up_date != '0000-00-00') ? date('d M Y', strtotime($data->ap_follow_up_date)) : '' }}</td>
                                </tr>
                                @if($data->ap_surg_required == 'yes')
                                <tr>
                                    <td style="padding:10px;"><Strong>Surgery Required?</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ ($data->ap_surg_required == 'yes') ? 'Yes' : 'No' }}</td>
                                    <td style="padding:10px;"><strong>Surgery Date</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ ($data->ap_surg_date != null && $data->ap_surg_date != '0000-00-00') ? date('d M Y', strtotime($data->ap_surg_date)) : '' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Type of Surgery</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->ap_surg_type }}</td>
                                    <td style="padding:10px;"><strong>Is FOC?</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ ($data->ap_is_foc == 'yes') ? 'Yes' : 'No' }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td style="padding:10px;"><Strong>Surgery Required?</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ ($data->ap_surg_required == 'yes') ? 'Yes' : 'No' }}</td>
                                    <td style="padding:10px;"><strong>Is FOC?</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ ($data->ap_is_foc == 'yes') ? 'Yes' : 'No' }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding:10px;"><Strong>Complaints</Strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->ap_complaint }}</td>
                                    <td style="padding:10px;"><strong>Other Details</strong></td>
                                    <td style="padding:10px;" colspan="2">{{ $data->ap_other_detail }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Any Advice</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ $data->ap_any_advice }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <h3 style="margin-bottom:0px; padding-top:10px; padding-bottom:10px; text-align:left; border-top:1px solid;">
                                            Medicine Detail
                                        </h3>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">Medicine Name</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">No. of Days</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">Timing</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">Morning</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">Afternoon</th>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; text-align:left;">Evening</th>
                                </tr>
                                @if(!empty($prescribeMedicineList->toArray()))
                                @foreach($prescribeMedicineList as $prescribeMedicine)
                                <tr>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">{{ $prescribeMedicine->medicineData->gm_name.' ('.$prescribeMedicine->medicineData->gm_company_name.')' }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">{{ $prescribeMedicine->am_days }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">{{ $prescribeMedicine->am_timing }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">{{ $prescribeMedicine->am_morning }}</td>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">{{ $prescribeMedicine->am_afternoon }}</td>
                                    <td style="padding:10px; border-bottom:1px solid;">{{ $prescribeMedicine->am_evening }}</td>
                                </tr>
                                @endforeach
                                @endif
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