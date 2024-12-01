<!DOCTYPE html>
<html>

<head>
    <title>{{ $data->tr_name }}</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-style: italic;">
    <div style="border:2px solid; width:100%; text-align:center; padding-top:20px;">
        <img src="assets/eva/img/logo/eva-logo.png" style="max-width:200px;" />
        <h3 style="margin-bottom:0px; padding-bottom:0px;">
            FELLOWSHIP IN ADVANCED
        </h3>
        <h3 style="margin-top:0px; padding-top:0px;">
            LAPAROSCOPIC SURGERY
        </h3>
        <p>This fellowship certificate is awarded to</p>
        <p><strong>{{ $data->tr_name }}</strong></p>
        <p>after successful Hands on Training in Minimal Access Surgery</p>
        <p>from <strong>Eva Endoscopy Training Institute</strong> attached to</p>
        <p><strong>Eva Women's Hospital, Ahmedabad, India,</strong></p>
        <p>from <strong>{{ date('d M Y', strtotime($data->tr_start_date)) }}</strong> to <strong>{{ date('d M Y', strtotime($data->tr_end_date)) }}</strong> under the guidance of </p>
        <p><strong>Dr. Dipak Limbachiya, Consultant Gynaecologist,</strong></p>
        <p><strong>Endoscopist, and Laparoscopic Gynaec-Onco Surgeon.</strong></p>
        <p style="margin-top:50px;"></p>
        <table style="border-collapse:collapse; padding-left:20px; padding-right:20px; width:100%; font-style: normal;">
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
                    <h2 style="margin-bottom:0px; padding-bottom:0px; color:#E6352F;">Dr. Dipak Limbachiya</h2>
                    <p style="margin-top:0px; padding-top:10px;">Institute Director</p>
                </td>
            </tr>
        </table>
        <table style="background-color:#E6352F; text-align:center; color:white; padding-top:10px; padding-bottom:10px; font-size:12px; width:100%; font-style: normal;">
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