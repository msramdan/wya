<?php

namespace App\Marsweb\Notifications;

use App\Helpers\NotificationHelper;

class NotifWhatsappWorkOrderCreated
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
        $this->message = "New Work Order with No. " . $this->workOrder->wo_number;
        $this->message .= "\n\n";
        $this->message .= "Filled Date: " . $this->workOrder->created_at->format('Y-m-d');
        $this->message .= "\nType Wo: " . $this->workOrder->type_wo;
        $this->message .= "\nCategory Wo: " . $this->workOrder->category_wo;
        $this->message .= "\nUser Created: " . $this->workOrder->createdBy->name;
    }

    public function send()
    {
        NotificationHelper::notifWhatsapp($this->receiver, $this->message, $this->hospital_id);
    }
}
