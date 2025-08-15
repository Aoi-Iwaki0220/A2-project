<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light " style="background-color: rgb(80, 228, 203);">
    <div class="container-fluid">
        <a class="navbar-brand" href="/home">
            <img src="{{ asset('logo1.png') }}" alt="ロゴ" style="width: 150px; margin-left: 1rem;">
        </a>

        <div class="collapse navbar-collapse ">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center gap-3">
                        @php
                            $user = null;
                            $userType = null;
                            if (Auth::guard('parent')->check()) {
                                $user = Auth::guard('parent')->user();
                                $userType = 'parent';
                            }elseif (Auth::guard('child')->check()) {
                                $user = Auth::guard('child')->user();
                                $userType = 'child';
                            }elseif (Auth::guard('admin')->check()) {
                                $user = Auth::guard('admin')->user();
                                $userType = 'admin';
                            }
                        @endphp
                    <div class="px-2 py-1">
                        @if ($user)
                            @if (Auth::guard('parent')->check())
                                <a href="{{ route('parent.mypage') }}" class="d-flex align-items-center text-decoration-none text-dark">
                            @elseif (Auth::guard('child')->check())
                                <a href="{{ route('child.mypage') }}" class="d-flex align-items-center text-decoration-none text-dark">
                            @elseif (Auth::guard('admin')->check())
                                <a href="{{ route('management') }}" class="d-flex align-items-center text-decoration-none text-dark">
                            @else
                                <a href="#">
                            @endif
                            
                            @if ($userType !== 'admin')
                                @if (!empty($user->image))
                                    <img src="{{ asset($user->image) }}" alt="アイコン" style="width:45px; height:45px; border-radius:50%;">
                                @else
                                    <img src="{{ asset('character1.png') }}" style="width:45px; height:45px; border-radius:50%;">
                                @endif
                                <span style="margin-left: 12px; font-weight: bold;">{{ $user->nickname }}</span>
                            @endif
                        </a>
                    </div>
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="margin-right: 1rem; font-weight: bold;">
                          ログアウト
                    </a>
                </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}" style="margin-right: 1rem;">新規登録</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@yield('content')
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    @yield('scripts')
    
</body>
</html>
