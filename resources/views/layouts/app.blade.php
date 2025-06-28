<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'User Managerment System') </title>
      <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
      <style>
        footer.footer-bottom
        {
            position: absolute;
            left: 40%;
        }
        
     </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">User managerment System @if(session()->has('user'))- Admin @endif</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/list') }}">Users List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/add-user') }}">Add User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/logout') }}">LogOut</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="text-center mt-4 mb-3 text-muted py-3 footer-bottom">
        © {{ date('Y') }} User Management System. All rights reserved.
    </footer>
<script src="{{asset('js/jquery.js')}}"></script>
@yield('scripts')
</body>
</html>
