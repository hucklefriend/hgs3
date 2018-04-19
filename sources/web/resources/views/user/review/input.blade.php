@extends('layouts.app')

@section('title')レビュー投稿@endsection
@section('global_back_link'){{ route('ユーザーのレビュー', ['user' => Auth::id()]) }}@endsection

@section('content')
    <h1>レビュー投稿</h1>

    @if (!$draft->isDefault)
    <div class="alert alert-warning" role="alert">
        下書きを読み込みました。
    </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $key => $error)
                    <li>{{ $key }}: {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-5">
        <p>入力される前に、注意事項をお読みください。</p>
    </div>

    <form method="POST" action="{{ route('レビュー保存') }}" autocomplete="off">
        <input type="hidden" name="soft_id" value="{{ $soft->id }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="package_id" class="label-big-hgn">プレイしたパッケージ</label>

            <p class="text-muted mb-0">
                <small>
                    プレイしたパッケージを選択してください。
                </small>
            </p>

            <div class="d-flex flex-wrap">
            @foreach ($packages as $pkg)
                <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons">
                    <label class="btn btn-outline-info text-left handle_soft_check_btn border-0 btn-sm">
                        <input type="checkbox" id="pkg_{{ $pkg->id }}" class="handle_soft_check hide-check" name="package_id[]" value="{{ $pkg->id }}" autocomplete="off">
                        <span>{{ $pkg->name }}</span>
                    </label>
                </div>
            @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="progress" class="label-big-hgn">進捗状態</label>
            <p class="text-muted">
                <small>
                    このゲームをどの程度遊んだか、簡単に書いてください。<br>
                    例：プレイ時間、何周クリアした、エンディング全種類見た、隠し要素全部出した、etc...
                </small>
            </p>
            <textarea name="progress" id="progress" class="form-control{{ invalid($errors, 'progress') }}">{{ $draft->progress }}</textarea>
            @include('common.error', ['formName' => 'progress'])
        </div>

        <div class="form-group">
            <label for="fear" class="label-big-hgn">怖さ</label>
            <p class="text-muted">
                <small>
                    どの程度怖かったかを0～8で設定してください。
                </small>
            </p>

            <p id="fear_text"></p>
            <input type="range" id="fear" name="fear" min="0" max="8">

            @include('common.error', ['formName' => 'fear'])
        </div>

        <div class="form-group">
            <label for="title" class="label-big-hgn">良かったところ</label>
            <p class="text-muted">
                <small>
                    このゲームの良かったところがあれば選択してください。
                </small>
            </p>
            <div class="d-flex flex-wrap">
            @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons">
                    <label class="btn btn-outline-info text-left handle_soft_check_btn border-1 btn-sm">
                        <input type="checkbox" class="handle_soft_check hide-check good_tag" name="good_tags[]" value="{{ $tagId }}" autocomplete="off">
                        <span>{{ $tagName }}</span>
                    </label>
                </div>
            @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="title" class="label-big-hgn">すごく良かったところ</label>
            <p class="text-muted">
                <small>良かったところの中で、他のゲームと比べても特に優れているところがあれば選択してください。</small>
            </p>
            <div class="d-flex flex-wrap">
                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                    <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons" id="very_good_btn_{{ $tagId }}">
                        <label class="btn btn-outline-secondary text-left handle_soft_check_btn border-1 disabled btn-sm">
                            <input type="checkbox" id="very_good_tag_{{ $tagId }}" class="handle_soft_check hide-check very_good_tag" name="very_good_tags[]" value="{{ $tagId }}" autocomplete="off">
                            <span>{{ $tagName }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="title" class="label-big-hgn">悪かったところ</label>
            <p class="text-muted">
                <small>このゲームの悪かったところがあれば選択してください。</small>
            </p>
            <div class="d-flex flex-wrap">
                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                    <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons">
                        <label class="btn btn-outline-info text-left handle_soft_check_btn border-1 btn-sm">
                            <input type="checkbox" class="handle_soft_check hide-check bad_tag" name="bad_tags[]" value="{{ $tagId }}" autocomplete="off">
                            <span>{{ $tagName }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="title" class="label-big-hgn">すごく悪かったところ</label>
            <p class="text-muted">
                <small>悪かったところの中で、他のゲームと比べても特に劣っているところがあれば選択してください。</small>
            </p>
            <div class="d-flex flex-wrap" id="very_bad_select">
                @foreach (\Hgs3\Constants\Review\Tag::$tags as $tagId => $tagName)
                    <div class="btn-group-toggle my-1 mr-2" data-toggle="buttons" id="very_bad_btn_{{ $tagId }}">
                        <label class="btn btn-outline-info text-left handle_soft_check_btn border-1 disabled btn-sm">
                            <input type="checkbox" id="very_bad_tag_{{ $tagId }}" class="handle_soft_check hide-check very_bad_tag" name="very_bad_tags[]" value="{{ $tagId }}" autocomplete="off">
                            <span>{{ $tagName }}</span>
                        </label>
                    </div>
                @endforeach
            </div>

        </div>

        <div class="form-group">
            <label for="url" class="label-big-hgn">外部レビュー</label>
            <p class="text-muted">
                <small>
                    レビューを投稿しているブログなどがあれば、そちらのURLを記載してください。<br>
                    URLは管理人がチェックしてからでないと、一般公開されません。
                </small>
            </p>
            <input type="text" name="url" id="url" class="form-control{{ invalid($errors, 'url') }}" value="{{ old('url', $draft->url) }}">
            @include('common.error', ['formName' => 'url'])
        </div>

        <div class="form-group">
            <label for="good_comment" class="label-big-hgn">良い点</label>
            <p class="text-muted">
                <small>このゲームの良い点について、言いたいことがあれば記入してください。</small>
            </p>
            <textarea name="good_comment" id="good_comment" class="form-control{{ invalid($errors, 'good_comment') }}">{{ old('good_comment', $draft->good_comment) }}</textarea>
            @include('common.error', ['formName' => 'good_comment'])
        </div>

        <div class="form-group">
            <label for="bad_comment" class="label-big-hgn">悪い点</label>
            <p class="text-muted">
                <small>このゲームの悪い点について、言いたいことがあれば記入してください。</small>
            </p>
            <textarea name="bad_comment" id="bad_comment" class="form-control{{ invalid($errors, 'bad_comment') }}">{{ old('bad_comment', $draft->bad_comment) }}</textarea>
            @include('common.error', ['formName' => 'bad_comment'])

        </div>

        <div class="form-group">
            <label for="general_comment" class="label-big-hgn">総合評価</label>
            <p class="text-muted">
                <small>総合評価を記入してください。</small>
            </p>
            <textarea name="general_comment" id="general_comment" class="form-control{{ invalid($errors, 'general_comment') }}">{{ old('general_comment', $draft->general_comment) }}</textarea>
            @include('common.error', ['formName' => 'general_comment'])
        </div>

        <div class="form-group">
            <label for="general_comment" class="label-big-hgn">ネタバレ</label>
            <p class="text-muted">
                <small>レビュー内容にネタバレを含む場合は、ありにチェックを入れてください。</small>
            </p>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_spoiler" id="is_spoiler1" value="0"{{ checked(old('is_spoiler', $draft->is_spoiler), 0) }}>
                <label class="form-check-label" for="is_spoiler1">なし</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="is_spoiler" id="is_spoiler2" value="1"{{ checked(old('is_spoiler', $draft->is_spoiler), 1) }}>
                <label class="form-check-label" for="is_spoiler2">あり</label>
            </div>
        </div>

        <div class="form-group">
            <button class="btn btn-primary">保存</button>
            <p class="text-muted">
                <small>
                    保存してもまだ公開はされません。<br>
                    次の記入内容確認画面で、公開することによって初めて公開されます。
                </small>
            </p>
        </div>
    </form>

    <script>
        let packageId = {!! old('package_id', null) == null ? $draft->package_id : json_encode(old('package_id')) !!}
        let fearText = {!! json_encode(\Hgs3\Constants\Review\Fear::$data)  !!};
        let goodTags = {!! json_encode($draft->getGoodTags()) !!};
        let veryGoodTags = {!! json_encode($draft->getVeryGoodTags()) !!};
        let badTags = {!! json_encode($draft->getBadTags()) !!};
        let veryBadTags = {!! json_encode($draft->getVeryBadTags()) !!};

        let goodTagBtn = {};
        let veryGoodTagBtn = {};
        let badTagBtn = {};
        let veryBadTagBtn = {};

        $(function (){
            $('.good_tag').each(function (){
                goodTagBtn[$(this).val()] = $(this);
            });
            $('.very_good_tag').each(function (){
                veryGoodTagBtn[$(this).val()] = $(this);
            });
            $('.bad_tag').each(function (){
                badTagBtn[$(this).val()] = $(this);
            });
            $('.bad_tag').each(function (){
                veryBadTagBtn[$(this).val()] = $(this);
            });


            $('#fear').on('input change', function (){
                let val = parseInt($(this).val());
                setFearText(val);
            });

            $('.good_tag').on('change', function (){
                changeVeryBtn('good', $(this).val(), $(this).prop('checked'));
            });

            $('.bad_tag').on('change', function (){
                changeVeryBtn('bad', $(this).val(), $(this).prop('checked'));
            });

            let fear = parseInt($('#fear').val());
            setFearText(fear);

            if (goodTags.length == 0) {
            } else {
                goodTags.forEach(function (val){
                    toggleButton(goodTagBtn[parseInt(val)], true);
                });
            }

            packageId.forEach(function (pkgId){
                toggleButton($('#pkg_' + pkgId), true);
            });
        });

        function changeVeryBtn(target, tagId, checked)
        {
            let check = $('#very_' + target + '_tag_' + tagId);
            let label = $(check.parent().get(0));

            if (checked) {
                label.addClass('btn-outline-success');
                label.removeClass('btn-outline-secondary');
                label.removeClass('disabled');
                toggleButton(check, false);
            } else {
                label.addClass('btn-outline-secondary');
                label.removeClass('btn-outline-success');
                toggleButton(check, false);
                label.addClass('disabled');
            }
        }

        function setFearText(val)
        {
            $('#fear_text').text(fearText[val]);
        }
    </script>

    <style>
        .form-group {
            margin-bottom: 5rem !important;
        }
    </style>

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
