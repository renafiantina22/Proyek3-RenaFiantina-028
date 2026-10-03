<!DOCTYPE html>
<html lang="id">
<head>
    <title>Activity Manager</title>
</head>
<body>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    @yield('content')

</body>
</html>