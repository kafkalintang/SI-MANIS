<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiMANiS')</title>
    <link rel="icon" href="{{ asset('images/polibatam.png') }}" type="image/png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            padding-top: 56px;
        }
        .content {
            margin-left: 230px;
            padding-top: 100px;
            min-height: calc(100vh - 56px);
            overflow-y: auto;
        }
    </style>
    
</head>
<body>
    @include('components.navbar_pengguna')
    @include('components.sidebar_pengguna')

    <div class="content p-4">
        @yield('content')
    </div>

    @stack('modals')

</body>
</html>