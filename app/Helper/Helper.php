<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
/* ----------------------------------------------------------- */
/* Rendom Code */
/* ----------------------------------------------------------- */

function RendomString($size = 10, $type = 'mix')
{
    /* Type : 'number','string','mix' */
    $size = $size == null ? 10 : $size;
    $code = '';
    if ($type == 'number') {
        $akeys = range('0', '9');
        for ($i = 0; $i < $size; $i++) {
            $code .= $akeys[array_rand($akeys)];
        }
    } elseif ($type == 'string') {
        $akeys = range('A', 'Z');
        $bkeys = range('a', 'z');
        $ckeys = array_merge($akeys, $bkeys);
        for ($i = 0; $i < $size; $i++) {
            $code .= $ckeys[array_rand($ckeys)];
        }
    } else {
        $code = Str::random($size);
    }
    return str_shuffle($code);
}

/* ----------------------------------------------------------- */
/* Image Upload */
/* ----------------------------------------------------------- */
function UploadCustomeImage($image, $image_name = '', $upath = '', $prefix = '', $type = 'resize', $width = 512, $height = 512)
{
    $path = ($upath == '') ? '' : $upath;

    if (env('STORAGE_PATH') == 'cloud') {
        $storepath = Storage::disk('s3')->path($path);
    } else {
        $storepath = Storage::disk('public')->path($path);
    }

    if (!is_dir($storepath)) {
        \File::makeDirectory($storepath, 0775, true);
    }

    $image_name    = ($image_name == '') ? RendomString(10, 'number') : $image_name;
    $imageName = $image_name . '.' . $image->getClientOriginalExtension();

    //Storage::disk('public')->put($imageName, $image);
    $image->storeAs($path, $imageName, ['disk' => 'public']);

    return $imageName;
}

/* Remove Image */
function ImageRemove($image = '')
{
    if ($image != '') {
        $imgArr = json_decode($image);
        foreach ($imgArr as $img) {
            Storage::disk('public')->delete($img);
        }
    }
}

/* Image Path */
function ImagePath($image = '')
{
    if ($image != '') {
        $imgArr = json_decode($image);
        $img = $imgArr[0];
        return $storage = Storage::url($img);
    } else {
        return asset('assets/media/users/blank.png');
    }
}

/* Payment Model */
function PaymentMode()
{
    $data = [
        [
            'ap_payment_mode' => 'cash'
        ],
        [
            'ap_payment_mode' => 'card'
        ],
        [
            'ap_payment_mode' => 'upi'
        ],
        // [
        //     'ap_payment_mode' => 'mediclaim'
        // ],
        // [
        //     'ap_payment_mode' => 'corporate'
        // ]
    ];
    return $data;
}

/* Number to Word */
function numberToWord($num = '')
{
    $num    = (string) ((int) $num);

    if ((int) ($num) && ctype_digit($num)) {
        $words  = array();

        $num    = str_replace(array(',', ' '), '', trim($num));

        $list1  = array(
            '',
            'one',
            'two',
            'three',
            'four',
            'five',
            'six',
            'seven',
            'eight',
            'nine',
            'ten',
            'eleven',
            'twelve',
            'thirteen',
            'fourteen',
            'fifteen',
            'sixteen',
            'seventeen',
            'eighteen',
            'nineteen'
        );

        $list2  = array(
            '',
            'ten',
            'twenty',
            'thirty',
            'forty',
            'fifty',
            'sixty',
            'seventy',
            'eighty',
            'ninety',
            'hundred'
        );

        $list3  = array(
            '',
            'thousand',
            'million',
            'billion',
            'trillion',
            'quadrillion',
            'quintillion',
            'sextillion',
            'septillion',
            'octillion',
            'nonillion',
            'decillion',
            'undecillion',
            'duodecillion',
            'tredecillion',
            'quattuordecillion',
            'quindecillion',
            'sexdecillion',
            'septendecillion',
            'octodecillion',
            'novemdecillion',
            'vigintillion'
        );

        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num    = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);

        foreach ($num_levels as $num_part) {
            $levels--;
            $hundreds   = (int) ($num_part / 100);
            $hundreds   = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
            $tens       = (int) ($num_part % 100);
            $singles    = '';

            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_part % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
        }
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }

        $words  = implode(', ', $words);

        $words  = trim(str_replace(' ,', ',', ucwords($words)), ', ');
        if ($commas) {
            $words  = str_replace(',', ' and', $words);
        }

        return $words;
    } else if (!((int) $num)) {
        return 'Zero';
    }
    return '';
}

function displaywords($number)
{
    $words = array(
        '0' => '',
        '1' => 'one',
        '2' => 'two',
        '3' => 'three',
        '4' => 'four',
        '5' => 'five',
        '6' => 'six',
        '7' => 'seven',
        '8' => 'eight',
        '9' => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' => 'nineteen',
        '20' => 'twenty',
        '30' => 'thirty',
        '40' => 'forty',
        '50' => 'fifty',
        '60' => 'sixty',
        '70' => 'seventy',
        '80' => 'eighty',
        '90' => 'ninety'
    );
    $digits = array('', '', 'hundred', 'thousand', 'lakh', 'crore');

    $number = explode(".", $number);
    $result = array("", "");
    $j = 0;
    foreach ($number as $val) {
        // loop each part of number, right and left of dot
        for ($i = 0; $i < strlen($val); $i++) {
            // look at each part of the number separately  [1] [5] [4] [2]  and  [5] [8]

            $numberpart = str_pad($val[$i], strlen($val) - $i, "0", STR_PAD_RIGHT); // make 1 => 1000, 5 => 500, 4 => 40 etc.
            if ($numberpart <= 20) { // if it's below 20 the number should be one word
                $numberpart = 1 * substr($val, $i, 2); // use two digits as the word
                $i++; // increment i since we used two digits
                $result[$j] .= $words[$numberpart] . " ";
            } else {
                //echo $numberpart . "<br>\n"; //debug
                if ($numberpart > 90) {  // more than 90 and it needs a $digit.
                    $result[$j] .= $words[$val[$i]] . " " . $digits[strlen($numberpart) - 1] . " ";
                } else if ($numberpart != 0) { // don't print zero
                    $result[$j] .= $words[str_pad($val[$i], strlen($val) - $i, "0", STR_PAD_RIGHT)] . " ";
                }
            }
        }
        $j++;
    }
    if (trim($result[0]) != "") echo $result[0] . "Rupees ";
    if ($result[1] != "") echo $result[1] . "Paise";
    echo " Only";
}

if (!function_exists('notificationSubjectList')) {
    function notificationSubjectList($key)
    {
        $data = [
            'opd_add'       => 'New Appointment',
            'ipd_add'       => 'New Patient Admit',
            'ipd_discharge' => 'Patient Discharged'
        ];
        return $data[$key];
    }
}

if (!function_exists('notificationMessageList')) {
    function notificationMessageList($key)
    {
        $data = [
            'opd_add'       => 'New appointment has beed created',
            'ipd_add'       => 'New patient has beedn admitted',
            'ipd_discharge' => 'Patient has discharged'
        ];
        return $data[$key];
    }
}

if (!function_exists('notificationIconList')) {
    function notificationIconList($key)
    {
        $data = [
            'opd_add'       => 'flaticon-calendar-2',
            'ipd_add'       => 'la la-bed',
            'ipd_discharge' => 'la la-bed'
        ];
        return $data[$key];
    }
}

if (!function_exists('notificationRoute')) {
    function notificationRoute($key)
    {
        $loginUser = Auth::user();
        $data = [
            'opd_add'        => route('appointment.list'),
            'opd_add_doctor' => route('doctor_opd_ipd.list'),
            'ipd_add'        => route('ipd.list'),
            'ipd_add_doctor' => route('doctor_opd_ipd.list'),
            'ipd_discharge'  => route('ipd.list')
        ];
        return $data[$key];
    }
}

if (!function_exists('loginUserUnreadNotification')) {
    function loginUserUnreadNotification()
    {
        $loginUser = Auth::user();
        $notification = new Notification;
        $notificationList  = $notification->getList(['no_created_for' => $loginUser->user_id, 'no_read' => 0], false, '');
        $notificationCount = $notification->getList(['no_created_for' => $loginUser->user_id, 'no_read' => 0], false, '')->count();
        return ['notificationList' => $notificationList, 'notificationCount' => $notificationCount];
    }
}
