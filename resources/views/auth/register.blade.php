@extends('layout')

@section('content')
    <div>
        <h1>ユーザー登録</h1>
    </div>
    
    <div>
        @if ($errors->any())
            @foreach ($errors->all() as $message)
                <p>{{ $message }}</p>
            @endforeach
        @endif
    </div>

    <div>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div>
                <label for="email">メールアドレス</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}" />
            </div>
            <div>
                <label for="name">ユーザー名</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" />
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="text" name="password" id="password" />
            </div>
            <div>
                <label for="password">パスワード（確認）</label>
                <input type="text" name="password_confirmation" id="password_confirmation" />
            </div>
            <div>
                <button type="submit">送信</button>
            </div>
        </form>
    </div>
@endsection