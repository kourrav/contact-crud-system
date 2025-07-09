<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Contacts CRUD System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts - Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('contacts.index') }}">
                <i class="fas fa-address-book"></i> Contacts CRUD System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contacts.index') }}">
                            <i class="fas fa-users"></i> Contacts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contacts.merged') }}">
                            <i class="fas fa-object-group"></i> Merged Contacts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('custom-fields.index') }}">
                            <i class="fas fa-cogs"></i> Custom Fields
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
        
        <!-- Fancybox Test Button (temporary) -->
        <!-- <div class="position-fixed bottom-0 end-0 m-3" style="z-index: 1050;">
            <button type="button" class="btn btn-primary" onclick="testFancybox()">
                <i class="fas fa-image"></i> Test Fancybox
            </button>
        </div> -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <!-- Custom JavaScript Files -->
    <script src="{{ asset('js/common.js') }}"></script>
    <script>
        // Test Fancybox function (for debugging)
        function testFancybox() {
            console.log('Testing Fancybox...');
            if (typeof Fancybox !== 'undefined') {
                Fancybox.show([
                    {
                        src: "https://picsum.photos/800/600",
                        type: "image",
                        caption: "Test Image"
                    }
                ]);
                console.log('Fancybox test successful');
            } else {
                console.error('Fancybox is not available');
                alert('Fancybox is not loaded. Please check the console for errors.');
            }
        }
    </script>
    
    @yield('scripts')
</body>
</html> 