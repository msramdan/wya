<?php

namespace App\Marsweb\Notifications;

use App\Helpers\NotificationHelper;
use Auth;


class NotifWhatsappWorkOrderRejected
{
    private $receiver;
    private $workOrder;
    private $message;
    private $hospital_id;

    public function __construct($receiver, $workOrder, $hospital_id)
    {
        $this->receiver = $receiver;
        $this->workOrder = $workOrder;
        $this->hospital_id = $hospital_id;
        $this->buildMessage();
        $this->send();
    }

    public function buildMessage()
    {
        $this->message = "❌ Work Order with No. " . $this->workOrder->wo_number . "Success Rejected ❌";
        $this->message .= "\nUser Rejected: " . Auth::user()->name;
        $this->message .= "\n\nFor WO details, you can visit the following link: \n" .url('/panel/work-orders/'.$this->workOrder->id.'/edit');
    }

    public function send()
    {
        NotificationHelper::notifWhatsapp($this->receiver, $this->message, $this->hospital_id);
    }
}
