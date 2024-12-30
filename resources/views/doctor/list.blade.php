@extends('layouts.doctor', ['title' => 'Doctors List'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title">Doctor List</h4>
            </header><!-- .widget-header -->
            <hr class="widget-separator">
            <div class="widget-body">
                <!-- Specialization Filter and Search -->
                <form method="GET" action="{{ route('doctors.list') }}">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <select id="specializationFilter" name="specialization" class="form-control" style="width: 100%; margin-bottom: 15px;">
                                <option value="">Select Specialization</option>
                                @foreach($specializations as $specialization)
                                <option value="{{ $specialization->id }}"
                                    {{ request('specialization') == $specialization->id ? 'selected' : '' }}>
                                    {{ $specialization->Specialization }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" style="width: 100%;" placeholder="Search by name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                        <div class="col-md-2 text-right">
                            <!-- Add Doctor Button -->
                            <a href="{{ route('doctor.add') }}" class="btn btn-success btn-block">Add a Doctor</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Doctor Name</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Specialization</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Edit</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @forelse ($doctors as $doctor)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $doctor->MobileNumber }}</td>
                                <td>{{ $doctor->email }}</td>
                                <td>{{ $doctor->specialization_name }}</td>

                                @if ($doctor->status == '1')
                                <td class="text-success">Active</td>
                                @else
                                <td class="text-danger">Inactive</td>
                                @endif

                                <td>
                                    <!-- Toggle status button -->
                                    <form action="{{ route('doctor.toggleStatus', $doctor->id) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm 
                                                @if ($doctor->status == '1')
                                                    btn-danger
                                                @else
                                                    btn-success
                                                @endif">
                                            @if ($doctor->status == '1')
                                            Deactivate
                                            @else
                                            Activate
                                            @endif
                                        </button>
                                    </form>

                                </td>

                                <td>
                                    <!-- Edit Button (Triggers Modal) -->
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editDoctorModal{{ $doctor->id }}">
                                        Edit
                                    </button>

                                    <!-- Modal for editing doctor details -->
                                    <div class="modal fade" id="editDoctorModal{{ $doctor->id }}" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel{{ $doctor->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editDoctorModalLabel{{ $doctor->id }}">Edit Doctor Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('doctor.update', $doctor->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="doctorName">Doctor Name</label>
                                                            <input type="text" id="doctorName" name="name" class="form-control" value="{{ $doctor->name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="mobileNumber">Mobile Number</label>
                                                            <input type="text" id="mobileNumber" name="MobileNumber" class="form-control" value="{{ $doctor->MobileNumber }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" id="email" name="email" class="form-control" value="{{ $doctor->email }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="specialization">Specialization</label>
                                                            <select id="specialization" name="specialization" class="form-control" required>
                                                                @foreach($specializations as $specialization)
                                                                <option value="{{ $specialization->id }}"
                                                                    {{ $doctor->specialization_id == $specialization->id ? 'selected' : '' }}>
                                                                    {{ $specialization->Specialization }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="status">Status</label>
                                                            <input type="text" id="status" class="form-control" value="{{ $doctor->status == '1' ? 'Active' : 'Inactive' }}" readonly>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No doctors found</td>
                            </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>S.No</th>
                                <th>Doctor Name</th>
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Specialization</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Edit</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div><!-- .row -->
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
@endpush