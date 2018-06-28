@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::reviewInput($soft) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿</p>
        </header>

        <div class="@if ($draft->isDefault) mb-5 @endif alert alert-warning alert-warning-hgn border-0">
            入力される前に、<a href="{{ route('レビューについて') }}">レビューについて</a>を一度お読みください。
        </div>

        @if (!$draft->isDefault)
            <div class="alert mt-3 mb-4 alert-secondary alert-secondary-hgn" role="alert">
                下書きを読み込みました。
            </div>
        @endif

        <form method="POST" action="{{ route('レビュー保存') }}" autocomplete="off">
            <input type="hidden" name="soft_id" value="{{ $soft->id }}">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="pkg" class="hgn-label"><i class="fas fa-check"></i> プレイしたパッケージ</label>
                <span class="badge badge-secondary ml-2">必須</span>
                <p class="text-muted mb-2">
                    プレイしたパッケージを選択してください。<br>
                    分からなければ、近そうなものを選びましょう。
                </p>

                <div class="d-flex flex-wrap">
                    @foreach ($packages as $pkg)
                        <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                            <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                <input type="checkbox" class="custom-control-input" id="pkg_{{ $pkg->id }}" name="package_id[]" value="{{ $pkg->id }}" autocomplete="off">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">{{ $pkg->acronym }}</span>
                            </label>
                        </div>
                    @endforeach
                    <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                        <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                            <input type="checkbox" class="custom-control-input" id="pkg_0" name="package_id[]" value="0" autocomplete="off">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">動画等で他人のプレイを見た</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'package_id'])
            </div>

            <div class="form-group">
                <label for="progress" class="hgn-label"><i class="fas fa-edit"></i> 進捗状態</label>
                <p class="text-muted">
                    このゲームをどの程度遊んだか、簡単に書いてください。<br>
                    例：プレイ時間、何周クリアした、エンディング全種類見た、PS2版は全クリアしたけどPC版は半分まで、××さんの実況動画を見た、友達がやっているのを横で見ていた、etc...<br>
                    <span style="color: indianred;">※ネタバレとなるような内容をここに書かないでください。</span>
                </p>
                <textarea name="progress" id="progress" class="form-control textarea-autosize{{ invalid($errors, 'progress') }}">{{ old('progress', $draft->progress) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'progress'])
            </div>

            <div class="form-group">
                <label for="fear" class="hgn-label">😱 怖さ</label>
                <span class="badge badge-secondary ml-2">必須</span>
                <p class="text-muted">
                    どの程度怖かったかを設定してください。
                </p>
                <input type="hidden" name="fear" id="fear" value="{{ old('fear', $draft->fear) }}">
                <div class="d-flex justify-content-between justify-content-sm-start">
                    <div>
                        <button class="btn btn-light btn--icon" type="button" id="fear_down"><i class="far fa-arrow-alt-circle-down"></i></button>
                        <button class="btn btn-light btn--icon hidden-xs-down mx-3" type="button" id="fear_up"><i class="far fa-arrow-alt-circle-up"></i></button>
                    </div>
                    <div class="align-self-center">
                        <p id="fear_text" class="lead force-break mx-2 mb-0"></p>
                    </div>
                    <div>
                        <button class="btn btn-light btn--icon hidden-sm-up" type="button" id="fear_up2"><i class="far fa-arrow-alt-circle-up"></i></button>
                    </div>
                </div>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'fear'])
            </div>

            <div class="form-group">
                <label for="good_tags" class="hgn-label"><i class="fas fa-check"></i> 良い点</label>
                <p class="text-muted">
                    このゲームの良いところがあれば選択してください。最大10個まで。(<span id="good_check_num">0</span>個選択中)
                </p>
                <div class="d-flex flex-wrap">
                    @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                        <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                            <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                <input type="checkbox" class="custom-control-input good_tag" name="good_tags[]" value="{{ $tagId }}" autocomplete="off">
                                <span class="custom-control-indicator"></span>
                                <span>{{ $tagName }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-help"></div>

            <div class="form-group">
                <label for="very_good_tags" class="hgn-label"><i class="fas fa-check"></i> すごく良い点</label>
                <p class="text-muted">
                    良い点の中で、他のゲームと比べても特に優れているところがあれば選択してください。(<span id="very_good_check_num">0</span>個選択中)
                </p>
                <div class="d-flex flex-wrap">
                    @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                        <div class="btn-group-toggle my-1 mr-2 very_good" data-toggle="buttons" id="very_good_btn_{{ $tagId }}">
                            <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                <input type="checkbox" id="very_good_tag_{{ $tagId }}" class="custom-control-input very_good_tag" name="very_good_tags[]" value="{{ $tagId }}" autocomplete="off">
                                <span class="custom-control-indicator"></span>
                                <span>{{ $tagName }}</span>
                            </label>
                        </div>
                    @endforeach
                    <p id="no_good_text" class="text-warning">良い点を選択すると、すごく良い点が選択できるようになります。</p>
                </div>
            </div>
            <div class="form-help"></div>

            <div class="form-group">
                <label for="bad_tags" class="hgn-label"><i class="fas fa-check"></i> 悪い点</label>
                <p class="text-muted">
                    このゲームの悪いところがあれば選択してください。最大10個まで。(<span id="bad_check_num">0</span>個選択中)
                </p>
                <div class="d-flex flex-wrap">
                    @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                        <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons">
                            <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                <input type="checkbox" class="custom-control-input bad_tag" name="bad_tags[]" value="{{ $tagId }}" autocomplete="off">
                                <span class="custom-control-indicator"></span>
                                <span>{{ $tagName }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-help"></div>

            <div class="form-group">
                <label for="very_bad_tags" class="hgn-label"><i class="fas fa-check"></i> すごく悪い点</label>
                <p class="text-muted">
                    悪い点の中で、他のゲームと比べても特に劣っているところがあれば選択してください。(<span id="very_bad_check_num">0</span>個選択中)
                </p>
                <div class="d-flex flex-wrap" id="very_bad_select">
                    @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                        <div class="btn-group-toggle my-1 mr-2 very_bad" data-toggle="buttons" id="very_bad_btn_{{ $tagId }}">
                            <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                <input type="checkbox" id="very_bad_tag_{{ $tagId }}" class="custom-control-input very_bad_tag" name="very_bad_tags[]" value="{{ $tagId }}" autocomplete="off">
                                <span class="custom-control-indicator"></span>
                                <span>{{ $tagName }}</span>
                            </label>
                        </div>
                    @endforeach
                    <p id="no_bad_text" class="text-warning">悪い点を選択すると、すごく悪い点が選択できるようになります。</p>
                </div>
            </div>
            <div class="form-help"></div>

            <div class="form-group">
                <div class="d-flex">
                    <div class="review-point" id="total_point"></div>

                    <table class="review-point-table">
                        <tr>
                            <th>😱 怖さ</th>
                            <td class="text-right"><span id="total_fear"></span>pt</td>
                        </tr>
                        <tr>
                            <th><i class="far fa-thumbs-up"></i> 良い点</th>
                            <td class="text-right" id="total_point"><span id="total_good"></span>pt</td>
                        </tr>
                        <tr>
                            <th><i class="far fa-thumbs-down"></i> 悪い点</th>
                            <td class="text-right" id="total_point">-<span id="total_bad"></span>pt</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="form-group p-4 mt-2" style="background-color: rgba(0, 0, 0, 0.2);">
                <p class="text-muted">
                    点数に関わる項目があるのはここまでです。<br>
                    一旦保存して、コメントは後でゆっくり書くというのはいかがでしょう？
                </p>
                <button class="btn btn-primary">下書き保存して確認画面へ</button>
            </div>
            <div class="form-help"></div>


            <div class="form-group">
                <label for="url" class="hgn-label"><i class="fas fa-edit"></i> 外部レビュー</label>
                <p class="text-muted">
                    このゲームのレビューを投稿しているブログなどがあれば、URLを記載して頂くと、案内するリンクをレビュー内に記載します。<br>
                    ※このURLのみ、管理人がチェックするまで非公開状態となります。
                </p>
                <input type="text" name="url" id="url" class="form-control{{ invalid($errors, 'url') }}" value="{{ old('url', $draft->url) }}">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'url'])
            </div>

            <div class="form-group">
                <label for="fear_comment" class="hgn-label"><i class="fas fa-edit"></i> 怖さ</label>
                <p class="text-muted">
                    怖さについて、言いたいことがあれば記入してください。
                </p>
                <textarea name="fear_comment" id="fear_comment" class="form-control textarea-autosize{{ invalid($errors, 'fear_comment') }}">{{ old('fear_comment', $draft->fear_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'fear_comment'])
            </div>

            <div class="form-group">
                <label for="good_comment" class="hgn-label"><i class="fas fa-edit"></i> 良い点</label>
                <p class="text-muted">
                    このゲームの良い点について、言いたいことがあれば記入してください。
                </p>
                <textarea name="good_comment" id="good_comment" class="form-control textarea-autosize{{ invalid($errors, 'good_comment') }}">{{ old('good_comment', $draft->good_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'good_comment'])
            </div>

            <div class="form-group">
                <label for="bad_comment" class="hgn-label"><i class="fas fa-edit"></i> 悪い点</label>
                <p class="text-muted">
                    このゲームの悪い点について、言いたいことがあれば記入してください。
                </p>
                <textarea name="bad_comment" id="bad_comment" class="form-control textarea-autosize{{ invalid($errors, 'bad_comment') }}">{{ old('bad_comment', $draft->bad_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'bad_comment'])
            </div>


            <div class="form-group">
                <label for="general_comment" class="hgn-label"><i class="fas fa-edit"></i> 総評</label>
                <p class="text-muted">
                    総評を記入してください。
                </p>
                <textarea name="general_comment" id="general_comment" class="form-control textarea-autosize{{ invalid($errors, 'general_comment') }}">{{ old('general_comment', $draft->general_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'general_comment'])
            </div>


            <div class="form-group">
                <label for="is_spoiler" class="hgn-label"><i class="fas fa-check"></i> ネタバレ</label>
                <p class="text-muted">
                    レビュー内容にネタバレを含む場合は、ありにチェックを入れてください。<br>
                    ありにすると、「ネタバレ注意」の表記が付きます。<br>
                    ネタバレがあるのになしに設定されていた場合、レビューが削除される場合があります。
                </p>

                <label class="custom-control custom-radio">
                    <input type="radio" name="is_spoiler" class="custom-control-input" id="is_spoiler1" value="0"{{ checked(old('is_spoiler', $draft->is_spoiler), 0) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">なし</span>
                </label>
                <label class="custom-control custom-radio">
                    <input type="radio" name="is_spoiler" class="custom-control-input" id="is_spoiler2" value="1"{{ checked(old('is_spoiler', $draft->is_spoiler), 1) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">あり</span>
                </label>
            </div>
            <div class="form-help"></div>

            <div class="form-group text-center">
                <button class="btn btn-primary">下書き保存して確認画面へ</button>
                <p class="text-muted mt-2">
                    <small>
                        下書き保存でも必須項目の入力は必要です。<br>
                        下書き保存してもまだ公開はされません。<br>
                        次の確認画面で公開することによって初めて公開されます。
                    </small>
                </p>
            </div>
        </form>
    </div>

    <script>
        let packageId = {!! old('package_id', null) == null ? $draft->package_id : json_encode(old('package_id')) !!}
        let fearText = {!! json_encode(\Hgs3\Constants\Review\Fear::$textWithPoint)  !!};
        let goodTags = {!! json_encode(old('good_tags', $draft->getGoodTags())) !!};
        let veryGoodTags = {!! json_encode(old('very_good_tags', $draft->getVeryGoodTags())) !!};
        let badTags = {!! json_encode(old('bad_tags', $draft->getBadTags())) !!};
        let veryBadTags = {!! json_encode(old('very_bad_tags', $draft->getVeryBadTags())) !!};

        let goodTagBtn = {};
        let veryGoodTagBtn = {};
        let badTagBtn = {};
        let veryBadTagBtn = {};

        let fear = null;

        $(function (){
            fear = $('#fear');

            $('.good_tag').each(function (){
                goodTagBtn[$(this).val()] = $(this);
            });
            $('.very_good_tag').each(function (){
                veryGoodTagBtn[$(this).val()] = $(this);
            });
            $('.bad_tag').each(function (){
                badTagBtn[$(this).val()] = $(this);
            });
            $('.very_bad_tag').each(function (){
                veryBadTagBtn[$(this).val()] = $(this);
            });

            $('.good_tag').on('change', function (){
                let goodTagNum = $('.good_tag:checked').length;
                if (goodTagNum >= 10) {
                    $('.good_tag:not(:checked)').prop('disabled', true);
                } else {
                    $('.good_tag:not(:checked)').prop('disabled', false);
                }

                changeVeryBtn('good', $(this).val(), $(this).prop('checked'));
                setGoodTagNum();
                setVeryGoodTagNum();
                setTotalPoint();
            });

            $('.bad_tag').on('change', function (){
                let badTagNum = $('.bad_tag:checked').length;
                if (badTagNum >= 10) {
                    $('.bad_tag:not(:checked)').prop('disabled', true);
                } else {
                    $('.bad_tag:not(:checked)').prop('disabled', false);
                }

                changeVeryBtn('bad', $(this).val(), $(this).prop('checked'));
                setBadTagNum();
                setVeryBadTagNum();
                setTotalPoint();
            });

            $('.very_good_tag').on('change', function (){
                setVeryGoodTagNum();
                setTotalPoint();
            });
            $('.very_bad_tag').on('change', function (){
                setVeryBadTagNum();
                setTotalPoint();
            });

            $('#fear_down').on('click', function (){
                let val = parseInt(fear.val());

                if (val > 0) {
                    fear.val(val - 1);
                    setFearText();
                }
                setTotalPoint();
            });

            $('#fear_up, #fear_up2').on('click', function (){
                let val = parseInt(fear.val());

                if (val < fearText.length - 1) {
                    fear.val(val + 1);
                    setFearText();
                }
                setTotalPoint();
            });

            setFearText();

            if (goodTags.length > 0) {
                goodTags.forEach(function (val){
                    id = parseInt(val);
                    toggleButton(goodTagBtn[id], true);
                    changeVeryBtn('good', id, goodTagBtn[id].prop('checked'));
                });
            }

            if (veryGoodTags.length > 0) {
                veryGoodTags.forEach(function (val){
                    id = parseInt(val);
                    toggleButton(veryGoodTagBtn[id], true);
                });
            }

            if (badTags.length > 0) {
                badTags.forEach(function (val){
                    id = parseInt(val);
                    toggleButton(badTagBtn[id], true);
                    changeVeryBtn('bad', id, badTagBtn[id].prop('checked'));
                });
            }

            if (veryBadTags.length > 0) {
                veryBadTags.forEach(function (val){
                    id = parseInt(val);
                    toggleButton(veryBadTagBtn[id], true);
                });
            }

            packageId.forEach(function (pkgId){
                toggleButton($('#pkg_' + pkgId), true);
            });

            setGoodTagNum();
            setVeryGoodTagNum();
            setBadTagNum();
            setVeryBadTagNum();
            setTotalPoint();
        });

        function changeVeryBtn(target, tagId, checked)
        {
            let btn = $('#very_' + target + '_btn_' + tagId);
            let check = $('#very_' + target + '_tag_' + tagId);

            if (checked) {
                btn.show()
            } else {
                check.prop('checked', false);
                btn.hide();
                setVeryGoodTagNum();setVeryBadTagNum();
            }
        }

        function setFearText()
        {
            let val = $('#fear').val();

            $('#fear_text').text(fearText[val]);
        }

        function setGoodTagNum()
        {
            let num = $('.good_tag:checked').length;
            $('#good_check_num').text(num);

            (num > 0) ? $('#no_good_text').hide() : $('#no_good_text').show();
        }

        function setVeryGoodTagNum()
        {
            let num = $('.very_good_tag:checked').length;
            $('#very_good_check_num').text(num);
        }

        function setBadTagNum()
        {
            let num = $('.bad_tag:checked').length;
            $('#bad_check_num').text(num);

            (num > 0) ? $('#no_bad_text').hide() : $('#no_bad_text').show();
        }

        function setVeryBadTagNum()
        {
            let num = $('.very_bad_tag:checked').length;
            $('#very_bad_check_num').text(num);
        }

        function setTotalPoint()
        {
            let fear = $('#fear').val() * {{ \Hgs3\Constants\Review\Fear::POINT_RATE }};
            let goodNum = $('.good_tag:checked').length;
            let veryGoodNum = $('.very_good_tag:checked').length;
            let badNum = $('.bad_tag:checked').length;
            let veryBadNum = $('.very_bad_tag:checked').length;

            $('#total_point').text(fear + goodNum + veryGoodNum - badNum - veryBadNum);
            $('#total_fear').text(fear);
            $('#total_good').text((goodNum + veryGoodNum) * {{ \Hgs3\Constants\Review\Tag::POINT_RATE }});
            $('#total_bad').text((badNum + veryBadNum) * {{ \Hgs3\Constants\Review\Tag::POINT_RATE }});
        }

    </script>

    <style>
        .very_bad, .very_good {
            display:none;
        }
    </style>

@endsection
