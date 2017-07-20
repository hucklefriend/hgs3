@extends('layouts.app')

@section('content')

    <section>
        <h5>{{ $user->name }}さんのプロフィール</h5>
    </section>

    @if ($isMyself)
    <p><a href="{{ url('user/profile/edit') }}">プロフィール編集</a></p>
    @endif

    <ul>
        <li>投稿したレビュー ()</li>
    </ul>

@endsection