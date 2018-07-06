@extends('layouts.app')

@section('title')ゲーム一覧@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    @php
        $phonetics = [
            ['a', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('あ'), 'あ'],
            ['ka', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('か'), 'か'],
            ['sa', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('さ'), 'さ'],
            ['ta', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('た'), 'た'],
            ['na', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('な'), 'な'],
            ['ha', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('は'), 'は'],
            ['ma', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ま'), 'ま'],
            ['ya', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('や'), 'や'],
            ['ra', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ら'), 'ら'],
            ['wa', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('わ'), 'わ'],
        ];

        if (!empty($favoriteHash)) {
            $phonetics[] = ['fav', 100, 'fav'];
        }
    @endphp
    <div class="content__inner">
        <header class="content__title">
            <h1>ゲーム一覧</h1>
        </header>

        <div class="d-flex flex-wrap" id="game_tab">
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[0][1]) active @endif " href="#" data-target="agyo" id="tab_agyo">あ</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[1][1]) active @endif " href="#" data-target="kagyo" id="tab_kagyo">か</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[2][1]) active @endif " href="#" data-target="sagyo" id="tab_sagyo">さ</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[3][1]) active @endif " href="#" data-target="tagyo" id="tab_tagyo">た</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[4][1]) active @endif " href="#" data-target="nagyo" id="tab_nagyo">な</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[5][1]) active @endif " href="#" data-target="hagyo" id="tab_hagyo">は</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[6][1]) active @endif " href="#" data-target="magyo" id="tab_magyo">ま</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[7][1]) active @endif " href="#" data-target="yagyo" id="tab_yagyo">や</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[8][1]) active @endif " href="#" data-target="ragyo" id="tab_ragyo">ら</a>
            <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[9][1]) active @endif " href="#" data-target="wagyo" id="tab_wagyo">わ</a>
            @if (!empty($favoriteHash))
                <a class="btn btn-light game_tab @if($defaultPhoneticType == 100) active @endif " href="#" data-target="favgyo" id="tab_favgyo"><span class="favorite-icon"><i class="fas fa-star"></i></span></a>
            @endif
        </div>

        <div>
        @foreach ($phonetics as $no => $p)
            <section id="{{ $p[0] }}gyo" @if ($defaultPhoneticType != $p[1]) style="display:none;" @endif>
                <div class="card">
                    <div class="card-body">
                        <div class="row game-list">
                        @if (isset($list[$p[1]]))
                            @foreach ($list[$p[1]] as $soft)
                                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                                    <div class="package-card">
                                        <div>
                                            <div><img data-url="{{ small_image_url($soft, true) }}" class="lazy-img-load"></div>
                                            <div>
                                                {{ $soft->name }}
                                                @isset($favoriteSofts[$soft->id])
                                                    <small><span class="favorite-icon"><i class="fas fa-star"></i></span></small>
                                                @endisset
                                            </div>
                                            <div>
                                                <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div>
                        @if ($no > 0)
                            <a href="javascript:void(0);" onclick="changeTab('{{ $phonetics[$no - 1][0] }}')" class="and-more">
                                <i class="fas fa-angle-left"></i>&nbsp;{{ $phonetics[$no - 1][2] }}行
                            </a>
                        @endif
                    </div>
                    <div>
                        @if (!$loop->last)
                            @if ($phonetics[$no + 1][1] == 100)
                                <a href="javascript:void(0);" onclick="changeTab('{{ $phonetics[$no + 1][0] }}')" class="and-more">
                                    <span class="favorite-icon"><i class="fas fa-star"></i></span>&nbsp;<i class="fas fa-angle-right"></i>
                                </a>
                            @else
                        <a href="javascript:void(0);" onclick="changeTab('{{ $phonetics[$no + 1][0] }}')" class="and-more">
                            {{ $phonetics[$no + 1][2] }}行&nbsp;<i class="fas fa-angle-right"></i>
                        </a>
                            @endif
                        @endif
                    </div>
                </div>
            </section>
        @endforeach
        </div>
    </div>
    <script>
        let loaded = {};

        $(function (){
            $('.game_tab').click(function (){
                $('#' + $('#game_tab .active').data('target')).hide();
                $('#game_tab .active').removeClass('active');

                $('#' + $(this).data('target')).show();
                $(this).addClass('active');

                showPackageImage();
            });

            showPackageImage();
        });

        function changeTab(phoneticType)
        {
            $("html,body").animate({scrollTop:0});
            $('#tab_' + phoneticType + 'gyo').click();
        }

        function showPackageImage()
        {
            let target = $('#game_tab .active').data('target');

            if (loaded[target] == undefined) {
                $('#' + target + ' img.lazy-img-load').each(function (){
                    let e = $(this);
                    e.attr('src', e.data('url'));
                });

                loaded[target] = true;
            }
        }

    </script>
@endsection
