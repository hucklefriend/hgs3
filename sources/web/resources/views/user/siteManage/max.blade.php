@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト管理') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト登録</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">登録できません。</h4>

                <p>登録できるサイトは10個までです。</p>
            </div>
        </div>
    </div>
@endsection
