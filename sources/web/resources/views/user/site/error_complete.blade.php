@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('/user/site/myself') }}">サイト一覧へ戻る</a>
    </div>

    <p>このサイトは編集できません。</p>

@endsection