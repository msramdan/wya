<?php

namespace App\Marsweb\Notifications;

use App\Helpers\NotificationHelper;

class NotifWhatsappWorkOrderDeleted
{
    private $receiver;
    private $workOrder;
    private $message;

    public function __construct($receiver, $workOrder)
    {
        $this->receiver = $receiver;
        $this->workOrder = $workOrder;

        $this->buildMessage();
        $this->send();
    }

    public function buildMessage()
    {
        $this->message = "Work Order with No. " . $this->workOrder->wo_number . " Deleted";
        $this->message .= "\n\n";
        $this->message .= "Filled Date: " . $this->workOrder->created_at->format('Y-m-d');
        $this->message .= "\nType Wo: " . $this->workOrder->type_wo;
        $this->message .= "\nCategory Wo: " . $this->workOrder->category_wo;
        $this->message .= "\nUser Created: " . $this->workOrder->createdBy->name;
    }

    public function send()
    {
        NotificationHelper::notifWhatsapp($this->receiver, $this->message);
    }
}
