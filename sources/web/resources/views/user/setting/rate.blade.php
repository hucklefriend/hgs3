@extends('layouts.app')

@section('title')年齢制限コンテンツの表示設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>年齢制限コンテンツの表示設定</h1>
        </header>

        <form method="POST" action="{{ route('R-18表示設定保存') }}" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-group">
                <label for="profile" class="hgn-label"><i class="fas fa-check"></i> 性的表現の確認</label>
                <div class="form-check">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="adult"{{ checked(old('checkbox', $user->adult), 1) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">18歳以上で、かつ暴力や性的な表現があっても問題ありません</span>
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
                <button class="btn btn-info">年齢制限コンテンツ設定の更新</button>
            </div>
        </form>
    </div>

@endsection
