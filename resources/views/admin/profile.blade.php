<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Profile - Dab's Beauty Touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e3eafc 100%);
            min-height: 100vh;
            padding-top: 80px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .profile-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 20px 0;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .profile-header {
            background: linear-gradient(135deg, #030f68 0%, #05137c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .profile-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .profile-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        .profile-body {
            padding: 40px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #030f68;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #ff6600;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control:focus {
            border-color: #ff6600;
            box-shadow: 0 0 0 0.2rem rgba(255, 102, 0, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 8px;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
        }

        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #0ea5e9;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 25px;
        }

        .info-box i {
            color: #0ea5e9;
            margin-right: 10px;
        }

        .password-strength {
            height: 4px;
            border-radius: 2px;
            margin-top: 8px;
            transition: all 0.3s ease;
        }

        .password-strength.weak {
            background: #dc3545;
            width: 33%;
        }

        .password-strength.medium {
            background: #ffc107;
            width: 66%;
        }

        .password-strength.strong {
            background: #28a745;
            width: 100%;
        }

        @media (max-width: 768px) {
            .profile-body {
                padding: 20px;
            }

            .profile-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 40px; margin-right: 10px;">
                <span style="font-weight: bold; font-size: 1.3rem; color: #ff6600;">Dab's Beauty Touch</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person-circle me-1"></i>Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link" style="background: none; border: none; color: #dc3545; font-weight: 600;">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <h1><i class="bi bi-person-circle me-2"></i>Admin Profile</h1>
                <p>Manage your account settings</p>
            </div>

            <div class="profile-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Change Email Section -->
                <div class="mb-5">
                    <h2 class="section-title">
                        <i class="bi bi-envelope me-2"></i>Change Email Address
                    </h2>
                    
                    <div class="info-box">
                        <i class="bi bi-info-circle-fill"></i>
                        <strong>Current Email:</strong> {{ $user->email ?? 'N/A' }}
                    </div>

                    <form method="POST" action="{{ route('admin.profile.update-email') }}" id="emailForm">
                        @csrf
                        <div class="mb-3">
                            <label for="new_email" class="form-label">New Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="new_email" name="email" 
                                   value="{{ old('email') }}" required placeholder="Enter new email address">
                        </div>
                        <div class="mb-3">
                            <label for="email_password" class="form-label">Confirm Current Password</label>
                            <input type="password" class="form-control form-control-lg" id="email_password" 
                                   name="password" required placeholder="Enter your current password">
                            <small class="form-text text-muted">You must enter your current password to change your email.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-envelope-check me-2"></i>Update Email
                        </button>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="mb-5">
                    <h2 class="section-title">
                        <i class="bi bi-shield-lock me-2"></i>Change Password
                    </h2>

                    <form method="POST" action="{{ route('admin.profile.update-password') }}" id="passwordForm">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control form-control-lg" id="current_password" 
                                   name="current_password" required placeholder="Enter current password">
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control form-control-lg" id="new_password" 
                                   name="password" required placeholder="Enter new password" 
                                   minlength="8" oninput="checkPasswordStrength(this.value)">
                            <div class="password-strength" id="passwordStrength"></div>
                            <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control form-control-lg" id="password_confirmation" 
                                   name="password_confirmation" required placeholder="Confirm new password">
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-key me-2"></i>Update Password
                        </button>
                    </form>
                </div>

                <!-- Account Information -->
                <div>
                    <h2 class="section-title">
                        <i class="bi bi-person-badge me-2"></i>Account Information
                    </h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Name:</strong></div>
                                <div class="col-sm-8">{{ $user->name ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8">{{ $user->email ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Account Type:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-primary">Administrator</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Member Since:</strong></div>
                                <div class="col-sm-8">{{ $user->created_at ? $user->created_at->format('F j, Y') : 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrength');
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            strengthBar.className = 'password-strength';
            if (strength <= 2) {
                strengthBar.classList.add('weak');
            } else if (strength <= 3) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
        }

        // Form validation
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New password and confirmation password do not match!');
                return false;
            }

            if (newPassword.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long!');
                return false;
            }
        });

        document.getElementById('emailForm').addEventListener('submit', function(e) {
            const email = document.getElementById('new_email').value;
            const currentEmail = '{{ $user->email ?? '' }}';

            if (email === currentEmail) {
                e.preventDefault();
                alert('New email must be different from your current email!');
                return false;
            }
        });
    </script>
</body>
</html>

