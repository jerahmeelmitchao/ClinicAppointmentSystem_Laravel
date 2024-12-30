<nav class="navbar navbar-expand-lg bg-light fixed-top shadow-lg">
    <div class="container">
        <a class="navbar-brand mx-auto d-lg-none" href="#">
            Doctor Appointment
            <strong class="d-block">Management System</strong>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>

                <a class="navbar-brand d-none d-lg-block" href="/">
                    Clinic 
                    <strong class="d-block">Appointment System</strong>
                </a>

                <li class="nav-item">
                    <a class="nav-link" href="#booking">Booking</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('appointment.check') }}">Check Appointment</a>
                </li>
                
                <li class="nav-item active">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#adminPasswordModal">Doctor</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Admin Password Modal -->
<div class="modal fade" id="adminPasswordModal" tabindex="-1" aria-labelledby="adminPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminPasswordModalLabel">Admin Password Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="adminPasswordForm">
                    <div class="mb-3">
                        <label for="adminPassword" class="form-label">Enter Admin Password</label>
                        <input type="password" class="form-control" id="adminPassword" placeholder="Password" required>
                    </div>
                    <div id="passwordError" class="text-danger d-none">Incorrect password. Please try again.</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitPassword">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitPassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('adminPassword').value;
        const passwordError = document.getElementById('passwordError');

        // Replace 'your_admin_password' with the actual password to check
        const correctPassword = 'password';

        if (passwordInput === correctPassword) {
            window.location.href = "{{ route('login') }}";
        } else {
            passwordError.classList.remove('d-none');
        }
    });
</script>
