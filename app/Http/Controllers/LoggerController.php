<?php

namespace App\Http\Controllers;

use App\Models\EventLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoggerController extends Controller
{
    public function store(Request $request){

        // Validate incoming data
        $request->validate([
            'type' => 'required|string',
            'message' => 'required|string',
        ]);

        // Save to database
        EventLog::create([
            'event_type' => $request->type,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'user_id' => Auth::id(), // Logs user ID if logged in, null otherwise
        ]);

        return response()->json(['status' => 'success']);
    }
}
