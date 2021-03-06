@extends('layouts.app')

@section('title')ゲーム一覧@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('head_append')
    <link rel="stylesheet" href="{{ url('vendors/bower_components/nouislider/distribute/nouislider.min.css') }}">
    <script src="{{ url('vendors/bower_components/nouislider/distribute/nouislider.min.js') }}"></script>
    <script src="{{ url('js/wNumb.js') }}"></script>
@endsection

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

        <div class="card card-hgn mb-5">
            <div class="card-body">
                <h4 class="card-title mb-0">絞り込み<button id="search_form_open" class="ml-3 btn btn-sm btn-secondary">open ▼</button></h4>
                <div id="search" style="display:none;">
                    <form method="GET" action="#" class="mt-4" autocomplete="off" onsubmit="return false;">
                        <div class="form-group">
                            <label for="name" class="hgn-label"><i class="fas fa-edit"></i> ゲームタイトル</label>
                            <input type="text" class="form-control" id="name" name="name" value="">
                            <i class="form-group__bar"></i>
                        </div>
                        <div class="form-help">
                            <p class="form-text text-muted">
                                <small>ひらがなでの検索もできます</small>
                            </p>
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="platform" class="hgn-label"><i class="fas fa-edit"></i> プラットフォーム</label>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" value="1">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">家庭用据え置き機</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" value="2">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">家庭用携帯機</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" value="3">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">PC</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" value="4">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">スマホ・タブレット・携帯電話</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" value="5">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">その他(DVD-PG等)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-help">
                            <p class="text-muted">
                                <small>
                                    Nintendo Switchは家庭用据え置き機です。
                                </small>
                            </p>
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="platform" class="hgn-label"><i class="fas fa-edit"></i> 年齢制限</label>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="rate" name="rate[]" value="0">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">なし</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="rate" name="rate[]" value="2">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">18禁(コンシューマ)</span>
                                    </label>
                                </div>
                                @if (\Illuminate\Support\Facades\Auth::check())
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="rate" name="rate[]" value="1">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">18禁(エロゲ)</span>
                                    </label>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-help">
                            <p class="text-muted">
                                <small>
                                    18禁(コンシューマ) … CERO-Zなど、家庭用ゲームで18禁となっているゲーム
                                    @if (\Illuminate\Support\Facades\Auth::check())
                                    <br>18禁(エロゲ) … 性的表現があるエロゲ
                                    @endif
                                </small>
                            </p>
                            <p class="text-muted">
                                <small>
                                    制限のあるパッケージとないパッケージが両方発売されている場合は、 いずれにチェックを入れても検索結果に出てきます。
                                </small>
                            </p>
                        </div>



                        <div class="form-group" style="max-width: 400px;">
                            <div>
                                <label for="platform" class="hgn-label"><i class="fas fa-edit"></i> 発売年</label>
                            </div>
                            <div>
                                <div id="year-slider"></div>

                                <div class="d-flex">
                                    <div class="form-group" style="width: 80px;">
                                        <input type="text" class="form-control" id="year-slider-start" maxlength="4">
                                        <i class="form-group__bar"></i>
                                    </div>
                                    <div class="align-self-center mr-1">年 ～ </div>
                                    <div class="form-group" style="width: 80px;">
                                        <input type="text" class="form-control" id="year-slider-end" maxlength="4">
                                        <i class="form-group__bar"></i>
                                    </div>
                                    <div class="align-self-center">年</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-help">
                            <p class="text-muted">
                                <small>
                                    パッケージ単位での発売年です。<br>
                                    2000年に初版、2001年に廉価版が発売されていた場合、2000と2001の両方で表示されます。
                                </small>
                            </p>
                        </div>

                        <script>
                            let sliderRange = document.getElementById ('year-slider');
                            let sliderRangeUpper = document.getElementById('year-slider-start');
                            let sliderRangeLower = document.getElementById('year-slider-end');
                            let sliderRangeInputs = [sliderRangeUpper, sliderRangeLower];

                            noUiSlider.create(sliderRange, {
                                start: [1980, {{ date('Y') }}],
                                connect: true,
                                range: {
                                    'min': 1980,
                                    'max': {{ date('Y') }}
                                },
                                step: 1,
                                format: wNumb({
                                    decimals: 0
                                }),
                            });

                            sliderRange.noUiSlider.on('update', function( values, handle ) {
                                sliderRangeInputs[handle].value = values[handle];
                            });
                        </script>

                        <div class="text-right">
                            <button class="btn btn-secondary mr-3" type="reset" id="reset_btn">リセット</button>
                            <button class="btn btn-secondary" type="button" id="search_btn">絞り込み</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let searchArea = null;
            let searchFormOpenBtn = null;
            let master = {!! $jsonList !!};

            $(function (){
                searchArea = $('#search');
                searchFormOpenBtn = $('#search_form_open');

                searchFormOpenBtn.click(function (){
                    if (searchArea.css('display') == 'none') {
                        searchFormOpenBtn.text('close ▲');
                    } else {
                        searchFormOpenBtn.text('open ▼');
                    }

                    searchArea.slideToggle(300);
                });

                setToggleButtonActive('.custom-control-input');

                $('#search_btn').click(function (){
                    let word = $('#name').val();
                    if (word.length == 0) {
                        $('.card-item').show();
                    } else {
                        $('.card-item').hide();
                        let reg = new RegExp(word);

                        master.forEach(function (element){
                            if (element.name.match(reg)) {
                                $('#c' + element.id).show();
                            } else if (element.phonetic.match(reg)) {
                                $('#c' + element.id).show();
                            }
                        });
                    }
                });

                $('#reset_btn').click(function (){
                    $('.card-item').show();
                });
            });
        </script>


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
                                <div class="col-xl-3 col-lg-4 col-sm-6 col-12 card-item" id="c{{ $soft->id }}">
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
            $('.game_tab').click(function (e){
                e.preventDefault();

                $('#' + $('#game_tab .active').data('target')).hide();
                $('#game_tab .active').removeClass('active');

                $('#' + $(this).data('target')).show();
                $(this).addClass('active');

                showPackageImage();

                return false;
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
