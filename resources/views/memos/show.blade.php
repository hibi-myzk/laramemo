@extends('layout')

@section('content')
    <div>
        {{ $memo->body }}
    </div>
    <div>
        created: {{ $memo->formatted_created_at }}
    </div>
    <div>
        updated: {{ $memo->formatted_updated_at }}
    </div>

    <p><a href="{{ route('memos.edit', [ 'memo' => $memo ]) }}">編集</a></p>
    <p><a href="{{ route('memos.index') }}">戻る</a></p>
@endsection