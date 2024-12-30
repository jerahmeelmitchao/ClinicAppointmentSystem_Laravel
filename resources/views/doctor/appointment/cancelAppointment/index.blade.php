@extends('layouts.doctor', ['title' => 'Cancel Appointment'])

@section('content')
<div class="row">
    <!-- DOM dataTable -->
    <div class="col-md-12">
        <div class="widget">
            <header class="widget-header">
                <h4 class="widget-title">Cancel Appointment</h4>
            </header><!-- .widget-header -->
            <hr class="widget-separator">
            <div class="widget-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover js-basic-example dataTable table-custom">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Appointment Number</th>
                                <th>Patient Name</th>
                                <th>Chosen Doctor</th> <!-- Added Chosen Doctor column -->
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @if ($appointments != null || $appointments != 0)
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $appointment->AppointmentNumber }}</td>
                                        <td>{{ $appointment->Name }}</td>
                                        <td>{{ $appointment->doctor ? $appointment->doctor->name : 'N/A' }}</td> <!-- Display Doctor Name -->
                                        <td>{{ $appointment->MobileNumber }}</td>
                                        <td>{{ $appointment->Email }}</td>

                                        @if ($appointment->Status == 'Cancelled')
                                            <td class="bg-danger text-white">Cancelled</td> <!-- Red background for Cancelled -->
                                        @elseif ($appointment->Status == 'Not Updated Yet')
                                            <td class="bg-warning text-dark">Not Updated Yet</td> <!-- Yellow background for Not Updated -->
                                        @else
                                            <td>{{ $appointment->Status }}</td> <!-- Default for other statuses -->
                                        @endif

                                        <td><a href="{{ route('detailAppointment.show', [$appointment->id, $appointment->AppointmentNumber]) }}"
                                                class="btn btn-primary">View</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8">No record found against this search</td>
                                </tr>
                            @endif
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>S.No</th>
                                <th>Appointment Number</th>
                                <th>Patient Name</th>
                                <th>Chosen Doctor</th> <!-- Added Chosen Doctor column -->
                                <th>Mobile Number</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div><!-- END column -->
</div><!-- .row -->
@endsection
