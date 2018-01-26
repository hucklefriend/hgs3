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
        <div class="detail_site_banner_outline">
            <img src="{{ $site->detail_banner_url }}" class="img-responsive">
        </div>
    @endif
    <div style="padding: 0 15px;min-width: 300px;">
        <h4>

        </h4>
        <table class="table table-responsive" style="width: 100%">
            <tbody>
            <tr>
                <th>URL</th>
                <td>
                    <a href="{{ route('サイト遷移', ['site' => $site->id]) }}">{{ $site->url }}</a>
                    <small>[<a href="{{ route('サイト遷移', ['site' => $site->id]) }}" target="_blank">別窓</a>]</small>
                </td>
            </tr>
            <tr>
                <th>管理人</th>
                <td><a href="{{ route('プロフィール', ['showId' => $webMaster->show_id]) }}">{{ $webMaster->name }}さん</a></td>
            </tr>
            <tr>
                <th>お気に入り人数</th>
                <td>
                    <div class="d-flex">
                        <div class="mr-auto">{{ '0' }}人</div>
                        <div class="text-right">
                            @if ($isWebMaster)
                                <small><a href="{{ url2('site/favorite/' . $site->id) }}">登録者一覧</a></small>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>いいね数</th>
                <td>
                    <div class="d-flex">
                        <div class="mr-auto">{{ number_format($site->good_num) }}</div>
                        <div class="text-right">
                            @if ($isWebMaster)
                                <small><a href="{{ url2('site/good_history/' . $site->id) }}">履歴</a></small>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>アクセス数</th>
                <td>
                    <div class="d-flex">
                        <div class="mr-auto">{{ number_format($site->out_count) }}</div>
                        <div class="text-right">
                            @if ($isWebMaster)
                                <small><a href="{{ url2('site/footprint/' . $site->id) }}">足跡</a></small>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">紹介</h5>
        <p class="card-text">{!! nl2br(e($site->presentation)) !!}</p>
    </div>
</div>
<br>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">このサイトで扱っているゲーム</h5>
    </div>
    <div class="d-flex flex-wrap">
        @foreach ($handleSofts as $soft)
            <div>
                <div class="card card_soft text-center">
                    <div class="card-body">
                        <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}">
                            @include('game.common.package_image_small', ['imageUrl' => $soft->small_image_url])
                        </a>
                        <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}"><small>{{ $soft->name }}</small></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>