<!DOCTYPE html>
<html>

<head>
    <title>IPD Final Bill</title>
    <style>
        .tableCss,
        .tableCss th,
        .tableCss td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-style: italic;">
    <div style="width:100%; text-align:center; padding-top:20px; padding-bottom:20px; margin-top:120px;">
        <h3 style="margin-bottom:0px; padding-bottom:10px;">
            IPD Final Bill
        </h3>
        <table style="margin:auto; width:100%; padding:5px;">
            <tr>
                <td style="font-weight: bold;">IP No</td>
                <td style="width:50%;">{{ $data1['ipd_id'] }}</td>
                <td style="font-weight: bold;">BILL NO</td>
                <td>{{ $data1['ipd_id'] }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Patient Name</td>
                <td style="width:50%;">{{ $data1['patient_name'] }}</td>
                <td style="font-weight: bold;">BILL DATE</td>
                <td>{{ date('d M Y') }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Pan Card:</td>
                <td style="width:50%;">{{ $data1['pan_card'] }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Address:</td>
                <td style="width:50%;">{{ $data1['address'].' '.$data1['city'].' '.$data1['state'].' '.$data1['pincode'] }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table style="margin:auto; width:100%; padding:5px; margin-top:20px;">
            <tr>
                <td style="font-weight: bold;">Age/Gender</td>
                <td style="width:40%;">{{ $data1['age'] }} Yrs/{{ ucfirst(substr($data1['gender'], 0, 1)) }}</td>
                <td style="font-weight: bold;">Admission Date/Time</td>
                <td>{{ date('d M Y, h:i a', strtotime($data1['ipd_admit_date'])) }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Doctor Name</td>
                <td style="width:40%;">{{ $data1['doctor'] }}</td>
                <td style="font-weight: bold;">Discharge Date/Time</td>
                <td>{{ date('d M Y, h:i a', strtotime($data1['ipd_discharge_date'])) }}</td>
            </tr>
        </table>
        <table class="tableCss" style="margin:auto; width:100%; padding:5px; margin-top:20px;">
            <tr>
                <td>SR.NO</td>
                <td>PARTICULAR</td>
                <td>AMOUNT INR</td>
            </tr>
            @php
            $total_amount = 0;
            $discount = $data1['ipd_discount'];
            $i=1;
            @endphp
            @foreach($data1['ipdCharges'] as $key => $charge)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $charge['ic_text'] }}</td>
                <td>{{ $charge['ic_amount'] }}</td>
            </tr>
            @php $i++; $total_amount += $charge['ic_amount']; @endphp
            @endforeach
            <tr>
                <td></td>
                <td>TOTAL</td>
                <td>{{ $total_amount }}</td>
            </tr>
            <tr>
                <td></td>
                <td>DISCOUNT</td>
                <td>{{ $data1['ipd_discount'] }}</td>
            </tr>
            <tr>
                <td></td>
                <td>TOTAL ({{ displaywords($total_amount-$data1['ipd_discount']) }})</td>
                <td>{{ $total_amount-$data1['ipd_discount'] }}</td>
            </tr>
        </table>
        <div style="padding: 5px; text-align:left; font-weight: bold; margin-top:20px;">
            For EVA WOMENS HOSPITAL
        </div>
        <div style="padding: 5px; margin-top:50px; text-align:left; font-weight: bold;">
            Authorised Signatory
        </div>
    </div>
    <!-- <div style="border:2px solid; width:100%; text-align:center; padding-top:20px; padding-bottom:20px;">
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
    </div> -->
</body>

</html>