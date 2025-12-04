<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Fetch logs, newest first, paginated
        $logs = EventLog::latest()->paginate(20);
        return view('admin.activity_log.index', compact('logs'));
    }
}
