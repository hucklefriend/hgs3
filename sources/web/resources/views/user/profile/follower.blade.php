@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url2('user/profile') }}/{{ $user->id }}">プロフィールに戻る</a>
    </div>

    {{ $followers->links() }}

    <ul class="list-group">
        @foreach ($followers as $f)
            <li class="list-group-item"><a href="{{ url2('user/profile') }}/{{ $f->user_id }}">{{ un($users, $f->user_id) }}</a></li>
        @endforeach
    </ul>

    {{ $followers->links() }}

@endsection