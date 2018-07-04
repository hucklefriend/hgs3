@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ route('レビュー投稿確認', ['soft' => $soft->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿 悪い点編集</p>
        </header>

        <form method="POST" action="{{ route('レビュー悪い点保存', ['soft' => $soft->id]) }}" autocomplete="off">
            {{ csrf_field() }}

            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="far fa-thumbs-down"></i>悪い点
                        <span class="card-title-sub"><i class="far fa-thumbs-down"></i>付きタグは特に悪い点</span>
                    </h5>

                    <div id="tag-show">
                        <p id="no-tag-text">悪い点はありません。</p>
                        <div id="tag-list">
                            <div class="d-flex flex-wrap mb-2">
                                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                                    <span class="tag simple mr-2 mb-2" id="tag_{{ $tagId }}">
                                        {{ $tagName }}
                                        <span class="review-tag-very" id="very_tag_{{ $tagId }}"><i class="far fa-thumbs-down"></i></span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" id="btn_select">悪い点タグを選び直す</button>
                        </div>
                    </div>

                    <div id="tag-select" style="display:none;">
                        <div class="form-group">
                            <label for="bad_tags" class="hgn-label"><i class="fas fa-check"></i> 悪い点</label>
                            <p class="text-muted">
                                このゲームの悪いところがあれば選択してください。最大10個まで。(<span id="bad_check_num">0</span>個選択中)
                            </p>
                            <div class="d-flex flex-wrap">
                                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                                    <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
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
                            <div class="d-flex flex-wrap">
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

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" id="btn_selected">悪い点タグこれでOK</button>
                        </div>
                        <div class="form-help"></div>
                    </div>
                    <div class="form-help">
                        @include('common.error', ['formName' => 'bad'])
                        @include('common.error', ['formName' => 'very_bad'])
                    </div>

                    <div class="form-group">
                        <label for="bad_comment" class="hgn-label"><i class="fas fa-edit"></i> 悪い点コメント</label>
                        <p class="text-muted">
                            このゲームの悪い点について、言いたいことがあれば記入してください。
                        </p>
                        <textarea name="bad_comment" id="bad_comment" class="form-control textarea-autosize{{ invalid($errors, 'bad_comment') }}">{{ old('bad_comment', $draft->bad_comment) }}</textarea>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        <small>最大文字数：10,000</small>
                        @include('common.error', ['formName' => 'bad_comment'])
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary">悪い点を保存</button>
            </div>
        </form>
    </div>

    <script>
        let badTags = {!! json_encode(old('bad_tags', $draft->getBadTags())) !!};
        let veryBadTags = {!! json_encode(old('very_bad_tags', $draft->getVeryBadTags())) !!};

        let badTagBtn = {};
        let veryBadTagBtn = {};

        $(function (){
            $('.bad_tag').each(function (){
                badTagBtn[$(this).val()] = $(this);
            });
            $('.very_bad_tag').each(function (){
                veryBadTagBtn[$(this).val()] = $(this);
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
            });


            $('.very_bad_tag').on('change', function (){
                setVeryBadTagNum();
            });

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

            setBadTagNum();
            setVeryBadTagNum();

            $('#btn_select').on('click', function (){
                $('#tag-show').hide();
                $('#tag-select').show();
            });
            $('#btn_selected').on('click', function (){
                showTag();

                $('#tag-show').show();
                $('#tag-select').hide();
            });

            showTag();
        });

        function showTag()
        {
            let badTags = $('.bad_tag:checked');
            console.debug(badTags);


            if (badTags.length == 0) {
                $('#no-tag-text').show();
                $('#tag-list').hide();

                console.debug('nothing');
            } else {
                console.debug('exist');
                $('#no-tag-text').hide();

                $('#tag-list').show();
                $('.review-tag').hide();

                badTags.each(function () {
                    $('#tag_' + $(this).val()).show();
                });


                $('.review-tag-very').hide();
                $('.very_bad_tag:checked').each(function (){
                    $('#very_tag_' + $(this).val()).show();
                });
            }
        }

        function changeVeryBtn(target, tagId, checked)
        {
            let btn = $('#very_' + target + '_btn_' + tagId);
            let check = $('#very_' + target + '_tag_' + tagId);

            if (checked) {
                btn.show()
            } else {
                check.prop('checked', false);
                btn.hide();
                setVeryBadTagNum();
            }
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
    </script>

    <style>
        .very_bad {
            display:none;
        }
    </style>
@endsection

