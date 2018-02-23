@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ユーザー設定') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>プロフィール編集</h1>

    <form method="POST" autocomplete="off">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $user->name) }}">
            @include('common.error', ['formName' => 'name'])
            <small class="form-text text-muted">最大文字数：50文字</small>
        </div>
        <div class="form-group">
            <label for="profile">自己紹介</label>
            <textarea class="form-control{{ invalid($errors, 'profile') }}" id="profile" name="profile" rows="5">{{ old('profile', $user->profile) }}</textarea>
            @include('common.error', ['formName' => 'profile'])
            <small class="form-text text-muted">最大文字数：500文字</small>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" value="1" name="adult"{{ checked(old('checkbox', $user->adult), 1) }}>
                18歳以上
            </label>
            <small class="form-text text-muted">18禁ゲームへのアクセスができるようになります。</small>
        </div>
        <div class="form-group" style="margin-top: 15px;">
            <button class="btn btn-info">プロフィール更新</button>
        </div>
    </form>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">プロフィール編集</li>
        </ol>
    </nav>
@endsection