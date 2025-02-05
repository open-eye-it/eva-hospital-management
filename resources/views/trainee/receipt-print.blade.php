<!DOCTYPE html>
<html>

<head>
    <title>Receipt</title>
</head>

<body style="font-family: Arial, Helvetica, saans-serif; font-style: italic;">
    <div style="border:2px solid; width:100%; text-align:center; padding-top:20px;">
        <!-- <img src="assets/eva/img/logo/eva-logo.png" style="max-width:200px;" /> -->
        <h3 style="margin-bottom:0px; padding-bottom:0px;">
            Receipt No: {{ $paymentData->tpl_id }}
        </h3>
        <p>Received with thanks from</p>
        <p>Mrs/Ms <strong>{{ $paymentData?->traineeData?->tr_name }}</strong></p>
        <p>You have provide a payment of <strong>{{ $paymentData->tpl_desc }}</strong></p>
        <p>a sum of Rupees <strong>{{ displaywords($paymentData->tpl_amount) }}</strong></p>
        <p>For Bill No <strong>{{ $paymentData->tpl_id }}</strong> Bill Amoun (Rs.) <strong>{{ $paymentData->tpl_amount }}</strong></p>

        <p>Training from <strong>{{ date('d M Y', strtotime($paymentData?->traineeData?->tr_start_date)) }}</strong> to <strong>{{ date('d M Y', strtotime($paymentData?->traineeData?->tr_end_date)) }}</strong></p>
        <p style="margin-top:50px;"></p>
        <table style="margin-left:20px; padding-right:40px; width:100%; font-style: normal;">
            <tr>
                <td>
                    <Strong>Date: {{ date('d M Y') }}</Strong>
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
</body>

</html>