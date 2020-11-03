@extends('layouts.app')

@section('title')フレンド@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>フレンド探し</h1>
        </header>

        <div class="card card-hgn">
            <div class="card-body">
                <h2 class="card-title mb-0">検索フォーム<button id="search_form_open" class="ml-3 btn btn-sm btn-outline-dark">open ▼</button></h2>
                <div id="search" style="display:none;">
                    <form method="GET" action="{{ route('フレンド') }}" class="mt-2">
                        <div class="form-group">
                            <div>
                                <label for="attribute" class="hgn-label"><i class="fas fa-check"></i> 属性</label>
                            </div>
                            <div class="d-flex flex-wrap">
                                @foreach (\Hgs3\Constants\User\Attribute::$text as $attrId => $attrName)
                                    <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                        <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                            <input type="checkbox" class="custom-control-input" id="attr_{{ $attrId }}" name="attr[]" value="{{ $attrId }}" autocomplete="off"{{ checked(in_array($attrId, $attr), true) }}>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description">{{ $attrName }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-help"></div>
                        <div class="form-group">
                            <div>
                                <label for="attribute" class="hgn-label"><i class="fas fa-check"></i> 公開している外部サービス</label>
                            </div>
                            <div class="d-flex flex-wrap">
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" name="sns[]" value="{{ \Hgs3\Constants\SocialSite::TWITTER }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\SocialSite::TWITTER, $sns), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ \Hgs3\Constants\SocialSite::getIconAndName(\Hgs3\Constants\SocialSite::TWITTER) }}</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" name="sns[]" value="{{ \Hgs3\Constants\SocialSite::FACEBOOK }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\SocialSite::FACEBOOK, $sns), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ \Hgs3\Constants\SocialSite::getIconAndName(\Hgs3\Constants\SocialSite::FACEBOOK) }}</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" name="sns[]" value="{{ \Hgs3\Constants\SocialSite::GOOGLE_PLUS }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\SocialSite::GOOGLE_PLUS, $sns), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ \Hgs3\Constants\SocialSite::getIconAndName(\Hgs3\Constants\SocialSite::GOOGLE_PLUS) }}</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" name="sns[]" value="{{ \Hgs3\Constants\SocialSite::GITHUB }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\SocialSite::GITHUB, $sns), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ \Hgs3\Constants\SocialSite::getIconAndName(\Hgs3\Constants\SocialSite::GITHUB) }}</span>
                                    </label>
                                </div>
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" name="sns[]" value="{{ \Hgs3\Constants\SocialSite::PIXIV }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\SocialSite::PIXIV, $sns), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ \Hgs3\Constants\SocialSite::getIconAndName(\Hgs3\Constants\SocialSite::PIXIV) }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-help"></div>
                        <button class="btn btn-secondary">検索</button>
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
            });
        </script>

        @if ($pager->isEmpty())
            <p>指定の条件でプロフィールを公開しているユーザーはいませんでした。</p>
        @else
        <div class="row">
            @foreach ($pager as $item)
                @php $user = $users[$item->id]; @endphp
                @php $attributes = $user->getUserAttributes(); @endphp
                @php $sns = $user->getOpenedSnsModel(); @endphp
                <div class="col-12 col-md-6 col-xl-5">
                    @include ('friend.common.parts', ['user' => $user, 'attributes' => $attributes, 'sns' => $sns, 'mutual' => []])
                </div>
            @endforeach
        </div>

        @include('common.pager', ['pager' => $pager])
        @endif
    </div>
@endsection

