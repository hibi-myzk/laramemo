@extends('layout')

@section('content')
    <div>
        <h1>ログイン</h1>
    </div>
    
    <div>
        @if ($errors->any())
            @foreach ($errors->all() as $message)
                <p>{{ $message }}</p>
            @endforeach
        @endif
    </div>

    <div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="email">メールアドレス</label>
                <input type="text" name="email" id="email" value="{{ old('email') }}" />
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="text" name="password" id="password" />
            </div>
            <div>
                <button type="submit">送信</button>
            </div>
        </form>
    </div>
@endsection