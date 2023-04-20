<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WoProcessHistory;
use Illuminate\Http\Request;

class WorkOrderProcessController extends Controller
{
    public function history(int $woProcessId)
    {
        return response()->json([
            'data' => WoProcessHistory::with(['updatedBy'])->where('wo_process_id', $woProcessId)->orderBy('date_time', 'DESC')->get()
        ]);
    }
}
