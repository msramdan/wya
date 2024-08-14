<?php

namespace App\Marsweb\Notifications;

use App\Helpers\NotificationHelper;
use Auth;

class NotifWhatsappWorkOrderProcessFinish
{
    private $receiver;
    private $workOrder;
    private $request;
    private $message;
    private $hospital_id;

    public function __construct($receiver, $workOrder, $request, $hospital_id)
    {
        $this->receiver = $receiver;
        $this->workOrder = $workOrder;
        $this->request = $request;
        $this->hospital_id = $hospital_id;
        $this->buildMessage();
        $this->send();
    }

    public function buildMessage()
    {
        $this->message = "✅ Notif Work Order Proses ✅";
        $this->message .= "\nFor detail: ";
        $this->message .= "\n\nHospital: " . $this->workOrder->hospital_name;
        $this->message .= "\nUser Updated: " . Auth::user()->name;
        $this->message .= "\nEquipment: " .  $this->workOrder->serial_number." | " . $this->workOrder->manufacturer." | " .$this->workOrder->type;
        $this->message .= "\nType Wo: " . ($this->workOrder->type_wo == 'Training' ? 'Training/Uji fungsi' : $this->workOrder->type_wo);
        $this->message .= "\nCategory Wo: " . $this->workOrder->category_wo;
        $this->message .= "\nWork Date: " . $this->request->work_date;
        $this->message .= "\nStatus: " . $this->request->status;
    }
    public function send()
    {
        NotificationHelper::notifWhatsapp($this->receiver, $this->message, $this->hospital_id);
    }
}
