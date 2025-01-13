<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
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

<body style="font-family: Arial, Helvetica, saans-serif; font-style: italic;">
    <table style="width:100%;">
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
                            <img src="assets/eva/img/logo/eva-logo.png" style="max-width:200px;" />
                            <h3 style="margin-top:0px; margin-bottom:0px; padding-bottom:0px;">
                                Receipt No: {{ $data['ipl_id'] }}
                            </h3>
                            <h3 style="margin-top:10px; padding-top:0px;">
                                {{ $data['type_of_surgery'] }}
                            </h3>
                            <p>Received with thanks from</p>
                            <p>Mrs/Ms <strong>{{ $data['paid_by'] }}</strong></p>
                            <p>a sum of Rupees <strong>{{ displaywords($data['bill_amount']) }}</strong></p>
                            <p>received Cash / Cheque / DD No. <strong>{{ $data['received_by'] }}</strong></p>
                            <p>For Bill No <strong>{{ $data['ipl_id'] }}</strong> Bill Amoun (Rs.) <strong>{{ $data['bill_amount'] }}</strong></p>
                            <p>Patient's Name <strong>{{ $data['patient_name'] }}</strong></p>
                            <p>D.O.A <strong>{{ $data['admit_date'] }}</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; D.O.D <strong>{{ $data['discharge_date'] }}</strong></p>
                            <p style="margin-top:50px;"></p>
                            <table style="margin-left:20px; padding-right:40px; width:100%; font-style: normal;">
                                <tr>
                                    <td>
                                        <Strong>Date: {{ date('d M Y', strtotime($data['current_date'])) }}</Strong>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <Strong>Place: </Strong> Eva Endoscopy Training Institute
                                    </td>
                                    <td style="border-bottom:1px solid;">

                                    </td>
                                </tr>
                                <tr>
                                    <td>

                                    </td>
                                    <td style="text-align:center;">
                                        <h2 style=" margin-top:10px; margin-bottom:0px; padding-bottom:0px; color:#E6352F;">Dr. Dipak Limbachiya</h2>
                                        <p style="margin-top:0px; padding-top:10px;">Institute Director</p>
                                    </td>
                                </tr>
                            </table>
                            <table style="background-color:#E6352F; text-align:center; color:white; padding-top:10px; padding-bottom:10px; font-size:12px; width:100%; font-style: normal; margin-top:10px;">
                                <tr>
                                    <td>
                                        Block-B, Neelkanth Park-II, Ghoda Camp Road Shahibaug, Ahmedabad-380 004.
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Ph. :079-2268 2217 / 2268 2075 E-mail: drdipaklimbachiya@gmail.com Web. : www.evawomenshospital.com
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