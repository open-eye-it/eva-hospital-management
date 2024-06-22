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
