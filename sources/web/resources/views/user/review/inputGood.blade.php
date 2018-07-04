@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ route('レビュー投稿確認', ['soft' => $soft->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿 良い点編集</p>
        </header>

        <form method="POST" action="{{ route('レビュー良い点保存', ['soft' => $soft->id]) }}" autocomplete="off">
            {{ csrf_field() }}

            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="far fa-thumbs-up"></i>良い点
                        <span class="card-title-sub"><i class="far fa-thumbs-up"></i>付きタグは特に良い点</span>
                    </h5>

                    <div id="tag-show">
                        <p id="no-tag-text">良い点はありません。</p>
                        <div id="tag-list">
                            <div class="d-flex flex-wrap mb-2" id="tag-list">
                                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                                    <span class="tag simple mr-2 mb-2" id="tag_{{ $tagId }}">
                                        {{ $tagName }}
                                        <span class="review-tag-very" id="very_tag_{{ $tagId }}"><i class="far fa-thumbs-up"></i></span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" id="btn_select">良い点タグを選び直す</button>
                        </div>
                    </div>

                    <div id="tag-select" style="display:none;">
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

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary" id="btn_selected">良い点タグこれでOK</button>
                        </div>
                        <div class="form-help"></div>
                    </div>
                    <div class="form-help">
                        @include('common.error', ['formName' => 'good'])
                    </div>

                    <div class="form-group">
                        <label for="good_comment" class="hgn-label"><i class="fas fa-edit"></i> 良い点コメント</label>
                        <p class="text-muted">
                            このゲームの良い点について、言いたいことがあれば記入してください。
                        </p>
                        <textarea name="good_comment" id="good_comment" class="form-control textarea-autosize{{ invalid($errors, 'good_comment') }}">{{ old('good_comment', $draft->good_comment) }}</textarea>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        <small>最大文字数：10,000</small>
                        @include('common.error', ['formName' => 'good_comment'])
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary">良い点を保存</button>
            </div>
        </form>
    </div>

    <script>
        let goodTags = {!! json_encode(old('good_tags', $draft->getGoodTags())) !!};
        let veryGoodTags = {!! json_encode(old('very_good_tags', $draft->getVeryGoodTags())) !!};

        let goodTagBtn = {};
        let veryGoodTagBtn = {};

        $(function (){
            $('.good_tag').each(function (){
                goodTagBtn[$(this).val()] = $(this);
            });
            $('.very_good_tag').each(function (){
                veryGoodTagBtn[$(this).val()] = $(this);
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
            });


            $('.very_good_tag').on('change', function (){
                setVeryGoodTagNum();
            });

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

            setGoodTagNum();
            setVeryGoodTagNum();

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

            let goodTags = $('.good_tag:checked');
            if (goodTags.length == 0) {
                $('#no-tag-text').show();
                $('#tag-list').hide();
            } else {
                $('#no-tag-text').hide();

                $('#tag-list').show();
                $('.review-tag').hide();

                goodTags.each(function () {
                    $('#tag_' + $(this).val()).show();
                });


                $('.review-tag-very').hide();
                $('.very_good_tag:checked').each(function (){
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
                setVeryGoodTagNum();
            }
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
    </script>

    <style>
        .very_good {
            display:none;
        }
    </style>
@endsection
