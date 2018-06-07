@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ route('レビュー投稿確認', ['soft' => $soft->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿　怖さ編集</p>
        </header>

        <form method="POST" action="{{ route('レビュー怖さ保存', ['soft' => $soft->id]) }}" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="fear" class="hgn-label">😱 怖さ</label>
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
                <label for="fear_comment" class="hgn-label"><i class="fas fa-edit"></i> 怖さにコメント</label>
                <p class="text-muted">
                    怖さについて、言いたいことがあれば記入してください。
                </p>
                <textarea name="fear_comment" id="fear_comment" class="form-control textarea-autosize{{ invalid($errors, 'fear_comment') }}">{{ old('fear_comment', $draft->fear_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                <small>最大文字数：10,000</small>
                @include('common.error', ['formName' => 'fear_comment'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">怖さを保存</button>
            </div>
        </form>
    </div>
    <script>
        let fearText = {!! json_encode(\Hgs3\Constants\Review\Fear::$textWithPoint)  !!};
        let fear = null;
        $(function () {
            fear = $('#fear');
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
        });

        function setFearText()
        {
            let val = $('#fear').val();
            $('#fear_text').text(fearText[val]);
        }
    </script>
@endsection
