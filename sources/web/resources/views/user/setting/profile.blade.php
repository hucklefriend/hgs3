@extends('layouts.app')

@section('title')プロフィール編集@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>プロフィール編集</h1>
        </header>

        <form method="POST" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-group">
                <label for="name" class="hgn-label"><i class="fas fa-edit"></i> 名前</label>
                <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $user->name) }}">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'name'])
                <small class="form-text text-muted">最大文字数：50文字</small>
            </div>

            <div class="form-group">
                <label for="profile" class="hgn-label"><i class="fas fa-edit"></i> 自己紹介</label>
                <textarea class="form-control textarea-autosize{{ invalid($errors, 'profile') }}" id="profile" name="profile">{{ old('profile', $user->profile) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <p class="form-help">
                <small class="form-text text-muted">
                    @include('common.error', ['formName' => 'profile'])
                    最大文字数：500文字
                </small>
            </p>
            <div class="form-group text-center text-md-left">
                <button class="btn btn-info">保存</button>
            </div>
        </form>
    </div>

@endsection
