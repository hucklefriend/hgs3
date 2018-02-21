@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="@if(!Auth::check()) col-md-7 @else col-md-12 @endif">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">ようこそ</h5>
                    <p class="card-text">
                        H.G.N.-Horror Game Network-は、ホラーゲーム好きが集まるサイトになるべく開発中のサイトです。<br>
                        <a href="http://horrorgame.net/">H.G.S.-Horror Game Search-</a>の後継として開発を進めています。<br>
                        公開テスト段階ですのでいろいろと不具合などありますが、よろしければテストにご協力ください。
                    </p>
                    @if (!Auth::check())
                    <div class="text-center">
                        <a href="{{ route('ユーザー登録') }}" class="btn btn-primary btn-lg" role="button" aria-pressed="true">新規登録</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if (!Auth::check())
        <div class="col-md-5">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">ログイン</h5>
                    <div class="top-login d-flex">
                        <form method="POST" action="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}">
                            {{ csrf_field() }}
                            <button class="btn btn-lg btn-outline-light p-1">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</button>
                        </form>
                    </div>
                    <hr>
                    <form method="POST" action="{{ route('ログイン') }}">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm mb-2">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-mail"><i class="far fa-envelope"></i></span>
                                </div>
                                <input id="email" type="email" class="form-control form-control-sm" name="email" value="{{ old('email') }}" required placeholder="メールアドレス" aria-label="メールアドレス" aria-describedby="addon-mail">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="addon-password"><i class="fas fa-key"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control form-control-sm" name="password" required placeholder="パスワード" aria-label="パスワード" aria-describedby="addon-password">
                            </div>
                        </div>
                        <div style="display:flex;">
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm">ログイン</button>
                            </div>
                            <div style="margin-left: auto;">
                                <a href="{{ route('パスワード再設定') }}">パスワードを忘れた</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">新着情報</h5>
            @foreach ($newInfo as $nf)
                <p class="card-text">
                {{ $nf->open_at }}<br>
                @if ($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_GAME)
                    <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>が追加されました。
                @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_SITE)
                    新着サイトです！<a href="{{ route('サイト詳細', ['site' => $nf->site_id]) }}">「{{ hv($siteHash, $nf->site_id) }}」</a>
                @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_REVIEW)
                    <a href="{{ route('ゲーム詳細', ['soft' => $nf->soft_id]) }}">「{{ hv($gameHash, $nf->soft_id) }}」</a>の新しいレビューが投稿されました！
                @endif
                </p>
            @endforeach
            @if ($newInfo->count() > 0)
                <div class="text-center">
                    <a href="{{ route('新着情報') }}" >すべて見る</a>
                </div>
            @else
                <p class="card-text">新着情報はありません。</p>
            @endif
        </div>
    </div>

    <div class="card card-hgn">
        <div class="card-body">
            <h5 class="card-title">お知らせ</h5>
            @foreach ($notices as $notice)
                <p class="card-text">
                    <span style="margin-right: 10px;">{{ $notice->open_at_str }}</span>
                    <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}">{{ $notice->title }}</a>
                </p>
            @endforeach

            @if ($notices->count() > 0)
                <div class="text-center">
                    <a href="{{ route('お知らせ') }}" >すべて見る</a>
                </div>
            @else
                <p class="card-text">お知らせはありません。</p>
            @endif
        </div>
    </div>

@endsection