@extends('layout')

@section('content')
    @if($errors->any())
        <ul>
            @foreach($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('memos.update', [ 'memo' => $memo ]) }}" method="post">
        @csrf
        @method('PATCH')
        <input type="text" name="body" id="memo_body" value="{{ old('body', $memo->body) }}" />
        <button type="submit">保存</button>
    </form>

    <p><a href="{{ route('memos.show', [ 'memo' => $memo ]) }}">キャンセル</a></p>
@endsection