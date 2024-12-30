<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Specializations = Specialization::all();
        return view('landingpage', compact('Specializations'));
    }

    public function get_doctor(Request $request)
    {
        $id_special = $request->id_special;

        // Fetch doctors based on the specialization and ensure their status is active
        $doctors = Doctor::where('specialization_id', $id_special)
            ->where('status', '1') // Ensure only active doctors are fetched
            ->get();

        // Generate the options for the dropdown
        $opt = "<option value=''>Select Doctor</option>";
        foreach ($doctors as $doctor) {
            $opt .= "<option value='{$doctor->id}'>{$doctor->name}</option>";
        }

        echo $opt;
    }


    public function check()
    {
        $searchdata = "";
        return view('check-appointment', compact('searchdata'));
    }

    public function searchAppointment(Request $request)
    {
        $searchdata = $request->searchdata;

        $appointments = Appointment::where('AppointmentNumber', 'like', "$searchdata%")
            ->orWhere('Name', 'like', "$searchdata%")
            ->orWhere('MobileNumber', 'like', "$searchdata%")
            ->get();

        return view('check-appointment', compact('appointments', 'searchdata'));
    }

    public function newAppointment()
    {
        // Show all new appointments
        $appointments = Appointment::where('Status', NULL)->get(); // Show all new appointments, not filtered by doctor
        return view('doctor.appointment.newAppointment.index', compact('appointments'));
    }

    public function cancelAppointment()
    {
        // Show all cancelled appointments
        $appointments = Appointment::where('Status', 'Cancelled')->get(); // Show all cancelled appointments, not filtered by doctor
        return view('doctor.appointment.cancelAppointment.index', compact('appointments'));
    }

    public function aprvAppointment()
    {
        // Show all approved appointments
        $appointments = Appointment::where('Status', 'Approved')->get(); // Show all approved appointments, not filtered by doctor
        return view('doctor.appointment.apprvAppointment.index', compact('appointments'));
    }

    public function allAppointment()
    {
        // Fetch all appointments along with their associated doctors
        $appointments = Appointment::with('doctor')->get();

        return view('doctor.appointment.allAppointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Appointment::create([
            'AppointmentNumber' => random_int(10000, 99999),
            'Name' => $request->Name,
            'Email' => $request->Email,
            'MobileNumber' => $request->MobileNumber,
            'AppointmentDate' => $request->AppointmentDate,
            'AppointmentTime' => $request->AppointmentTime,
            'Specialization' => $request->Specialization,
            'Doctor' => $request->Doctor,
            'Message' => $request->Message,
        ]);

        Alert::success('Success!', 'Your Appointment Request Has Been Send. We Will Contact You Soon');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id, $aptnum)
    {
        // Show a single appointment by ID and Appointment Number
        $appointment = Appointment::where('id', $id)->where('AppointmentNumber', $aptnum)->first();
        return view('doctor.appointment.appointmentdetail', compact('appointment'));
    }

    public function searchPage()
    {
        $searchdata = "";
        return view('doctor.search.index', compact('searchdata'));
    }

    public function searchResult(Request $request)
    {
        $searchdata = $request->searchdata;

        $appointments = Appointment::where('AppointmentNumber', 'like', "$searchdata%")
            ->orWhere('Name', 'like', "$searchdata%")
            ->orWhere('MobileNumber', 'like', "$searchdata%")
            ->get();

        return view('doctor.search.index', compact('appointments', 'searchdata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $appointment = Appointment::find($id);
        $appointment->Remark = $request->Remark;
        $appointment->Status = $request->Status;
        $appointment->update();

        Alert::success('Success!', 'Remark and status have been updated');
        return to_route('allAppointment');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
