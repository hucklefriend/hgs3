@extends('layouts.app')

@section('content')
    <h4>{{ $soft->name }}のレビューを書く</h4>
    <div>
        <a href="{{ url2('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}の詳細</a> |
        <a href="{{ url2('review/soft') }}/{{ $soft->id }}">{{ $soft->name }}のレビュー一覧</a>
    </div>

    <hr>

    <div class="alert alert-secondary" role="alert">
        レビューを書くパッケージを選んでください。
    </div>

    @foreach ($packages as $pkg)
        <div class="d-flex align-items-stretch">
            <div class="align-self-top p-2">
                @include ('game.common.packageImage', ['imageUrl' => $pkg->small_image_url])
            </div>
            <div class="align-self-top">
                <div><strong>{{ $pkg->name }}</strong></div>
                <div>
                    <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;<a href="{{ url2('game/company/' . $pkg->company_id) }}">{{ $pkg->company_name }}</a>
                    <i class="fa fa-gamepad" aria-hidden="true"></i>&nbsp;{{ $pkg->platform_name }}<br>
                    <i class="fa fa-calendar" aria-hidden="true"></i> {{ $pkg->release_at }}
                </div>
                <div>
                    @isset($shops[$pkg->id])
                        @foreach ($shops[$pkg->id] as $shop)
                            <div>
                                @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
        <div style="margin: 10px 8px;" class="d-flex">
            @if ($pkg->release_int > $dateInt)
                <div class="alert alert-dark" role="alert">発売後に投稿できます。</div>
            @else
            <div style="padding: 5px 0;">
                    @if (isset($written[$pkg->id]))
                <p>このパッケージのレビューは投稿済みです。</p>
                <a href="{{ url2('review/detail/' . $written[$pkg->id]) }}">このパッケージのレビューを確認</a>
                    @else
                        @if (isset($drafts[$pkg->id]))
                <span class="badge badge-info">下書き保存中</span><br>
                        @endif
                <i class="fa fa-pencil" aria-hidden="true"></i>
                <a href="{{ url2('review/write/' . $soft->id . '/' . $pkg->id) }}">このパッケージのレビューを書く</a>
                    @endif
            </div>

            @if (isset($drafts[$pkg->id]))
                <div class="align-self-end" style="margin-left: 10px;">
                    <form method="POST" action="{{ url2('review/draft/' . $pkg->id) }}" onsubmit="return confirm('下書きを削除してよろしいですか？');">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-warning btn-sm">下書きを削除</button>
                    </form>
                </div>
            @endif
            @endif
        </div>

        @if (!$loop->last) <hr> @endif
    @endforeach

    <br><br>

@endsection
