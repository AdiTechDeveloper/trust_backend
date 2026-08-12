<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Temple Trust Admin</title>

    {{-- Bootstrap 5 CSS (CDN se, npm install ki zaroorat nahi) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    {{-- Google Font - Poppins (premium look ke liye) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Hamara custom CSS (theme colors, sidebar design) --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">


    {{-- SweetAlert2 (delete confirmation, success messages ke liye) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    @stack('styles') {{-- Kisi specific page ko extra CSS chahiye toh yahan push ho sakta hai --}}
</head>
<body>

   @if(session('success') || session('error') || $errors->any())

    <div class="custom-toast-container">

        @if(session('success'))
            <div class="custom-toast custom-toast-success">
                <div class="toast-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div class="toast-message">
                    {{ session('success') }}
                </div>

                <button type="button" class="toast-close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif


        @if(session('error'))
            <div class="custom-toast custom-toast-error">
                <div class="toast-icon">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>

                <div class="toast-message">
                    {{ session('error') }}
                </div>

                <button type="button" class="toast-close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif


        @if($errors->any())
            <div class="custom-toast custom-toast-error">
                <div class="toast-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>

                <div class="toast-message">
                    {{ $errors->first() }}
                </div>

                <button type="button" class="toast-close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        @endif

    </div>

@endif

    <div class="admin-wrapper">

        {{-- Sidebar Partial Include --}}
        @include('layouts.partials.sidebar')

        <div class="main-content">

            {{-- Topbar Partial Include --}}
            @include('layouts.partials.topbar')

            {{-- Page Content --}}
            <div class="page-content">

                {{-- Session success/error messages ke liye common jagah --}}
                {{-- @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif --}}

                @yield('content')
                {{-- Har child page ka actual content yahan aayega --}}

            </div>

            @include('layouts.partials.footer')

        </div>

    </div>

    {{-- Bootstrap JS Bundle (Popper included) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- jQuery (DataTables ko chahiye hoga aage) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Hamara custom JS (sidebar toggle, dark mode) --}}
    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>

    @stack('scripts') {{-- Kisi page ko extra JS chahiye toh yahan push hoga --}}

   <script>
document.addEventListener('DOMContentLoaded', function () {

    const toasts = document.querySelectorAll('.custom-toast');

    toasts.forEach(function (toast) {

        // Close button
        const closeButton = toast.querySelector('.toast-close');

        closeButton.addEventListener('click', function () {
            removeToast(toast);
        });


        // Auto close after 4 seconds
        setTimeout(function () {
            removeToast(toast);
        }, 4000);

    });


    function removeToast(toast) {

        toast.style.animation = 'toastSlideOut 0.35s ease forwards';

        setTimeout(function () {
            toast.remove();
        }, 350);

    }

});
</script>


</body>
</html>