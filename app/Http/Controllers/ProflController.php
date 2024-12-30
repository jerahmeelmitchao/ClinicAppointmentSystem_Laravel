<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProflController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kode = Auth::user()->Specialization;
        $spc = Specialization::where('id', $kode)->first();
        $specializations = Specialization::all();
        return view('doctor.profile.index', compact('user', 'specializations', 'spc'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Use findOrFail for better error handling
    
        // Check if the field is not empty and then update
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        // Check for the mobile number
        $user->MobileNumber = !empty($request->mobileNumber) ? $request->mobileNumber : $user->MobileNumber;
        $user->Specialization = $request->specialization ?? $user->Specialization;
    
        $user->save();
    
        Alert::success('Success!', 'Profile Updated');
        return back();
    }
    

    public function show()
    {
        return view('doctor.change-password');
    }
}
