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
    <table style="width: 100%;">
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
                                Operation Medicine
                            </h3>
                            <table style="width: 100%;">
                                <tr>
                                    <td>
                                        <h3 style="margin-bottom:0px; padding-bottom:10px;">
                                            Date - {{ date('d M Y') }}
                                        </h3>
                                    </td>
                                    <td style="text-align:right;">
                                        <h3 style="margin-bottom:0px; padding-bottom:10px;">
                                            IPD ID - {{ $data1['ipd_id'] }}
                                        </h3>
                                    </td>
                                </tr>
                            </table>


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
                                    <td style="padding:10px;"><Strong>IPD ID</Strong></td>
                                    <td style="padding:10px;" colspan="5">{{ $data1['ipd_id'] }}</td>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <h3 style="margin-bottom:0px; padding-top:10px; padding-bottom:10px; text-align:left; border-top:1px solid; border-bottom:1px solid;">
                                            Medicine
                                        </h3>
                                    </td>
                                </tr>
                                @if(!empty($medicineList->toArray()))
                                @foreach($medicineList as $medicine)
                                @php
                                $ipdMedicine = $data1['ipd_operation_medicine'];
                                $medicineVal = 0;
                                if(!empty($ipdMedicine)){
                                foreach($ipdMedicine as $med){
                                if($med->medicine_id == $medicine['om_id']){
                                $medicineVal = $med->medicine_val;
                                }
                                }
                                }
                                @endphp
                                <tr>
                                    <td for="medicine_{{ $medicine->om_id  }}">{{ $medicine->om_name.' ('.$medicine->om_company_name.')' }}</td>
                                    <td>
                                        {{ $medicineVal }}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
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