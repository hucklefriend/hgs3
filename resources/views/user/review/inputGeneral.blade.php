@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'review']) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿</p>
        </header>

        <form method="POST" action="{{ route('レビュー総評保存', ['soft' => $soft->id]) }}" autocomplete="off">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="general_comment" class="hgn-label"><i class="fas fa-edit"></i> 総評</label>
                <p class="text-muted">
                    総評を記入してください。
                </p>
                <textarea name="general_comment" id="general_comment" class="form-control textarea-autosize{{ invalid($errors, 'general_comment') }}">{{ old('general_comment', $draft->general_comment) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                <small>最大文字数：10,000</small>
                @include('common.error', ['formName' => 'general_comment'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">総評を保存</button>
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
@endsection
