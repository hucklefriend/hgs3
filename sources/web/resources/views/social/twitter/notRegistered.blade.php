@extends('layouts.app')

@section('title')Twitterでログイン@endsection
@section('global_back_link'){{ route('ログイン') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>Twitterでログイン</h1>
        </header>

        <p>このアカウントは登録されていません。</p>
    </div>
@endsection