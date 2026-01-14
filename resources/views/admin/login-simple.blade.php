<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Dab's Beauty Touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Animated background elements */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
            animation: float 15s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 50px 40px;
            max-width: 450px;
            width: 100%;
            margin: 20px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.2);
            position: relative;
            transform: translateY(20px);
            animation: slideUp 0.8s ease-out forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 25px;
            z-index: -1;
        }

        .brand-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            animation: pulse 2s ease-in-out infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }

        .brand-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
        }

        .brand-subtitle {
            color: #718096;
            font-size: 0.95rem;
            font-weight: 400;
        }

        .form-floating {
            margin-bottom: 20px;
            position: relative;
        }

        .form-floating > .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-floating > .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .form-floating > label {
            left: 3rem;
            color: #718096;
            font-weight: 500;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            z-index: 10;
            font-size: 1.1rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #718096;
            cursor: pointer;
            z-index: 10;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .login-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 20px;
            font-weight: 500;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .alert-danger {
            background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
            color: #c53030;
            border-left: 4px solid #e53e3e;
        }

        .alert-success {
            background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
            color: #2f855a;
            border-left: 4px solid #38a169;
        }

        .divider {
            text-align: center;
            margin: 30px 0 20px;
            position: relative;
            color: #a0aec0;
            font-size: 0.875rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 15px;
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
        }

        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-link a:hover {
            color: #764ba2;
            transform: translateX(-3px);
        }

        .credentials-info {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 12px;
            padding: 20px;
            margin-top: 25px;
            border: 1px solid #e2e8f0;
        }

        .credentials-info h6 {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .credentials-info .credential-item {
            background: white;
            border-radius: 8px;
            padding: 8px 12px;
            margin: 5px 0;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            color: #4a5568;
            border: 1px solid #e2e8f0;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
                padding: 30px 25px;
            }

            .brand-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Brand Section -->
        <div class="brand-section">
            <div class="brand-logo">
                <i class="bi bi-gem"></i>
            </div>
            <h1 class="brand-title">Admin Portal</h1>
            <p class="brand-subtitle">Dab's Beauty Touch Management</p>
        </div>

        <!-- Alert Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="/admin/login" id="loginForm">
            @csrf

            <div class="form-floating">
                <i class="input-icon bi bi-envelope-fill"></i>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="admin@example.com"
                       required
                       autocomplete="email"
                       autofocus>
                <label for="email">Email Address</label>
            </div>

            <div class="form-floating">
                <i class="input-icon bi bi-lock-fill"></i>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       placeholder="Password"
                       required
                       autocomplete="current-password">
                <label for="password">Password</label>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                <span class="btn-text">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Sign In to Dashboard
                </span>
                <div class="loading-spinner"></div>
            </button>
        </form>



        <!-- Back to Website Link -->
        <div class="back-link">
            <a href="{{ route('home') }}">
                <i class="bi bi-arrow-left"></i>
                Back to Website
            </a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ensure form action uses HTTPS to prevent mixed content errors
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            if (loginForm && window.location.protocol === 'https:') {
                const currentAction = loginForm.action;
                if (currentAction && currentAction.startsWith('http://')) {
                    loginForm.action = currentAction.replace('http://', 'https://');
                } else if (currentAction && currentAction.startsWith('/')) {
                    // Relative URL - ensure it uses current protocol
                    loginForm.action = window.location.protocol + '//' + window.location.host + currentAction;
                }
            }
        });

        // Toggle password visibility
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.className = 'bi bi-eye-slash';
            } else {
                passwordField.type = 'password';
                toggleIcon.className = 'bi bi-eye';
            }
        }

        // Enhanced form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('loginBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.loading-spinner');

            // Show loading state
            btnText.style.display = 'none';
            spinner.style.display = 'inline-block';
            submitBtn.disabled = true;

            // Optional: Add a minimum loading time for better UX
            setTimeout(() => {
                // Form will submit naturally after this
            }, 800);
        });

        // Auto-hide alerts after 5 seconds with smooth animation
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);

        // Add enter key support for better accessibility
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const form = document.getElementById('loginForm');
                const emailField = document.getElementById('email');
                const passwordField = document.getElementById('password');

                if (emailField.value && passwordField.value) {
                    form.submit();
                }
            }
        });

        // Add focus management
        document.addEventListener('DOMContentLoaded', function() {
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');

            emailField.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    passwordField.focus();
                }
            });
        });

        // Add smooth form validation feedback
        const inputs = document.querySelectorAll('input[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.style.borderColor = '#e53e3e';
                    this.style.boxShadow = '0 0 0 3px rgba(229, 62, 62, 0.1)';
                } else {
                    this.style.borderColor = '#38a169';
                    this.style.boxShadow = '0 0 0 3px rgba(56, 161, 105, 0.1)';
                }
            });

            input.addEventListener('input', function() {
                if (this.style.borderColor) {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                }
            });
        });
    </script>
</body>
</html>
