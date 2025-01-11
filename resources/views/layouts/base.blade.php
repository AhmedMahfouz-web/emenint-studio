<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'نظام إدارة الفواتير') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('assets/fonts/Rubik-Regular.ttf') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/fonts/Rubik-Bold.ttf') }}" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        @font-face {
            font-family: 'Rubik';
            src: url('{{ asset('assets/fonts/Rubik-Regular.ttf') }}') format('truetype');
            font-weight: normal;
        }

        @font-face {
            font-family: 'Rubik';
            src: url('{{ asset('assets/fonts/Rubik-Bold.ttf') }}') format('truetype');
            font-weight: bold;
        }
        
        :root {
            --primary-color: #333;
            --secondary-color: #555;
            --text-light: #fff;
            --text-hover: #ccc;
        }

        body {
            font-family: 'Rubik', sans-serif;
            font-size: 16px;
            line-height: 1.5;
            -webkit-text-size-adjust: 100%;
        }

        /* Mobile-first navbar styles */
        .navbar {
            background-color: var(--primary-color);
            padding: 0.75rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--text-light);
            font-size: 1.25rem;
            font-weight: bold;
            margin-right: 1rem;
            white-space: nowrap;
        }

        .navbar-toggler {
            padding: 0.5rem;
            border-color: rgba(255,255,255,0.1);
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-nav {
            margin: 0.5rem 0;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            color: var(--text-light);
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: all 0.2s ease;
        }

        .nav-link:hover {
            color: var(--text-hover);
            background-color: rgba(255,255,255,0.1);
        }

        .nav-link.active {
            color: var(--text-light);
            background-color: var(--secondary-color);
        }

        /* Form controls */
        .form-control, .form-select {
            font-size: 1rem;
            padding: 0.75rem;
            border-radius: 0.5rem;
        }

        /* Buttons */
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        /* Cards */
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .card-header {
            padding: 1rem;
            background-color: rgba(0,0,0,0.02);
        }

        /* Tables */
        .table-responsive {
            margin: 1rem 0;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        /* Alerts */
        .alert {
            border-radius: 0.5rem;
            margin: 1rem 0;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }

            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .navbar-brand {
                font-size: 1.1rem;
            }

            .btn {
                padding: 0.5rem 1rem;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
        }

        @media (min-width: 992px) {
            .navbar-nav {
                margin: 0;
            }

            .nav-item {
                margin: 0 0.25rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">نظام إدارة الفواتير</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            الرئيسية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                            الفواتير
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}" href="{{ route('quotations.index') }}">
                            عروض الأسعار
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                            العملاء
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            المنتجات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            التقارير
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @hasSection('content')
        @yield('content')
    @else
        {{ $slot ?? '' }}
    @endif

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>
</html>
