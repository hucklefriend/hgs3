@extends('layouts.app')

@section('title')レビュー投稿 | @endsection

@section('global_back_link')
    <a href="{{ route('ユーザーのレビュー', ['user' => Auth::id()]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>レビュー投稿</h1>

    @if ($isDraft)
    <div class="alert alert-warning" role="alert">
        下書きを読み込みました。
    </div>
    @endif


    <p>入力される前に、注意事項をお読みください。</p>


    <form method="POST" action="{{ route('レビュー投稿確認') }}" autocomplete="off">
        <input type="hidden" name="soft_id" value="{{ $soft->id }}">
        {{ csrf_field() }}

        <div>
            <p>
                プレイしたパッケージを選択してください。<br>
                「遊んだことがあるゲーム」に登録済みであれば、デフォルトで選択されます。
            </p>

            @foreach ($packages as $pkg)
                <div class="btn-group-toggle my-1" data-toggle="buttons">
                    <label class="btn btn-outline-info text-left handle_soft_check_btn border-0">
                        <input type="checkbox" class="handle_soft_check hide-check" name="package_id[]" value="{{ $pkg->id }}" autocomplete="off">
                        <span>{{ $pkg->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="title">進捗状態</label>
            <textarea name="title" id="title" class="form-control{{ invalid($errors, 'title') }}" required>{{ $draft->progress }}</textarea>
            @include('common.error', ['formName' => 'title'])
            <p class="text-muted">
                <small>
                    このゲームをどの程度遊んだか、簡単に書いてください。<br>
                    例：プレイ時間、何周クリアした、エンディング全種類見た、隠し要素全部出した、etc...
                </small>
            </p>
        </div>

        <div class="form-group">
            <label for="title">怖さ</label>
            <input type="range" id="fear" name="fear" min="0" max="8">
            <span id="fear_text"></span>
            @include('common.error', ['formName' => 'fear'])
            <p class="text-muted">
                <small>
                    どの程度怖かったかを0～8で設定してください。
                </small>
            </p>
        </div>

        <div class="form-group">
            <label for="title">良かったところ</label>
            <p>このゲームの良かったところがあれば選択してください。</p>
            <div class="d-flex flex-wrap">
            @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons">
                    <label class="btn btn-outline-info text-left handle_soft_check_btn border-1">
                        <input type="checkbox" class="handle_soft_check hide-check good_tag" name="good_tags[]" value="{{ $tagId }}" autocomplete="off">
                        <span>{{ $tagName }}</span>
                    </label>
                </div>
            @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="title">すごく良かったところ</label>
            <p>良かったところの中で、他のゲームと比べても特に優れているところがあれば選択してください。</p>
            <p id="very_good_nothing">良かったところを選択してください</p>
            <div class="d-flex flex-wrap" id="very_good_select">
                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                    <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons" id="very_good_btn_{{ $tagId }}" style="display:none;">
                        <label class="btn btn-outline-info text-left handle_soft_check_btn border-1">
                            <input type="checkbox" id="very_good_tag_{{ $tagId }}" class="handle_soft_check hide-check very_good_tag" name="very_good_tags[]" value="{{ $tagId }}" autocomplete="off">
                            <span>{{ $tagName }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="title">悪かったところ</label>
            <p>このゲームの悪かったところがあれば選択してください。</p>
            <div class="d-flex flex-wrap">
                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                    <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons">
                        <label class="btn btn-outline-info text-left handle_soft_check_btn border-1">
                            <input type="checkbox" class="handle_soft_check hide-check bad_tag" name="bad_tags[]" value="{{ $tagId }}" autocomplete="off">
                            <span>{{ $tagName }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="title">すごく悪かったところ</label>
            <p>悪かったところの中で、他のゲームと比べても特に劣っているところがあれば選択してください。</p>
            <p id="very_bad_nothing">悪かったところを選択してください</p>
            <div class="d-flex flex-wrap" id="very_bad_select">
                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                    <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons" id="very_bad_btn_{{ $tagId }}" style="display:none;">
                        <label class="btn btn-outline-info text-left handle_soft_check_btn border-1">
                            <input type="checkbox" id="very_bad_tag_{{ $tagId }}" class="handle_soft_check hide-check" name="very_bad_tags[]" value="{{ $tagId }}" autocomplete="off">
                            <span>{{ $tagName }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="title">外部レビュー</label>
            <textarea name="good_comment" id="url" class="form-control{{ invalid($errors, 'url') }}" required>{{ $draft->url }}</textarea>
            @include('common.error', ['formName' => 'title'])
            <p class="text-muted">
                <small>
                    レビューを投稿しているブログなどがあれば、そちらのURLを記載してください。
                </small>
            </p>
        </div>

        <div class="form-group">
            <label for="title">良い点</label>
            <p>このゲームの良い所について記入してください。</p>
            <textarea name="good_comment" id="good_comment" class="form-control{{ invalid($errors, 'good_comment') }}" required>{{ $draft->good_comment }}</textarea>
            @include('common.error', ['formName' => 'title'])
            <p class="text-muted">
                <small>このゲームをどの程度遊んだか、簡単に書いてください。</small>
            </p>
        </div>

        <div class="form-group">
            <label for="title">悪い点</label>
            <p>このゲームの悪い点について、言いたいことがあれば記入してください。</p>
            <textarea name="bad_comment" id="bad_comment" class="form-control{{ invalid($errors, 'bad_comment') }}" required>{{ $draft->bad_comment }}</textarea>
            @include('common.error', ['formName' => 'bad_comment'])
        </div>

        <div class="form-group">
            <label for="title">総合評価</label>
            <p>総合評価を記入してください。</p>
            <textarea name="general_comment" id="general_comment" class="form-control{{ invalid($errors, 'general_comment') }}" required>{{ $draft->general_comment }}</textarea>
            @include('common.error', ['formName' => 'general_comment'])
        </div>
    </form>

    <script>
        let fearText = {!! json_encode(\Hgs3\Constants\Review\Fear::$data)  !!};
        let goodTags = {};
        let veryGoodTags = {};
        let badTags = {};
        let veryBadTags = {};

        $(function (){
            $('#fear').on('input change', function (){
                let val = parseInt($(this).val());
                setFearText(val);
            });

            $('.good_tag').on('change', function (){
                let tagId = $(this).val();
                goodTags[tagId] = $(this).prop('checked');

                if (goodTags[tagId]) {
                    $('#very_good_btn_' + tagId).show();
                } else {
                    $('#very_good_tag_' + tagId).prop('checked', false);
                    $('#very_good_btn_' + tagId).hide();
                    $('#very_good_btn_' + tagId + ' label').removeClass('active');
                }

                if ($('.good_tag:checked').length == 0) {
                    $('#very_good_nothing').show();
                    $('#very_good_select').hide();
                } else {
                    $('#very_good_nothing').hide();
                    $('#very_good_select').show();
                }
            });


            $('.bad_tag').on('change', function (){
                let tagId = $(this).val();
                if ($(this).prop('checked')) {
                    $('#very_bad_btn_' + tagId).show();
                } else {
                    $('#very_bad_tag_' + tagId).prop('checked', false);
                    $('#very_bad_btn_' + tagId).hide();
                    $('#very_bad_btn_' + tagId + ' label').removeClass('active');
                }
            });

            let fear = parseInt($('#fear').val());
            setFearText(fear);
        });

        function setFearText(val)
        {
            $('#fear_text').text(fearText[val]);
        }
    </script>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザーのレビュー', ['user' => Auth::id()]) }}">レビュー</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー投稿</li>
        </ol>
    </nav>
@endsection
