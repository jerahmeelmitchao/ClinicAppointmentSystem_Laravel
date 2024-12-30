@extends('layouts.doctor', ['title' => 'Specializations List'])

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title">Specializations List</h4>
            </header><!-- .widget-header -->
            <hr class="widget-separator">
            <div class="widget-body">
                <form method="GET" action="{{ route('specialization.search') }}">
                    <div class="row mb-3" style="margin-bottom: 15px;">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" style="width: 100%;" placeholder="Search by name" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">Search</button>
                        </div>
                        <div class="col-md-2 text-right">
                            <!-- Add Specialization Button -->
                            <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#addSpecializationModal">Add Specialization</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Specialization</th>
                                <th>Edit</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach ($specializations as $specialization)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $specialization->Specialization }}</td>
                                <td>
                                    <!-- Edit Button (Triggers Modal) -->
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editSpecializationModal{{ $specialization->id }}">
                                        Edit
                                    </button>

                                    <!-- Modal for editing specialization details -->
                                    <div class="modal fade" id="editSpecializationModal{{ $specialization->id }}" tabindex="-1" role="dialog" aria-labelledby="editSpecializationModalLabel{{ $specialization->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSpecializationModalLabel{{ $specialization->id }}">Edit Specialization</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('specialization.update', $specialization->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="specializationName">Specialization Name</label>
                                                            <input type="text" id="specializationName" name="Specialization" class="form-control" value="{{ $specialization->Specialization }}" required>
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
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>S.No</th>
                                <th>Specialization</th>
                                <th>Edit</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div><!-- .row -->

<!-- Add Specialization Modal -->
<div class="modal fade" id="addSpecializationModal" tabindex="-1" role="dialog" aria-labelledby="addSpecializationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSpecializationModalLabel">Add New Specialization</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('specialization.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="newSpecialization">Specialization Name</label>
                        <input type="text" id="newSpecialization" name="Specialization" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Specialization</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
@endpush
