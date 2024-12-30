@extends('layouts.doctor', ['title' => 'Doctors Edit'])

@section('content')
<div class="simple-page-form" id="login-form" style="position: relative;">
    <!-- Close Button -->
    <a href="{{ url()->previous() }}" class="btn-close" style="position: absolute; top: 0px; right: 18px; text-decoration: none; font-size: 30px; font-weight: bold;">&times;</a>

    <h4 class="form-title m-b-xl text-center">Edit Doctor's Information</h4>
    <form action="" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <input id="name" type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name', $doctor->name) }}" required="true">
        </div>

        <div class="form-group">
            <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email', $doctor->email) }}" required="true">
        </div>

        <div class="form-group">
            <input id="MobileNumber" type="text" class="form-control" placeholder="Mobile" name="MobileNumber" maxlength="10" pattern="[0-9]+" value="{{ old('MobileNumber', $doctor->MobileNumber) }}" required="true">
        </div>

        <div class="form-group">
            <select class="form-control" name="Specialization">
                <option value="">Choose Specialization</option>
                @foreach ($specializations as $item)
                <option value="{{ $item->id }}"
                    {{ $item->id == old('Specialization', $doctor->specialization_id) ? 'selected' : '' }}>
                    {{ $item->Specialization }}
                </option>
                @endforeach
            </select>
        </div>

        <input type="submit" class="btn btn-primary" value="Update Doctor" name="submit">
    </form>
    <hr />

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div><!-- #login-form -->
@endsection

@section('footer')
@endsection