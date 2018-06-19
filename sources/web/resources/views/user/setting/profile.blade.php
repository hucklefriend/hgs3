@extends('layouts.app')

@section('title')プロフィール編集@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>プロフィール編集</h1>
        </header>

        <form method="POST" action="{{ route('プロフィール編集実行') }}" autocomplete="off">
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
                <label for="name" class="hgn-label"><i class="fas fa-edit"></i> 属性</label>
                <div>
                @foreach (\Hgs3\Constants\User\Attribute::$text as $id => $name)
                    <label class="custom-control custom-checkbox mb-2">
                        <input type="checkbox" class="custom-control-input" name="attribute[{{ $id }}]" value="{{ $id }}"{{ checked(isset($attributes[$id]), true) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">{{ $name }}</span>
                    </label>
                @endforeach
                </div>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'attribute'])
                <small class="form-text text-muted">
                    ホラーゲームに対して、何をする人なのかを設定できます。<br>
                    フレンド探しに利用しますので、よろしければ設定してください。<br>
                    <br>
                    例：<br>
                    &nbsp;&nbsp;二次創作でイラストを描いている … 絵を描く人<br>
                    &nbsp;&nbsp;仕事や趣味でホラーゲームを作っている … ゲームを開発する人<br>
                    &nbsp;&nbsp;二次創作で漫画を描いている … 絵を描く人と物語を書く人
                </small>
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
