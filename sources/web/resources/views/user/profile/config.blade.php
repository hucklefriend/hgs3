@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    <h1>設定</h1>

    @if ($isComplete)
        <div id="msg" class="alert alert-success" role="alert">
            設定完了しました。
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <form method="POST" autocomplete="off" action="{{ route('コンフィグ更新') }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <div class="form-group">
            <label for="name">足跡</label>

            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="footprint" id="footprint1" value="{{ 1 }}"{{ checked($user->footprint, old('footprint', 1)) }}>
                    残す
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="footprint" id="footprint0" value="{{ 0 }}"{{ checked($user->footprint, old('footprint', 0)) }}>
                    残さない
                </label>
            </div>

            @include('common.error', ['formName' => 'name'])
            <small class="form-text text-muted">
                サイトへアクセスした時に、足跡を残しません。（カウントは上がります。）<br>
                足跡を残すと、あなたがいつH.G.N.からサイトにアクセスしたかをサイト管理者さんに知らせることができます。
            </small>
        </div>
        <div class="form-group">
            <button class="btn btn-info">設定変更</button>
        </div>
    </form>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">設定</li>
        </ol>
    </nav>
@endsection