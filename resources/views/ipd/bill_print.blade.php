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
                        <div style="width:100%; text-align:center;">
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
                            <div style="padding: 5px; text-align:left; font-weight: bold; margin-top:10px;">
                                For EVA WOMENS HOSPITAL
                            </div>
                            <div style="padding: 5px; margin-top:50px; text-align:left; font-weight: bold;">
                                Authorised Signatory
                            </div>
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