@extends('layouts.app')

@section('title')外部サイト連携@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>外部サイト連携</h1>
        </header>
        <p class="text-muted">
            アカウントを公開すると、他ユーザーがあなたのプロフィールを見た時に外部サイトへのリンクが表示されます。
        </p>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title color-twitter">
                        {{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }} Twitter
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::TWITTER])
                            <small class="ml-3"><span class="badge badge-success">連携中</span></small>
                        @endisset
                    </h4>
                    <div class="card-text">
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::TWITTER])
                            @php $sns = $snsAccountHash[\Hgs3\Constants\SocialSite::TWITTER]; @endphp
                        <div>
                            <p>アカウント <a href="{{ $sns->getUrl() }}" target="_blank">{{ $sns->nickname }}</a></p>
                            <form method="POST" action="{{ route('SNS公開設定処理', ['sa' => $sns->id]) }}" class="sns-open-form">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="form-row align-items-center">
                                    <div class="col-auto my-1">公開</div>
                                    <div class="col-auto my-1">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="submit" name="open_flag" value="1" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 1) }}">する</button>
                                            <button type="submit" name="open_flag" value="0" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 0) }}">しない</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="text-right mt-4">
                            <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('Twitterとの連携を解除します。')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-outline-danger btn-sm">連携解除</button>
                            </form>
                        </div>
                        @else
                            <p>
                                連携していません。<br>
                                連携すると、Twitterアカウントでログインできるようになります。
                            </p>
                            <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}" id="twitter_form">
                                {{ csrf_field() }}
                                <a href="#" class="badge badge-pill badge-secondary" onclick="$('#twitter_form').submit();">連携する <i class="fas fa-sign-out-alt"></i></a>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title color-facebook">
                        {{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }} facebook
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::FACEBOOK])
                            <small class="ml-3"><span class="badge badge-success">連携中</span></small>
                        @endisset
                    </h4>
                    <div class="card-text">
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::FACEBOOK])
                            @php $sns = $snsAccountHash[\Hgs3\Constants\SocialSite::FACEBOOK]; @endphp
                            <div>
                                <p>アカウント <a href="{{ $sns->getUrl() }}" target="_blank">{{ $sns->name }}</a></p>
                                <form method="POST" action="{{ route('SNS公開設定処理', ['sa' => $sns->id]) }}" class="sns-open-form">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-row align-items-center">
                                        <div class="col-auto my-1">公開</div>
                                        <div class="col-auto my-1">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="submit" name="open_flag" value="1" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 1) }}">する</button>
                                                <button type="submit" name="open_flag" value="0" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 0) }}">しない</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="text-right mt-4">
                                <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('facebookとの連携を解除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-outline-danger btn-sm">連携解除</button>
                                </form>
                            </div>
                        @else
                            <p>
                                連携していません。<br>
                                連携すると、facebookアカウントでログインできるようになります。
                            </p>
                            <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}" id="facebook_form">
                                {{ csrf_field() }}
                                <a href="#" class="badge badge-pill badge-secondary" onclick="$('#facebook_form').submit();">連携する <i class="fas fa-sign-out-alt"></i></a>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title color-github">
                        {{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }} GitHub
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::GITHUB])
                            <small class="ml-3"><span class="badge badge-success">連携中</span></small>
                        @endisset
                    </h4>
                    <div class="card-text">
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::GITHUB])
                            @php $sns = $snsAccountHash[\Hgs3\Constants\SocialSite::GITHUB]; @endphp
                            <div>
                                <p>アカウント <a href="{{ $sns->getUrl() }}" target="_blank">{{ $sns->name }}</a></p>
                                <form method="POST" action="{{ route('SNS公開設定処理', ['sa' => $sns->id]) }}" class="sns-open-form">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-row align-items-center">
                                        <div class="col-auto my-1">公開</div>
                                        <div class="col-auto my-1">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="submit" name="open_flag" value="1" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 1) }}">する</button>
                                                <button type="submit" name="open_flag" value="0" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 0) }}">しない</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="text-right mt-4">
                                <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('GitHubとの連携を解除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-outline-danger btn-sm">連携解除</button>
                                </form>
                            </div>
                        @else
                            <p>
                                連携していません。<br>
                                連携すると、GitHubアカウントでログインできるようになります。
                            </p>
                            <form method="POST" action="{{ route('GitHub', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}" id="github_form">
                                {{ csrf_field() }}
                                <a href="#" class="badge badge-pill badge-secondary" onclick="$('#github_form').submit();">連携する <i class="fas fa-sign-out-alt"></i></a>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title color-google">
                        {{ sns_icon(\Hgs3\Constants\SocialSite::GOOGLE_PLUS) }} Google+
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::GOOGLE_PLUS])
                            <small class="ml-3"><span class="badge badge-success">連携中</span></small>
                        @endisset
                    </h4>
                    <div class="card-text">
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::GOOGLE_PLUS])
                            @php $sns = $snsAccountHash[\Hgs3\Constants\SocialSite::GOOGLE_PLUS]; @endphp
                            <div>
                                <p>
                                    アカウント <a href="{{ $sns->getUrl() }}" target="_blank">{{ $sns->name }}</a>
                                </p>
                                <form method="POST" action="{{ route('SNS公開設定処理', ['sa' => $sns->id]) }}" class="sns-open-form">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-row align-items-center">
                                        <div class="col-auto my-1">
                                            公開
                                        </div>
                                        <div class="col-auto my-1">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="submit" name="open_flag" value="1" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 1) }}">する</button>
                                                <button type="submit" name="open_flag" value="0" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 0) }}">しない</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="text-right mt-4">
                                <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('Google+との連携を解除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-outline-danger btn-sm">連携解除</button>
                                </form>
                            </div>
                        @else
                            <p>
                                連携していません。<br>
                                連携すると、Google+アカウントでログインできるようになります。
                            </p>
                            <form method="POST" action="{{ route('Google', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}" id="google_plus_form">
                                {{ csrf_field() }}
                                <a href="#" class="badge badge-pill badge-secondary" onclick="$('#google_plus_form').submit();">連携する <i class="fas fa-sign-out-alt"></i></a>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title color-pixiv">
                        pixiv
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::PIXIV])
                            <small class="ml-3"><span class="badge badge-success">登録中</span></small>
                        @endisset
                    </h4>
                    <div class="card-text">
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::PIXIV])
                            @php $sns = $snsAccountHash[\Hgs3\Constants\SocialSite::PIXIV]; @endphp
                            <div>
                                <p>アカウント <a href="{{ $sns->getUrl() }}" target="_blank">{{ $sns->name }}</a></p>
                                <form method="POST" action="{{ route('SNS公開設定処理', ['sa' => $sns->id]) }}" class="sns-open-form">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}
                                    <div class="form-row align-items-center">
                                        <div class="col-auto my-1">公開</div>
                                        <div class="col-auto my-1">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="submit" name="open_flag" value="1" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 1) }}">する</button>
                                                <button type="submit" name="open_flag" value="0" class="btn btn-sm btn-outline-secondary{{ active($sns->open_flag, 0) }}">しない</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <form method="POST" action="{{ route('pixiv保存') }}" autocomplete="off" class="mt-4">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="pixiv_url" class="hgn-label"><i class="fas fa-edit"></i> プロフィールURL</label>

                                    <div class="input-group">
                                        <input type="url" class="form-control{{ invalid($errors, 'pixiv_url') }}" id="pixiv_url" name="pixiv_url" value="{{ old('pixiv_url', $sns->getUrl()) }}">
                                        <i class="form-group__bar"></i>
                                        <button class="input-group-addon btn btn-outline-info btn-sm btn-cooperation">登録</button>
                                    </div>
                                </div>
                                <div class="form-help">
                                    @include('common.error', ['formName' => 'pixiv_url'])
                                </div>
                            </form>

                            <div class="text-right mt-4">
                                <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('保存しているpixiv IDを削除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-outline-danger btn-sm">削除</button>
                                </form>
                            </div>
                        @else
                            <p>
                                pixivのプロフィールURLを登録して公開すると、プロフィールにpixivへのリンクを張ることができます。<br>
                                それ以外にもできることはないか検討中です。<br>
                                <br>
                                <button class="btn btn-light" data-toggle="modal" data-target="#pixiv_help"><i class="far fa-question-circle"></i> プロフィールURLの調べ方</button>
                            </p>
                            <form method="POST" action="{{ route('pixiv保存') }}" autocomplete="off">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="pixiv_url" class="hgn-label"><i class="fas fa-edit"></i> プロフィールURL</label>

                                    <div class="input-group">
                                        <input type="url" class="form-control{{ invalid($errors, 'pixiv_url') }}" id="pixiv_url" name="pixiv_url" value="{{ old('pixiv_url', '') }}">
                                        <i class="form-group__bar"></i>
                                        <button class="input-group-addon btn btn-outline-info btn-sm btn-cooperation">登録</button>
                                    </div>
                                </div>
                                <div class="form-help">
                                    @include('common.error', ['formName' => 'pixiv_url'])
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pixiv_help" tabindex="-1" role="dialog" aria-labelledby="pixiv_help" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header mb-0">
                    <h5 class="modal-title">プロフィールURLの調べ方</h5>
                </div>
                <div class="modal-body py-2">
                    <p>
                        pixivにブラウザでアクセスします。<br>
                        左側メニュー上部にある、ご自身のアイコンと名前の所をクリックしてください。
                    </p>
                    <p class="text-center"><img data-normal="{{ url('img/pixiv1.jpg') }}" style="max-width: 100%"></p>
                    <p>
                        プロフィールページに移動しますので、ここのアドレスをコピーして登録してください。
                    </p>
                    <p class="text-center"><img data-normal="{{ url('img/pixiv2.jpg') }}" style="max-width: 100%;"></p>
                </div>
                <div class="text-center my-5">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        let isSubmitting = false;

        $('.sns-open-form').on('submit', function (e){
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }

            isSubmitting = true;

            return true;
        });
    </script>

@endsection
