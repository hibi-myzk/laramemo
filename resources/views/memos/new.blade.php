@extends('layout')

@section('content')
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('memos.create') }}" method="post">
        @csrf
        <input type="text" name="body" id="memo_body" value="{{ old('body') }}" />
        <button type="submit">保存</button>
    </form>

    <p><a href="{{ route('memos.index') }}">キャンセル</a></p>
@endsection