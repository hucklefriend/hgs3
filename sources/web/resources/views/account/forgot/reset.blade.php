@extends('layouts.app')

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>パスワード再設定</h1>
        </header>

        <form method="POST" action="{{ route('パスワード再設定処理') }}" autocomplete="off">
            <input type="hidden" name="token" value="{{ $token }}">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="password" class="hgn-label"><i class="fas fa-edit"></i> パスワード</label>
                <input type="password" class="form-control{{ invalid($errors, 'password') }}" id="password" name="password" required minlength="4" maxlength="16" placeholder="パスワード">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'password'])
                <small class="form-text text-muted">
                    4～16文字で入力してください。<br>
                    使える文字は、アルファベット大文字( A～Z )、アルファベット小文字( a～z )、数字( 0～9 )、ハイフン( - )、アンダーバー( _ )です。
                </small>
            </div>

            <div class="form-group hgn-label">
                <label for="password_confirmation"><i class="fas fa-edit"></i> パスワード(同じものを)</label>
                <input type="password" class="form-control{{ invalid($errors, 'password_confirmation') }}" id="password_confirmation" name="password_confirmation" required minlength="4" maxlength="16" placeholder="パスワード(再入力)">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'password_confirmation'])
                <small class="form-text text-muted">
                    上で入力したものと同じものを入力してください。
                </small>
            </div>

            <button class="btn btn-primary">登録</button>
        </form>
    </div>
@endsection
