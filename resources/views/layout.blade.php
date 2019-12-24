<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charaset="UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>メモ</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        @if (Auth::check())
            <p>
                ようこそ {{ Auth::user()->name }} さん
                <a href="#" id="logout">ログアウト</a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}">ログイン</a>
             | 
            <a href="{{ route('register') }}">ユーザー登録</a>
        @endif
        
        @yield('content')

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        @if (Auth::check())
            <script>
                document.getElementById('logout').addEventListener('click', function(event) {
                    event.preventDefault();
                    document.getElementById('logout-form').submit();
                });
            </script>
        @endif
        @yield('scripts')
    </body>
</html>