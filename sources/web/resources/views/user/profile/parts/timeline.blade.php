@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url2('user/profile') }}/{{ $user->id }}">プロフィールに戻る</a>
    </div>

    {{ $follows->links() }}

    <ul class="list-group">
        @foreach ($follows as $f)
            <li class="list-group-item"><a href="{{ url2('user/profile') }}/{{ $f->follow_user_id }}">{{ un($users, $f->follow_user_id) }}</a></li>
        @endforeach
    </ul>

    {{ $follows->links() }}

@endsection