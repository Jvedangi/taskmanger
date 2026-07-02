<html>

<head>
    <title>Task Manger</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css"
        rel="stylesheet" />
</head>

<body class="bg-light">
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Task Manger</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</body>

</html>
