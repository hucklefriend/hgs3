<div class="row">
    <div class="col-md-6">
        <div class="card card-hgn">
            @php $detailBannerUrl = detail_banner($site) @endphp
            @if (!empty($detailBannerUrl))
            <img class="card-img-top" src="{{ $detailBannerUrl }}">
            @endif
            <div class="card-body">
                <h4 class="card-title">{{ $site->name }}</h4>
                <div class="mb-3">
                    <span class="tag simple">{{ \Hgs3\Constants\Site\MainContents::getText($site->main_contents_id) }}</span>
                    @if ($site->rate > 0)
                        <span class="tag simple">{{ \Hgs3\Constants\Site\Rate::getText($site->rate) }}</span>
                    @endif
                    @if ($site->gender != \Hgs3\Constants\Site\Gender::NONE)
                        <span class="tag simple">{{ \Hgs3\Constants\Site\Gender::getText($site->gender) }}</span>
                    @endif
                </div>
                <p class="card-text">
                    <a href="{{ route('サイト遷移', ['site' => $site->id]) }}" target="_blank">{{ $site->url }}</a>
                </p>
                <div class="d-flex align-content-start flex-wrap site-info">
                    <span>
                        <i class="far fa-user"></i>
                        <a href="{{ route('プロフィール', ['showId' => $webMaster->show_id]) }}">{{ $webMaster->name }}</a>
                    </span>
                    <span>
                        <span class="favorite-icon"><i class="fas fa-star"></i></span>
                        {{ number_format($favoriteNum) }}
                    </span>
                    <span>
                        <span class="good-icon"><i class="fas fa-thumbs-up"></i></span>
                        {{ number_format($site->good_num) }}
                    </span>
                    <span>
                        <i class="fas fa-paw"></i>
                        {{ number_format($site->out_count) }}
                    </span>
                    @if ($site->updated_timestamp > 0)
                    <span>
                        <i class="fas fa-redo-alt"></i>
                        {{ format_date($site->updated_timestamp) }}
                    </span>
                    @endif
                </div>


                @if ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::OK)
                    @if (!$isWebMaster && Auth::check())
                        <div class="d-flex justify-content-between mt-4">
                            <div class="d-flex">
                            @if ($isFavorite)
                                <form action="{{ route('お気に入りサイト削除処理', ['site' => $site->id]) }}" method="POST" class="mr-4">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-favorite2 btn--icon"><i class="fas fa-star"></i></button>
                                </form>
                            @else
                                <form action="{{ route('お気に入りサイト登録処理', ['site' => $site->id]) }}" method="POST" class="mr-4">
                                    {{ csrf_field() }}
                                    <button class="btn btn-favorite btn--icon"><i class="far fa-star"></i></button>
                                </form>
                            @endif

                            @if ($isGood)
                                <form method="POST" action="{{ route('サイトいいねキャンセル', ['site' => $site]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-good2 btn--icon"><i class="fas fa-thumbs-up"></i></button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('サイトいいね', ['site' => $site]) }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-good btn--icon"><i class="far fa-thumbs-up"></i></button>
                                </form>
                            @endif
                            </div>

                            <div>
                                <button class="btn btn-light btn--icon" data-toggle="modal" data-target="#help"><i class="fas fa-question"></i></button>
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">紹介</h4>
                <p class="card-text">{!! nl2br(e($site->presentation)) !!}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">更新履歴</h4>

                @if ($updateHistories->count() > 0)
                    @foreach ($updateHistories as $uh)
                        <p class="card-text">
                            {{ $uh->site_updated_at }}<br>
                            {!! nl2br(e($uh->detail)) !!}
                        </p>
                    @endforeach
                    <div class="text-right">
                        <a href="{{ route('サイト更新履歴', ['site' => $site->id]) }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                    </div>
                @else
                    <p class="card-text">更新履歴はありません。</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="card card-hgn">
    <div class="card-body">
        <h5 class="card-title">このサイトで扱っているゲーム</h5>
        <div class="row">
            @foreach ($handleSofts as $soft)
                @include('game.common.packageCard', ['soft' => $soft, 'favorites' => $favoriteHash ?? []])
            @endforeach
        </div>
    </div>
</div>

<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="help" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="help"><span style="color:yellow;"><i class="fas fa-star"></i></span> お気に入り</h5>
            </div>
            <div class="modal-body">
                <p>
                    サイトが気に入って、今後も更新があったらすぐ見に行きたい場合はお気に入りに登録しましょう。
                </p>
                <ul>
                    <li>サイトの更新があった時、あなたのタイムラインに通知します</li>
                    <li>サイトのお気に入り登録者一覧にあなたの名前が載ります</li>
                </ul>
            </div>
            <div class="modal-header">
                <h5 class="modal-title" id="help"><i class="fas fa-thumbs-up"></i> いいね</h5>
            </div>
            <div class="modal-body">
                <p>
                    サイトを見て、いいなと思ったら軽い気持ちでいいねを押してあげてください。<br>
                    いいねは完全に匿名です。<br>
                    サイトの登録ユーザーさんは、だれがいいねをしたのか知ることはありません。
                </p>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
