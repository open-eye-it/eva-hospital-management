<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;

class MainController extends Controller
{
    public function __construct()
    {
        $this->patient = new Patient;
    }

    public function randomString($size, $type = '')
    {
        $string = RendomString($size, $type);
        if ($type == 'number') {
            $stringArr = str_split($string);
            if ($stringArr[0] == 0) {
                return $this->randomString($size, $type);
            }
        }
        return $string;
    }

    public $successStatus   = 200;
    public $errorStatus     = 400;

    public function getSuccessResult($datas = array(), $message, $response, $status = null)
    {
        $status = $this->getStatusOrDefault($status, $this->successStatus);
        $output['data']       = $datas;
        $output['message']    = $message;
        $output['response']   = $response;
        return response()->json($output, $status);
    }

    public function getErrorMessage($message = 'Some Thing Wrong!', $status = null)
    {
        $status = $this->getStatusOrDefault($status, $this->errorStatus);
        $output['data']       = '';
        $output['message']    = $message;
        $output['response']   = false;
        return response()->json($output, $status);
    }

    private function getStatusOrDefault($status, $defaultStatus)
    {
        if ($status == null || $status == '') {
            return $defaultStatus;
        }
        return $status;
    }
}
