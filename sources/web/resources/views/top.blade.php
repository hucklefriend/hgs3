@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-7">
            <div class="card card-hgn">
                <div class="card-header">ようこそ</div>
                <div class="card-body">
                    <p class="card-text">
                        H.G.N.-Horror Game Network-は、ホラーゲーム好きが集まるSNSとして現在開発中のものです。<br>
                        <a href="http://horrorgame.net/">H.G.S.-Horror Game Search-</a>の後継として開発を進めています。<br>
                        公開テスト段階ですのでいろいろと不具合などありますが、よろしければテストにご協力ください。
                    </p>
                    <div class="text-center" style="font-size: 150%;">
                        <a href="{{ url2('account/signup') }}">新規登録</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card card-hgn">
                <div class="card-header">ログイン</div>
                <div class="card-body">
                    <a href="{{ url2('social/twitter') }}/{{ \Hgs3\Constants\Social\Mode::LOGIN }}" style="color: #55acee;margin-right: 5px;text-decoration: none;">
                        <i class="fa fa-twitter" aria-hidden="true" style="font-size: 150%;"></i>
                    </a>
                    <a href="{{ url2('social/facebook') }}/{{ \Hgs3\Constants\Social\Mode::LOGIN }}" style="color: #315096;text-decoration: none;">
                        <i class="fa fa-facebook-official" aria-hidden="true" style="font-size: 150%;"></i>
                    </a>
                    <hr>
                    <form method="POST" action="{{ url2('auth/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm">
                            <input id="email" type="email" class="form-control form-control-sm" name="email" value="{{ old('email') }}" required placeholder="メールアドレス">
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <input id="password" type="password" class="form-control form-control-sm" name="password" required placeholder="パスワード">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">ログイン</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-hgn">
        <div class="card-header">新着情報</div>
        <div class="card-body">
            <p class="card-text">
                {{ $newInfo->render() }}

                @foreach ($newInfo as $nf)

                    @if ($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_GAME)
                    <p><a href="{{ url2('game/soft/' . $nf->soft_id) }}">「{{ get_hash($newInfoData['game_hash'], $nf->soft_id) }}」</a>が追加されました。</p>
                    @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_SITE)
                    <p>新着サイトです！<a href="{{ url2('site/' . $nf->site_id) }}">「{{ get_hash($newInfoData['site_hash'], $nf->site_id) }}」</a></p>
                    @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_REVIEW)
                    <p><a href="{{ url2('game/soft/' . $nf->soft_id) }}">「{{ get_hash($newInfoData['game_hash'], $nf->soft_id) }}」</a>の新しいレビューが投稿されました！</p>
                    @elseif($nf->text_type == \Hgs3\Constants\NewInformationText::NEW_DIARY)
                    <p></p>
                    @endif

                    <div>{{ $nf->date_time }}</div>
                @endforeach
            </p>
        </div>
    </div>

    <div class="card card-hgn">
        <div class="card-header">お知らせ</div>
        <div class="card-body">
            @foreach ($notices as $notice)
                <span style="margin-right: 10px;">{{ $notice->open_at_str }}</span>
                <a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}">{{ $notice->title }}</a>

                @if (!$loop->last)
                    <hr>
                @endif
            @endforeach
        </div>
    </div>

@endsection