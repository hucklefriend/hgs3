@extends('layouts.app')

@section('title')サイト@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト</h1>
        </header>


        @if (!empty($timelines))
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">最新情報！</h6>
                </div>
                <div id="newsticker3" class="ticker3 mb-3">
                    <ul>
                        @foreach ($timelines as $tl)
                            <li class="mt-1 mb-1">
                                {{ format_date($tl['time']) }}<br>
                                {!! $tl['text'] !!}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">新着</h4>
                    <div class="card-text">
                        @if (empty($newArrivals))
                            <p>新着サイトはありません。</p>
                        @else
                            @foreach ($newArrivals as $s)
                                <div class="mb-5">
                                    @include('site.common.normal', ['s' => $s, 'u' => $webmasters[$s->user_id] ?? null, 'hidePresentation' => true, 'noUser' => !isset($webmasters[$s->user_id])])
                                </div>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('新着サイト一覧') }}">すべて見る</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h4 class="card-title">更新</h4>
                    <div class="card-text">
                        @if (empty($updateArrivals))
                            <p>更新サイトはありません。</p>
                        @else
                            @foreach ($updateArrivals as $s)
                                <div class="mb-5">
                                    @include('site.common.normal', ['s' => $s, 'u' => $webmasters[$s->user_id], 'hidePresentation' => true])
                                </div>
                            @endforeach
                            <div class="text-center">
                                <a href="{{ route('更新サイト一覧') }}">すべて見る</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .ticker {
            margin: 0 auto;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .ticker ul {
            width: 100%;
            position: relative;
        }

        .ticker ul li {
            width: 100%;
            display: none;
        }
    </style>


    <!-- http://on-ze.com/demo/jquery-simple-news-ticker/ から拝借して、ちょっと改造 -->
    <script>
        $(function(){
            var effectSpeed = 1000;
            var switchDelay = 5000;

            var $targetObj = $('.ticker');
            var $targetUl = $targetObj.children('ul');
            var $targetLi = $targetObj.find('li');
            var $setList = $targetObj.find('li:first');

            var listHeight = $targetLi.height();
            $targetObj.css({height:(listHeight)});
            $targetLi.css({top:'0',left:'0',position:'absolute'});

            $setList.css({top:'3em',display:'block',opacity:'0',zIndex:'98'}).stop().animate({top:'0',opacity:'1'},effectSpeed,'swing').addClass('showlist');
            setInterval(function(){
                var $activeShow = $targetObj.find('.showlist');
                $activeShow.animate({top:'-3em',opacity:'0'},effectSpeed,'swing').next().css({top:'3em',display:'block',opacity:'0',zIndex:'99'}).animate({top:'0',opacity:'1'},effectSpeed,'swing').addClass('showlist').end().appendTo($targetUl).css({zIndex:'98'}).removeClass('showlist');
            },switchDelay);
        });
    </script>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト</li>
        </ol>
    </nav>
@endsection