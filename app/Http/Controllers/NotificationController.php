<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MainController;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends MainController
{
    public $notification;
    public function __construct()
    {
        parent::__construct();
        $this->notification = new Notification;
    }

    public function read_notification(Request $request)
    {
        $query = $request->query();
        $no_id = base64_decode($query['no_id']);
        $data = [
            'no_read' => 1
        ];
        $update = $this->notification->updateData($data, $no_id);
        if ($update == 1) {
            return $this->getSuccessResult([], 'Notification read', true);
        } else {
            return $this->getErrorMessage('Notification not read properly, something is wrong.');
        }
    }
}
