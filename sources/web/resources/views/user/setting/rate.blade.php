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
                <label for="profile" class="hgn-label"><i class="fas fa-check"></i> 年齢制限コンテンツ表示の確認</label>
                <div class="form-check">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" value="1" name="adult"{{ checked(old('checkbox', $user->adult), 1) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">18歳以上で、かつ暴力や性的な表現があっても問題ありません</span>
                    </label>
                </div>
            </div>
            <div class="form-help">
                <p class="mt-3">チェックを入れた場合に動作が変わる場所は以下の通りです。</p>

                <ul>
                    <li>18禁ゲームのパッケージ画像の表示</li>
                    <li>エロゲの公式サイト等へのリンクの表示</li>
                    <li>18禁ゲームのアフィリエイトリンクの表示</li>
                    <li>エロゲのデータを表示しているページで、エロゲのスポンサーリンクの表示</li>
                    <li>R-18サイトのR-18用バナーの表示</li>
                </ul>

                <p class="mb-0">18禁ゲームは、CERO-Z、エロゲ、(国内販売されていないゲームに限り)ESRB MまたはESRB AO指定のゲームです。</p>
                <p class="mb-0">※今後、イラストのアップロードといった機能が実装されるとなれば、このチェックが影響するかもしれません。</p>
            </div>
            <div class="form-group text-center text-md-left">
                <button class="btn btn-info">保存</button>
            </div>
        </form>
    </div>

@endsection
