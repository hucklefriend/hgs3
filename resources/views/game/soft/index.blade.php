@extends('layouts.app')

@section('title')ゲーム一覧@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('head_append')
    <link rel="stylesheet" href="{{ url('vendors/bower_components/nouislider/distribute/nouislider.min.css') }}">
    <script src="{{ url('vendors/bower_components/nouislider/distribute/nouislider.min.js') }}"></script>
    <script src="{{ url('js/wNumb.js') }}"></script>
@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ゲーム一覧</h1>
        </header>

        <div class="card card-hgn mb-5">
            <div class="card-body">
                <h4 class="card-title mb-0">検索<button id="search_form_open" class="ml-3 btn btn-sm btn-secondary">open ▼</button></h4>
                <div id="search" style="display:none;">
                    <form method="GET" action="{{ route('ゲーム一覧') }}" class="mt-4" autocomplete="off">
                        <div class="form-group">
                            <label for="name" class="hgn-label"><i class="fas fa-edit"></i> ゲームタイトル</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $name }}">
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
                                        <input type="checkbox" class="custom-control-input" id="platform" name="platform[]" value="1"{{ checked(in_array(1, $platforms), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">家庭用据え置き機</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" name="platform[]" value="2"{{ checked(in_array(2, $platforms), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">家庭用携帯機</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" name="platform[]" value="3"{{ checked(in_array(3, $platforms), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">PC</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" name="platform[]" value="4"{{ checked(in_array(4, $platforms), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">スマホ・タブレット・携帯電話</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="platform" name="platform[]" value="5"{{ checked(in_array(5, $platforms), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">その他(DVD-PG等)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-help">
                            <p class="text-muted">
                                <small>Nintendo Switchは家庭用据え置き機です。</small>
                            </p>
                        </div>

                        <div class="form-group">
                            <div>
                                <label for="platform" class="hgn-label"><i class="fas fa-edit"></i> 年齢制限</label>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="rate" name="rate[]" value="0"{{ checked(in_array(0, $rate), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">なし</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="rate" name="rate[]" value="2"{{ checked(in_array(2, $rate), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">18禁(コンシューマ)</span>
                                    </label>
                                </div>
                                @if (\Illuminate\Support\Facades\Auth::check())
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="rate" name="rate[]" value="1"{{ checked(in_array(1, $rate), true) }}>
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
                                <small>制限のあるパッケージとないパッケージが両方発売されている場合は、いずれにチェックを入れても検索結果に出てきます。</small>
                            </p>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-secondary" type="submit" id="search_btn">検索</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let searchArea = null;
            let searchFormOpenBtn = null;

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

                $('#reset_btn').click(function (){
                    $('.card-item').show();
                });
            });
        </script>

        @if (empty($list))
            <div class="card card-hgn mb-5">
                <div class="card-body">
                    <p class="mb-0">ゲームソフトが見つかりませんでした。<br>検索条件を変えて、再度検索してみてください。</p>
                </div>
            </div>
        @else

        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap" id="game_tab">
                    @foreach ($phonetics as $phonetic)
                    <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetic[1]) active @endif " href="#" data-target="{{ $phonetic[0] }}gyo" id="tab_{{ $phonetic[0] }}gyo">{!! $phonetic[2] !!}</a>
                    @endforeach
                </div>

                @foreach ($phonetics as $no => $p)
                    <section id="{{ $p[0] }}gyo" @if ($defaultPhoneticType != $p[1]) style="display:none;" @endif>
                        <div class="row game-list">
                        @if (isset($list[$p[1]]))
                            @foreach ($list[$p[1]] as $soft)
                                <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
                                    <div class="package-card">
                                        <div>
                                            <div><img data-url="{{ $soft[$imageFile] }}" class="lazy-img-load"></div>
                                            <div>
                                                {{ $soft['name'] }}
                                                @isset($favoriteSofts[$soft['id']])
                                                    <small><span class="favorite-icon"><i class="fas fa-star"></i></span></small>
                                                @endisset
                                            </div>
                                            <div>
                                                <a href="{{ route('ゲーム詳細', ['game' => $soft['id']]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
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
                    if ($(window).scrollTop() > 182) {
                        $("html,body").animate({scrollTop:182}, 'fast');
                    }

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

        @endif
    </div>
@endsection
