@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('ユーザー設定') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>SNS認証設定</h1>

    <p class="text-muted">
        <small>
            SNSのアカウントでログインできるように設定します。<br>
            現状はログインのみ利用しています。<br>
            将来的には各SNSの特徴に合わせた機能連携を行えたらいいなと考えています。
        </small>
    </p>

    <p class="text-muted">
        <small>
            アカウントを公開すると、他ユーザーがあなたのプロフィールを見た時にSNSへのリンクが表示されます。
        </small>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title color-twitter">
                        {{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }} Twitter
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::TWITTER])
                            <small class="ml-3"><span class="badge badge-success">連携中</span></small>
                        @endisset
                    </h5>
                    <div class="card-text">
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::TWITTER])
                            @php $sns = $snsAccountHash[\Hgs3\Constants\SocialSite::TWITTER]; @endphp
                        <div>
                            <form>
                                <div class="form-row align-items-center">
                                    <div class="col-auto my-1">
                                        公開
                                    </div>
                                    <div class="col-auto my-1">
                                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-sm btn-outline-dark{{ active($sns->open_flag, 1) }}">
                                                <input type="radio" name="twitter_options" id="twitter_options_user" autocomplete="off" {{ checked($sns->open_flag, 1) }}> する
                                            </label>
                                            <label class="btn btn-sm btn-outline-dark{{ active($sns->open_flag, 0) }}">
                                                <input type="radio" name="twitter_options" id="twitter_options_close" autocomplete="off" {{ checked($sns->open_flag, 0) }}> しない
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="text-right mt-4">
                            <form method="POST" action="{{ route('SNS認証解除', ['socialSiteId' => \Hgs3\Constants\SocialSite::TWITTER]) }}" onsubmit="return confirm('Twitterとの連携を解除します。')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-outline-danger btn-sm">連携解除</button>
                            </form>
                        </div>
                        @else
                            <p>連携していません。</p>
                            <form method="POST" action="{{ route('twitter', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-outline-info btn-sm">連携する</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title color-facebook">
                        {{ sns_icon(\Hgs3\Constants\SocialSite::FACEBOOK) }} facebook
                    </h5>
                    <div class="card-text">
                        @isset($snsAccountHash[\Hgs3\Constants\SocialSite::FACEBOOK])
                            <p>連携中</p>

                            <div>

                            </div>

                            <div class="text-right">
                                <form method="POST" action="{{ route('SNS認証解除', ['socialSiteId' => \Hgs3\Constants\SocialSite::TWITTER]) }}" onsubmit="return confirm('Twitterとの連携を解除します。')">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-outline-danger btn-sm">連携解除</button>
                                </form>
                            </div>
                        @else
                            <p>連携していません。</p>
                            <form method="POST" action="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::ADD_AUTH]) }}">
                                {{ csrf_field() }}
                                <button class="btn btn-outline-info btn-sm">連携する</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">設定</li>
        </ol>
    </nav>
@endsection