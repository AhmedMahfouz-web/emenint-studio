@extends('layouts.base')

@section('content')
<div class="min-vh-100 bg-light">
    <!-- Page Content -->
    <main class="py-3">
        <div class="container-fluid px-3 px-md-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('page-content')
        </div>
    </main>
</div>

@stack('styles')
@stack('scripts')

@endsection
