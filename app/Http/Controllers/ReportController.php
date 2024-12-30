<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function appointment_bwdates(Request $request)
    {
        $fromdate = $request->fromdate;
        $todate = $request->todate;

        // Remove the authentication check for the doctor
        $appointments = Appointment::whereBetween('ApplyDate', [Carbon::parse($fromdate), Carbon::parse($todate)])
            ->get();

        return view('doctor.report.bw-dates', compact('fromdate', 'todate', 'appointments'));
    }

    public function index()
    {
        return view('doctor.report.index');
    }
}
