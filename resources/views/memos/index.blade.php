@extends('layout')

@section('content')
    <p><a href="{{ route('memos.new') }}">メモを追加</a></p>
    <ul>
        @foreach($memos as $memo)
            <li><a href="{{ route('memos.show', ['memo' => $memo]) }}">{{ $memo->body }}</a></li>
        @endforeach
    </ul>
@endsection