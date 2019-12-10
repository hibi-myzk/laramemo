<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charaset="UTF-8" />
        <title>メモ</title>
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

        @if (Auth::check())
            <script>
                document.getElementById('logout').addEventListener('click', function(event) {
                    event.preventDefault();
                    document.getElementById('logout-form').submit();
                });
            </script>
        @endif
    </body>
</html>