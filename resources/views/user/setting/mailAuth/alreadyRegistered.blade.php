@extends('layouts.app')

@section('title')メール認証設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メール認証設定</h1>
        </header>

        <p>メール認証は設定済みです。</p>
    </div>
@endsection
