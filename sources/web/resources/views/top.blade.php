@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="@if(!Auth::check()) col-md-7 @else col-md-12 @endif">
            <div class="card card-hgn">
                <div class="card-header">ようこそ</div>
                <div class="card-body">
                    <p class="card-text">
                        H.G.N.-Horror Game Network-は、ホラーゲーム好きが集まるSNSとして現在開発中のものです。<br>
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
                <div class="card-header">ログイン</div>
                <div class="card-body">
                    <a href="{{ route('Twitter', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}" style="color: #55acee;margin-right: 5px;text-decoration: none;">
                        <i class="fa fa-twitter" aria-hidden="true" style="font-size: 150%;"></i>
                    </a>
                    <a href="{{ route('facebook', ['mode' => \Hgs3\Constants\Social\Mode::LOGIN]) }}" style="color: #315096;text-decoration: none;">
                        <i class="fa fa-facebook-official" aria-hidden="true" style="font-size: 150%;"></i>
                    </a>
                    <hr>
                    <form method="POST" action="{{ route('ログイン') }}">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm">
                            <input id="email" type="email" class="form-control form-control-sm" name="email" value="{{ old('email') }}" required placeholder="メールアドレス">
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <input id="password" type="password" class="form-control form-control-sm" name="password" required placeholder="パスワード">
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
        <div class="card-header">新着情報</div>
        <div class="card-body">
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
                    <a href="{{ route('新着情報') }}" >新着情報を全て見る</a>
                </div>
            @else
                <p class="card-text">新着情報はありません。</p>
            @endif
        </div>
    </div>

    <div class="card card-hgn">
        <div class="card-header">お知らせ</div>
        <div class="card-body">
            @foreach ($notices as $notice)
                <p class="card-text">
                    <span style="margin-right: 10px;">{{ $notice->open_at_str }}</span>
                    <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}">{{ $notice->title }}</a>
                </p>
            @endforeach

            @if ($notices->count() > 0)
                <div class="text-center">
                    <a href="{{ route('お知らせ') }}" >お知らせを全て見る</a>
                </div>
            @else
                <p class="card-text">お知らせはありません。</p>
            @endif
        </div>
    </div>

@endsection