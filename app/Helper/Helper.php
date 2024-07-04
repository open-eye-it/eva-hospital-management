<?php

use Illuminate\Support\Facades\Storage;
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
        return '';
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
            'ap_payment_mode' => 'mediclaim'
        ],
        [
            'ap_payment_mode' => 'corporate'
        ]
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
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
            'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
            'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );

        $list2  = array(
            '', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
            'seventy', 'eighty', 'ninety', 'hundred'
        );

        $list3  = array(
            '', 'thousand', 'million', 'billion', 'trillion',
            'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion',
            'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion',
            'octodecillion', 'novemdecillion', 'vigintillion'
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
