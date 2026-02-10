<!-- Site Header Partial (nav) -->
<nav class="navbar navbar-expand-lg navbar-light bg-white" style="margin-bottom: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.04); min-height: 80px;">
    <div class="container-fluid py-3">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="height: 60px; margin-right: 15px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <span style="font-weight: bold; font-size: 1.4rem; color: #ff6600;">Dab's Beauty Touch</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('home') }}#home">Home</a></li>
                <li class="nav-item"><a class="nav-link px-3" id="navServicesLink" href="{{ route('home') }}#services">Services</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('home') }}#about">About</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('home') }}#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('home') }}#faq">FAQ</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('home') }}#terms">Terms</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ route('calendar') }}" style="background: linear-gradient(135deg, #ff6600 0%, #ff8533 100%); color: white; border-radius: 20px; padding: 8px 20px !important;">Book Appointment</a></li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('account.bookings') }}" style="font-weight:700;">My Bookings</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link px-3 btn btn-link" style="text-decoration:none;font-weight:700;">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth

                @guest
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-weight:500; opacity:0.75;">
                            <i class="bi bi-person-circle me-1"></i>Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}"><i class="bi bi-person-plus me-2"></i>Create Account</a></li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
