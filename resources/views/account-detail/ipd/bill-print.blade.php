<!DOCTYPE html>
<html>

<head>
    <title>IPD Bill</title>
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
                            <!-- <img src="{{ url('assets/eva/img/logo/eva-logo.png') }}" style="max-width:200px;" /> -->
                            <h3 style="margin-top:0px; margin-bottom:0px; padding-bottom:10px;">
                                IPD BILL
                            </h3>
                            Date: <strong>{{ date('d M Y') }}</strong>
                            <table style="margin:auto; width:100%;">
                                <tr>
                                    <td style="padding:10px;"><strong>Patient ID</strong></td>
                                    <td style="padding:10px;">{{ $ipdDetail->patientData->pa_id }}</td>
                                    <td style="padding:10px;"><strong>Patient Name</strong></td>
                                    <td style="padding:10px;">{{ $ipdDetail->patientData->pa_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Bill No</Strong></td>
                                    <td style="padding:10px;">{{ $ipdDetail->ipd_id }}</td>
                                    <td style="padding:10px;"><strong>Address</strong></td>
                                    <td style="padding:10px;">{{ $ipdDetail->patientData->pa_address.' '.$ipdDetail->patientData->pa_city.' '.$ipdDetail->patientData->pa_pincode.' '.$ipdDetail->patientData->pa_state }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Admit Date</Strong></td>
                                    <td style="padding:10px;">{{ date('d M Y', strtotime($ipdDetail->ipd_admit_date)) }}</td>
                                    <td style="padding:10px;"><strong>Doctor</strong></td>
                                    <td style="padding:10px;">{{ $ipdDetail->doctorData->person_name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:10px;"><Strong>Refer By</Strong></td>
                                    <td style="padding:10px;">{{ ($ipdDetail->patientData->pa_referred_by == 'doctor') ? $ipdDetail->patientData->pa_referred_doctor : $ipdDetail->patientData->pa_referred_text }}</td>
                                    <td style="padding:10px;"><Strong>Type of Surgery</Strong></td>
                                    <td style="padding:10px;">{{ $ipdDetail->ipd_surgery_text }}</td>
                                </tr>
                                <tr>
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;" colspan="2">Paid By</th>
                                    <!-- <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; border-right:1px solid; text-align:left;">Received By</th> -->
                                    <th style="padding:10px; border-top:1px solid; border-bottom:1px solid; text-align:left;" colspan="2">Amount (Rs.)</th>
                                </tr>
                                <!-- @if(!empty($iplDetail->toArray()))
            @foreach($iplDetail as $Charge)
            <tr>
                <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;" colspan="2">{{ $Charge->ipl_paid_by }}</td>
                <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;">{{ $Charge->ipl_received_by }}</td>
                <td style="padding:10px; border-bottom:1px solid;">{{ $Charge->ipl_amount }}</td>
            </tr>
            @endforeach
            @endif -->
                                @php $received_amount = 0; @endphp
                                @if(!empty($ipdChargeList->toArray()))
                                @foreach($ipdChargeList as $Charge)
                                @php $received_amount += $Charge->ic_amount @endphp
                                <tr>
                                    <td style="padding:10px; border-bottom:1px solid; border-right:1px solid;" colspan="2">{{ $Charge->ic_text }}</td>
                                    <td style="padding:10px; border-bottom:1px solid;" colspan="2">{{ $Charge->ic_amount }}</td>
                                </tr>
                                @endforeach
                                @endif
                                <tr>

                                    <!-- <td style="padding:10px; border-right:1px solid;" colspan="2"></td> -->
                                    <th style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:left;" colspan="2">Discount</th>
                                    <td style="padding:10px; border-bottom:1px solid;" colspan="2">{{ $ipdDetail->ipd_discount }}</td>
                                </tr>
                                <tr>

                                    <th style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:left;" colspan="2">Received Amount</th>
                                    <td style="padding:10px; border-bottom:1px solid;" colspan="2">{{ $received_amount+$ipdDetail->ipd_discount }}</td>
                                </tr>
                                <!-- <tr>

                <td style="padding:10px; border-right:1px solid;" colspan="2"></td>
                <th style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:left;">Received Amount</th>
                <td style="padding:10px; border-bottom:1px solid;">{{ $ipdDetail->ipd_received_amount }}</td>
            </tr> -->
                                <tr>

                                    <!-- <td style="padding:10px; border-right:1px solid;" colspan="2"></td> -->
                                    <th style="padding:10px; border-bottom:1px solid; border-right:1px solid; text-align:left;" colspan="2">Bill Amount</th>
                                    <td style="padding:10px; border-bottom:1px solid;" colspan="2">{{ $ipdDetail->ipd_bill_amount }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding:10px; text-align:left;"><strong>Amount In Words:</strong>
                                        @php
                                        echo numberToWord($received_amount+$ipdDetail->ipd_discount);
                                        @endphp
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