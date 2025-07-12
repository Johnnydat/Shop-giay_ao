<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop now</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome cho icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        /* Custom Styles */
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #0d6efd !important;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #0d6efd !important;
        }

        .search-bar {
            max-width: 500px;
            width: 100%;
        }

        .cart-icon {
            position: relative;
        }

        .cart-icon .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #dc3545;
            color: white;
            font-size: 0.75rem;
        }

        .footer {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 40px 0;
        }

        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }

        .footer a:hover {
            color: #0d6efd;
        }

        .footer h5 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .newsletter-form .form-control {
            border-radius: 0;
        }

        .newsletter-form .btn {
            border-radius: 0;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    @include('client.partials.nav')

    <!-- Main Content Placeholder -->
    <main class="container my-5">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('client.partials.footer')
    
    @include('client.partials.chatbot') {{-- phần HTML giao diện chatbot --}}

    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    <script src="{{ asset('js/chatbot.js') }}" defer></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
