@extends('layouts.app')

@section('title')外部サイト連携@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>外部サイト連携</h1>
        </header>
        <p class="text-muted">
            外部サイトのアカウントでログインできるように設定します。<br>
            現状はログインのみ利用しています。<br>
            将来的には各外部サイトの特徴に合わせた機能連携を行えたらいいなと考えています。
        </p>
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
                            <p>
                                アカウント <a href="{{ $sns->getUrl() }}" target="_blank">{{ $sns->nickname }}</a>
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
                            <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('Twitterとの連携を解除します。')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-outline-danger btn-sm">連携解除</button>
                            </form>
                        </div>
                        @else
                            <p>連携していません。</p>
                            <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-outline-info btn-sm btn-cooperation">連携する</button>
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
                                <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('facebookとの連携を解除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-outline-danger btn-sm">連携解除</button>
                                </form>
                            </div>
                        @else
                            <p>連携していません。</p>
                            <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-outline-info btn-sm btn-cooperation">連携する</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
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
                                <form method="POST" action="{{ route('SNS認証解除', ['sa' => $sns->id]) }}" onsubmit="return confirm('GitHubとの連携を解除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-outline-danger btn-sm">連携解除</button>
                                </form>
                            </div>
                        @else
                            <p>連携していません。</p>
                            <form method="POST" action="{{ route('GitHub', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-outline-info btn-sm btn-cooperation">連携する</button>
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
                            <p>連携していません。</p>
                            <form method="POST" action="{{ route('Google', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-outline-info btn-sm btn-cooperation">連携する</button>
                            </form>
                        @endif
                    </div>
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
