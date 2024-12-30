<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the total appointments based on the status
        $total_apt = Appointment::where('Status', NULL)->count(); // Show all new appointments
        $total_aprv = Appointment::where('Status', 'Approved')->count(); // Show all approved appointments
        $total_cncl = Appointment::where('Status', 'Cancelled')->count(); // Show all cancelled appointments
        $total_appoint = Appointment::count(); // Show total number of appointments

        // Count the total number of doctors
        $total_doctors = Doctor::count();

        // Count the total number of unique specializations
        $total_specializations = Specialization::count();

        return view('doctor.dashboard', compact('total_apt', 'total_aprv', 'total_cncl', 'total_appoint', 'total_doctors', 'total_specializations'));
    }
    

    public function listDoctors(Request $request)
    {
        // Get the selected specialization from the request, if any
        $specializationId = $request->input('specialization');
        $searchTerm = $request->input('search');

        // Fetch all specializations to populate the dropdown
        $specializations = Specialization::all();

        // Query doctors with optional filtering by specialization and search term
        $doctors = DB::table('doctors')
            ->leftJoin('specializations', 'doctors.specialization_id', '=', 'specializations.id')
            ->select('doctors.*', 'specializations.Specialization as specialization_name')
            ->when($specializationId, function ($query) use ($specializationId) {
                return $query->where('doctors.Specialization', $specializationId);
            })
            ->when($searchTerm, function ($query) use ($searchTerm) {
                return $query->where('doctors.name', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(10); // Paginate the results (adjust the number as needed)

        // Return the doctors list and specializations to the view
        return view('doctor.list', compact('doctors', 'specializations'));
    }



    public function toggleStatus($id)
    {
        // Find the doctor by ID
        $doctor = Doctor::findOrFail($id);

        // Toggle the status (1 becomes 0, and 0 becomes 1)
        $doctor->status = $doctor->status == '1' ? '0' : '1';

        // Save the updated status
        $doctor->save();

        // Redirect back to the doctor list with a success message
        return redirect()->route('doctors.list')->with('success', 'Doctor status updated successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all specializations to show in the select dropdown
        $specializations = Specialization::all();
        return view('doctor.add', compact('specializations'));
    }

    // Store the doctor in the database
    public function store(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'MobileNumber' => 'required|numeric|digits:10',
            'Specialization' => 'required|exists:specializations,id',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create the doctor record
        $doctor = new Doctor();
        $doctor->name = $request->input('name');
        $doctor->email = $request->input('email');
        $doctor->MobileNumber = $request->input('MobileNumber');
        $doctor->specialization_id = $request->input('Specialization');
        $doctor->status = 1; // Active by default
        $doctor->save(); // Save the doctor record in the database

        // Redirect with success message
        return redirect()->route('doctors.list')->with('success', 'Doctor added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function specializationsList(Request $request)
    {
        // Search term from the query string
        $searchTerm = $request->input('search');

        // Fetch specializations based on the search term
        $specializations = Specialization::when($searchTerm, function ($query) use ($searchTerm) {
            return $query->where('Specialization', 'like', '%' . $searchTerm . '%');
        })->get();

        return view('doctor.specialization', compact('specializations'));
    }

    // Controller: DoctorController.php

    public function updateSpecialization(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'Specialization' => 'required|string|max:255|unique:specializations,Specialization,' . $id,
        ]);

        // Find the specialization by ID
        $specialization = Specialization::findOrFail($id);

        // Update the specialization
        $specialization->Specialization = $request->input('Specialization');
        $specialization->save();

        // Redirect with success message
        return redirect()->route('doctor.specialization')->with('success', 'Specialization updated successfully.');
    }

    // Controller: DoctorController.php

    public function searchSpecialization(Request $request)
    {
        $search = $request->get('search');
        $specializations = Specialization::where('Specialization', 'like', '%' . $search . '%')->get();

        return view('doctor.specialization', compact('specializations'));
    }

    public function storeSpecialization(Request $request)
    {
        $request->validate([
            'Specialization' => 'required|string|max:255|unique:specializations,Specialization',
        ]);

        Specialization::create([
            'Specialization' => $request->input('Specialization'),
        ]);

        return redirect()->route('doctor.specialization')->with('success', 'Specialization added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'MobileNumber' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'specialization' => 'required|exists:specializations,id',
        ]);

        // Find the doctor by ID and update the information
        $doctor = Doctor::findOrFail($id);
        $doctor->name = $request->input('name');
        $doctor->MobileNumber = $request->input('MobileNumber');
        $doctor->email = $request->input('email');
        $doctor->specialization_id = $request->input('specialization');
        $doctor->save();

        // Redirect with a success message
        return redirect()->route('doctors.list')->with('success', 'Doctor details updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
