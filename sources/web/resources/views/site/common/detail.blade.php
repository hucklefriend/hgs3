<div class="row">
    <div class="col-md-6">
        <div class="card card-hgn">
            @if (!empty($site->detail_banner_url))
            <img class="card-img-top" src="{{ $site->detail_banner_url }}">
            @endif
            <div class="card-body">
                <h4 class="card-title">{{ $site->name }}</h4>
                <div>
                    <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\MainContents::getText($site->main_contents_id) }}</span>
                    @if ($site->rate > 0)
                        <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Rate::getText($site->rate) }}</span>
                    @endif
                    @if ($site->gender != \Hgs3\Constants\Site\Gender::NONE)
                        <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Gender::getText($site->gender) }}</span>
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
                        <div class="d-flex mt-4">

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
                    <div class="text-center">
                        <a href="{{ route('サイト更新履歴', ['site' => $site->id]) }}">すべて見る</a>
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