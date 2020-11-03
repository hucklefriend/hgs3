@extends('layouts.app')

@section('title')ユーザー登録@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ユーザー登録</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">登録できません</h4>

                <p class="mb-0">入力されたメールアドレスは利用できません。</p>
            </div>
        </div>
    </div>
@endsection
