<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-in   secure-requests" />
    <link rel="icon" type="image/x-icon" href="{{url('favicon.jpg')}}">
    <title>Trustme - Operational</title>
    @include('layouts.head')
</head>

<body class="bg-light">

    <div class="wrapper d-flex" style="height: 100vh;">
        @if (session('status') == 'login')
        @include('layouts.sidebar')
        @endif
        <div class="main w-100">
            @if (session('status') == 'login')
            @include('layouts.navbar')
            @endif
            <div class="content " style="height: 90vh; overflow-y:scroll; overflow-x:hidden;">
                <div class="container">
                @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')


</body>

</html>