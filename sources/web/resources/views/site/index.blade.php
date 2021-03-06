@extends('layouts.app')

@section('title')サイト@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト</h1>
        </header>
    @if (!empty($timelines))
        <div class="ticker-title hidden-sm-up">
            <span>新着情報！</span>
        </div>
        <div class="ticker-container">
            <div class="ticker-title-inline hidden-xs-down"><span>新着情報！</span></div>
            <div class="ticker">
                <ul>
                    @foreach ($timelines as $tl)
                        <li>{!! $tl['text'] !!}</li>
                    @endforeach
                </ul>
            </div>
        </div>

    @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h4 class="card-title">新着サイト</h4>
                        <div class="card-text">
                            @if ($newArrivals->count() == 0)
                                <p>新着サイトはありません。</p>
                            @else
                                <div class="swiper-container" id="new_arrivals_list">
                                    <div class="swiper-wrapper">

                                @foreach ($newArrivals as $s)
                                        <div class="swiper-slide">
                                             @include('site.common.swipe', ['s' => $s, 'u' => $webmasters[$s->user_id] ?? null, 'noUser' => !isset($webmasters[$s->user_id])])
                                        </div>
                                @endforeach

                                    </div>

                                    <!-- Add Pagination -->
                                    <div class="text-center mt-3">
                                        <button class="btn btn-light" id="new_arrivals_prev"><i class="fas fa-caret-left"></i></button>
                                        <span id="new_arrivals_pagination" class="mx-5"></span>
                                        <button class="btn btn-light" id="new_arrivals_next"><i class="fas fa-caret-right"></i></button>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <a href="{{ route('新着サイト一覧') }}" class="and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-hgn">
                    <div class="card-body">
                        <h4 class="card-title">更新サイト</h4>
                        <div class="card-text">
                            @if ($updateArrivals->count() == 0)
                                <p>更新サイトはありません。</p>
                            @else
                                <div class="swiper-container" id="updates_list">
                                    <div class="swiper-wrapper">
                                @foreach ($updateArrivals as $s)
                                        <div class="swiper-slide">
                                            @include('site.common.swipe', ['s' => $s, 'u' => $webmasters[$s->user_id] ?? null, 'noUser' => !isset($webmasters[$s->user_id])])
                                        </div>
                                @endforeach
                                    </div>

                                    <div class="text-center mt-3">
                                        <button class="btn btn-light" id="updates_prev"><i class="fas fa-caret-left"></i></button>
                                        <span id="updates_pagination" class="mx-5"></span>
                                        <button class="btn btn-light" id="updates_next"><i class="fas fa-caret-right"></i></button>
                                    </div>
                                </div>

                                <div class="text-right mt-4">
                                    <a href="{{ route('更新サイト一覧') }}" class="and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-hgn">
            <div class="card-body">
                <h4 class="card-title">サイトを探す</h4>

                <form method="get" action="{{ route('サイト検索') }}">
                    <div class="form-group">
                        <div>
                            <label for="main_contents" class="hgn-label"><i class="fas fa-check"></i> メインコンテンツを絞る</label>
                        </div>
                        <div class="d-flex flex-wrap">
                            @foreach (\Hgs3\Constants\Site\MainContents::getData() as $mcId => $mcName)
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="mc_{{ $mcId }}" name="mc[]" value="{{ $mcId }}" autocomplete="off">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ $mcName }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-help"></div>

                    <div class="form-group">
                        <div>
                            <label for="rate" class="hgn-label"><i class="fas fa-check"></i> 対象年齢を絞る</label>
                        </div>
                        <div class="d-flex">
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="rate_0" name="r[]" value="0" autocomplete="off">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">制限なし</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="rate_15" name="r[]" value="15" autocomplete="off">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">R-15</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="rate_18" name="r[]" value="18" autocomplete="off">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">R-18</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-help"></div>

                    <div class="form-group">
                        <div>
                            <label for="gender" class="hgn-label"><i class="fas fa-check"></i> 性別傾向を絞る</label>
                        </div>
                        <div class="d-flex">
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="gender_{{ \Hgs3\Constants\Site\Gender::NONE }}" name="g[]" value="{{ \Hgs3\Constants\Site\Gender::NONE }}" autocomplete="off">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">傾向なし</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="gender_{{ \Hgs3\Constants\Site\Gender::MALE }}" name="g[]" value="{{ \Hgs3\Constants\Site\Gender::MALE }}" autocomplete="off">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">男性向け</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="gender_{{ \Hgs3\Constants\Site\Gender::FEMALE }}" name="g[]" value="{{ \Hgs3\Constants\Site\Gender::FEMALE }}" autocomplete="off">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">女性向け</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-help"></div>

                    <button class="btn btn-light">この条件で検索</button>
                </form>
                <p class="mt-4">
                    ゲーム単位でサイトをお探しの場合は、<a href="{{ route('ゲーム一覧') }}">ゲーム一覧</a>よりゲームを選択し、サイト情報を参照してください。
                </p>
            </div>
        </div>

    </div>
    <script>
        let swiper = null;
        let swiper2 = null;
        let ticker = null;

        $(function(){
            ticker = new Ticker('.ticker');
            ticker.start();

            swiper = new Swiper('#new_arrivals_list', {
                pagination: {
                    el: '#new_arrivals_pagination',
                    type: 'fraction',
                },
                navigation: {
                    nextEl: '#new_arrivals_next',
                    prevEl: '#new_arrivals_prev',
                },
            });
            swiper2 = new Swiper('#updates_list', {
                pagination: {
                    el: '#updates_pagination',
                    type: 'fraction',
                },
                navigation: {
                    nextEl: '#updates_next',
                    prevEl: '#updates_prev',
                },
            });

            setSiteSwipeHeight();
            $(window).resize(function() {
                setSiteSwipeHeight();
            });
        });


        function setSiteSwipeHeight()
        {
            let maxHeight = 0;
            $('#new_arrivals_list .site-swipe').css('height', 'auto');

            $('#new_arrivals_list .site-swipe').each(function (){
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            });

            $('#new_arrivals_list .site-swipe').height(maxHeight + 'px');

            maxHeight = 0;
            $('#updates_list .site-swipe').css('height', 'auto');

            $('#updates_list .site-swipe').each(function (){
                if ($(this).height() > maxHeight) {
                    maxHeight = $(this).height();
                }
            });

            $('#updates_list .site-swipe').height(maxHeight + 'px');
        }
    </script>

@endsection
