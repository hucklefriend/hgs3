@extends('layouts.app')

@section('title')ユーザー登録@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ユーザー登録</h1>

        </header>

        <div class="alert alert-info" role="alert">
            <a href="{{ route('HGSユーザーへ') }}" class="alert-link">H.G.S.に登録していた方はこちらをご覧ください</a>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">外部サイトのアカウントで登録</h4>
                <p>
                    外部サイトのアカウントで登録できます。<br>
                    登録後にログインに使う外部サイトを追加することもできます。
                </p>
                <div class="pl-3 d-flex">
                    <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</button>
                    </form>
                    <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }}</button>
                    </form>
                    <form method="POST" action="{{ route('GitHub', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</button>
                    </form>
                    <form method="POST" action="{{ route('Google', ['mode' => \Hgs3\Constants\Social\Mode::CREATE_ACCOUNT]) }}">
                        {{ csrf_field() }}
                        <button class="btn btn-lg btn-light btn--icon mr-2">{{ sns_icon(\Hgs3\Constants\SocialSite::GOOGLE_PLUS) }}</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">メールアドレスで登録</h4>
                <p>
                    メールアドレスで登録できます。<br>
                    ↓に必要事項を入力し、仮登録メール送信ボタンを押してください。<br>
                    本登録のURLを記載したメールを送信します。<br>
                    ※SNSのアカウントで登録した後に、メールアドレスによるログイン設定を行うこともできます。
                </p>

                <form method="POST" action="{{ route('仮登録メール送信') }}" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name" class="hgn-label"><i class="fas fa-edit"></i> メールアドレス</label>
                        <input id="email" type="email" class="form-control{{ invalid($errors, 'email') }}" name="email" value="{{ old('email') }}" required maxlength="50">
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        @include('common.error', ['formName' => 'email'])
                    </div>

                    <div class="form-group">
                        <label for="name" class="hgn-label"><i class="fas fa-edit"></i> 名前</label>
                        <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name') }}">
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        @include('common.error', ['formName' => 'name'])
                        <small class="form-text text-muted">最大文字数：50文字<br>
                            ※表示ページによっては、「14文字＋…」に制限させていただきます。</small>
                    </div>

                    <div class="form-group">
                        <label for="password" class="hgn-label"><i class="fas fa-edit"></i> パスワード</label>
                        <input type="password" class="form-control{{ invalid($errors, 'password') }}" id="password" name="password" required minlength="4" maxlength="16">
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        @include('common.error', ['formName' => 'password'])
                        <small class="form-text text-muted">
                            4～16文字で入力してください。<br>
                            使える文字は、アルファベット大文字( A～Z )、アルファベット小文字( a～z )、数字( 0～9 )、ハイフン( - )、アンダーバー( _ )です。
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="profile" class="hgn-label"><i class="fas fa-check"></i> 性的表現の確認</label>
                        <div class="form-check">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" value="1" name="adult"{{ checked(old('checkbox'), 1) }}>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">18歳以上で、かつ性的な表現があっても問題ありません</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-help">
                        <p class="form-text text-muted">
                            <small>
                                18禁エロゲのパッケージと、商品へのリンクが表示されるようになります。<br>
                                CERO-Zのパッケージには影響しません。<br>
                                ※今後、イラストや小説などのアップロードといった機能が実装されるとなれば、このチェックが影響するかもしれません。
                            </small>
                        </p>
                    </div>


                    <button type="submit" class="btn btn-primary">仮登録メール送信</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ユーザー登録</li>
        </ol>
    </nav>
@endsection
