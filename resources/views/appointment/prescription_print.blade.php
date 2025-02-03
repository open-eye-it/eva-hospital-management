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
                        <div style="border:2px solid; width:100%;">
                            <!-- <img src="{{ url('assets/eva/img/logo/eva-logo.png') }}" style="max-width:200px;" />
                            <h3 style="margin-top:0px; margin-bottom:0px; padding-bottom:10px;">
                                Prescription
                            </h3>
                            Date: <strong>{{ date('d M Y') }}</strong> -->

                            <table style="width:100%;">
                                <tr>
                                    <td style="padding:10px;" colspan="2"><strong>Bill No: </strong>{{ $data->ap_id }}</td>
                                    <td style="padding:10px;" colspan="2"><strong>Patient ID: </strong>{{ $data->pa_id }}</td>
                                    <td style="padding:10px;" colspan="2"><strong>Date: </strong>{{ date('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="4"><strong>Patient Name: </strong>{{ $data->patientData->pa_name }}</td>
                                    <td style="padding:10px;" colspan="2"><strong>Age: </strong>{{ $data->patientData->pa_age }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="6"><strong>Address: </strong>{{ $data->patientData->pa_address.' '.$data->patientData->pa_city.' '.$data->patientData->pa_pincode.' '.$data->patientData->pa_state }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="2"><strong>Doctor: </strong>{{ $data->doctorData->person_name }}</td>
                                    <td style="padding:10px;" colspan="2"><strong>Referred By</strong>{{ ($data->patientData->pa_referred_by == 'doctor') ? $data->patientData->pa_referred_doctor : $data->patientData->pa_referred_text }}</td>
                                    <td style="padding:10px;" colspan="2"><strong>Follow Up Date: </strong>{{ ($data->ap_follow_up_date != null && $data->ap_follow_up_date != '0000-00-00') ? date('d M Y', strtotime($data->ap_follow_up_date)) : '' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="2"><strong>Height: </strong>{{ $data->ap_height }}</td>
                                    <td style="padding:10px;" colspan="2"><strong>Weight: </strong>{{ $data->ap_weight }}</td>
                                    <td style="padding:10px;" colspan="2"><Strong>BP: </Strong>{{ $data->ap_bp }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="6"><Strong>Complaints: </Strong>{{ $data->ap_complaint }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="6"><strong>Other Details: </strong>{{ $data->ap_other_detail }}</td>
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
                                <tr>
                                    <td style="padding:10px;" colspan="6"><Strong>Any Advice: </Strong>{{ $data->ap_any_advice }}</td>
                                </tr>
                                @if($data->ap_surg_required == 'yes')
                                <tr>
                                    <td style="padding:10px;" colspan="2"><Strong>Surgery Required?: </Strong>{{ ($data->ap_surg_required == 'yes') ? 'Yes' : 'No' }}</td>
                                    <td style="padding:10px;" colspan="4"><strong>Surgery Date: </strong>{{ ($data->ap_surg_date != null && $data->ap_surg_date != '0000-00-00') ? date('d M Y', strtotime($data->ap_surg_date)) : '' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;" colspan="2"><Strong>Type of Surgery: </Strong>{{ $data->ap_surg_type }}</td>
                                    <td style="padding:10px;" colspan="4"><strong>Is FOC?: </strong>{{ ($data->ap_is_foc == 'yes') ? 'Yes' : 'No' }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td style="padding:10px;" colspan="2"><Strong>Surgery Required?: </Strong>{{ ($data->ap_surg_required == 'yes') ? 'Yes' : 'No' }}</td>
                                    <td style="padding:10px;" colspan="4"><strong>Is FOC?: </strong>{{ ($data->ap_is_foc == 'yes') ? 'Yes' : 'No' }}</td>
                                </tr>
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