<div class="d-flex flex-row">
    <div><h1>{{ $site->name }}</h1></div>
    <div style="margin-left: 1rem;">
        <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\MainContents::getText($site->main_contents_id) }}</span>
        @if ($site->rate > 0)
            <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Rate::getText($site->rate) }}</span>
        @endif
        @if ($site->gender != \Hgs3\Constants\Site\Gender::NONE)
            <span class="badge badge-pill badge-success">{{ \Hgs3\Constants\Site\Gender::getText($site->gender) }}</span>
        @endif
    </div>
</div>

<div class="d-flex flex-wrap">
    @if (!empty($site->detail_banner_url))
        <div class="detail-site-banner-outline">
            <img src="{{ $site->detail_banner_url }}" class="img-responsive">
        </div>
    @endif
    <div style="min-width: 300px;">
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">データ</h5>
                <p class="card-text">
                    <a href="{{ route('サイト遷移', ['site' => $site->id]) }}">{{ $site->url }}</a>
                </p>
                <div class="d-flex align-content-start flex-wrap site-info">
                    <span>
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                        <a href="{{ route('プロフィール', ['showId' => $webMaster->show_id]) }}">{{ $webMaster->name }}</a>
                    </span>
                    <span>
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                        {{ date('Y-m-d H:i', $site->updated_timestamp) }}
                    </span>
                    <span>
                        <i class="fa fa-star-o" aria-hidden="true"></i>
                        {{ number_format($favoriteNum) }}
                    </span>
                    <span>
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                        {{ number_format($site->good_num) }}
                    </span>
                    <span>
                        <i class="fa fa-paw" aria-hidden="true"></i>
                        {{ number_format($site->out_count) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="card card-hgn">
            <div class="card-body">
                <h5 class="card-title">紹介</h5>
                <p class="card-text">{!! nl2br(e($site->presentation)) !!}</p>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card card-hgn">
            <div class="card-body">
                @if ($isWebMaster)
                    <div style="display:flex;">
                        <div>
                            <h5 class="card-title">更新履歴</h5>
                        </div>
                        <div style="margin-left: auto;">
                            <a href="{{ route('サイト更新履歴登録', ['site' => $site->id]) }}" class="btn btn-sm btn-outline-info">登録</a>
                        </div>
                    </div>
                @else
                <h5 class="card-title">更新履歴</h5>
                @endif

                @if ($updateHistories->count() > 0)
                    @foreach ($updateHistories as $uh)
                        <p class="card-text">
                            {{ $uh->site_updated_at }}<br>
                            {!! nl2br(e($uh->detail)) !!}
                        </p>
                    @endforeach
                    <div class="text-center">
                        <a>全て見る</a>
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
    </div>
    <div class="d-flex flex-wrap">
        @foreach ($handleSofts as $soft)
            <div>
                <div class="card card-soft text-center">
                    <div class="card-body">
                        <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}">
                            @include('game.common.packageImageSmall', ['imageUrl' => $soft->small_image_url])
                        </a>
                        <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}"><small>{{ $soft->name }}</small></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>