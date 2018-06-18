@extends('layouts.app')

@section('title')プロフィール公開範囲設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>プロフィール公開範囲設定</h1>
        </header>

        <form method="POST" action="{{ route('プロフィール公開範囲設定保存') }}" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-group">
                <div>
                    <label for="profile" class="hgn-label"><i class="fas fa-check"></i> 公開範囲設定</label>
                </div>
                <label class="custom-control custom-radio mb-2">
                    <input type="radio" class="custom-control-input" name="flag" id="flag0" value="0"{{ checked(old('flag', $user->profile_open_flag), 0) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">非公開</span>
                </label>
                <label class="custom-control custom-radio mb-2">
                    <input type="radio" class="custom-control-input" name="flag" id="flag1" value="1"{{ checked(old('flag', $user->profile_open_flag), 1) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">メンバーのみ</span>
                </label>
                <label class="custom-control custom-radio mb-2">
                    <input type="radio" class="custom-control-input" name="flag" id="flag2" value="2"{{ checked(old('flag', $user->profile_open_flag), 2) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">誰にでも</span>
                </label>
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
                <button class="btn btn-info">プロフィール公開範囲設定</button>
            </div>
        </form>
    </div>

@endsection
