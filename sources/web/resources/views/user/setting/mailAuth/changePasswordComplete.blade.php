@extends('layouts.app')

@section('title')パスワード変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>パスワード変更完了</h1>
        </header>

        <p>
            パスワード変更が完了しました。
        </p>
    </div>
@endsection
