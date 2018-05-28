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

            <div class="form-group">
                <label for="profile" class="hgn-label"><i class="fas fa-check"></i> 性的表現の確認</label>
                <div class="form-check">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="adult"{{ checked(old('checkbox', $user->adult), 1) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">18歳以上で、かつ性的な表現があっても問題ありません</span>
                    </label>
                </div>
            </div>
            <div class="form-help">
                <p class="text-muted">
                    <small>
                        18禁エロゲのパッケージが表示されるようになります。<br>
                        CERO-Zのパッケージには影響しません。<br>
                        ※今後、イラストや小説などのアップロードといった機能が実装されるとなれば、このチェックが影響するかもしれません。
                    </small>
                </p>
            </div>
            <div class="form-group text-center text-md-left">
                <button class="btn btn-info">プロフィール更新</button>
            </div>
        </form>
    </div>

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