@extends('layouts.app')

@section('title')メールアドレス変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>メールアドレス変更完了</h1>
        </header>

        <p>メールアドレスの変更が完了しました。</p>
    </div>
@endsection
