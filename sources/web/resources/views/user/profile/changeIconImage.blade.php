@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>アイコン画像変更</h1>

    <p>
        アイコン画像に使える形式はjpg/gif/png/svg/bmp、容量は200KBまでです。<br>
        辺の短い方に合わせて、正方形で表示されます。
    </p>

    <form method="POST" action="{{ route('アイコン画像変更処理') }}" enctype="multipart/form-data" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <div class="form-group">
            <input type="file" name="icon" id="icon_uploader" class="form-control-file">

            <div class="alert alert-danger mt-2" role="alert" id="alert_msg" @if (!$errors->has('icon')) style="display:none;" @endif>
                @if ($errors->has('icon'))
                    アイコンに利用できる画像ファイルを選択してください。
                @endif
            </div>
        </div>

        <div id="round_area" style="display:none;">
            <div class="d-flex mb-3">
                <div class="align-self-center p-3">
                    <span class="user-icon align-middle user-icon-large" id="thumbnail"></span>
                </div>
                <div class="align-self-center">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="icon_round_type" id="icon_round_type0" value="{{ \Hgs3\Constants\IconRoundType::NONE }}"  {{ checked(old('icon_round_type'), \Hgs3\Constants\IconRoundType::NONE) }}>
                        <label class="form-check-label" for="icon_round_type0">
                            丸みなし
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="icon_round_type" id="icon_round_type1" value="{{ \Hgs3\Constants\IconRoundType::ROUNDED }}" {{ checked(old('icon_round_type'), \Hgs3\Constants\IconRoundType::ROUNDED) }}>
                        <label class="form-check-label" for="icon_round_type1">
                            丸みあり
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="icon_round_type" id="icon_round_type2" value="{{ \Hgs3\Constants\IconRoundType::CIRCLE }}" {{ checked(old('icon_round_type'), \Hgs3\Constants\IconRoundType::CIRCLE) }}>
                        <label class="form-check-label" for="icon_round_type2">
                            円
                        </label>
                    </div>
                </div>
            </div>
            <div>
                <button class="btn btn-outline-info">変更</button>
            </div>
        </div>
    </form>

    <script>
        let userIcon = null;

        function resetClass()
        {
            userIcon.removeClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::ROUNDED) }}');
            userIcon.removeClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::CIRCLE) }}');
        }

        $(function() {
            userIcon = $('#thumbnail');

            // アップロードするファイルを選択
            $('#icon_uploader').change(function() {
                let file = $(this).prop('files')[0];

                // 画像以外は処理を停止
                if (!file.type.match('image.*')) {
                    // クリア
                    $(this).val('');
                    userIcon.attr('src', '');
                    $('#alert_msg').text('画像ファイルを選択してください。');
                    $('#alert_msg').show();
                    $('#select_message').show();
                    $('#round_area').hide();
                    return;
                }

                // 容量のチェック
                if (file.size > 204800) {
                    // クリア
                    $(this).val('');
                    userIcon.attr('src', '');
                    $('#alert_msg').text('容量が200KBを超えています。');
                    $('#alert_msg').show();
                    $('#select_message').show();
                    $('#round_area').hide();
                    return;
                }

                $('#select_message').hide();
                $('#alert_msg').hide();
                $('#submit_button').show();

                // 画像表示
                let fd = new FileReader();
                fd.onload = function() {
                    userIcon.css('background-image', 'url(' + fd.result + ')');
                };
                fd.readAsDataURL(file);

                $('#round_area').show();
            });

            $('input[name="icon_round_type"]').change(function (){
                resetClass();

                let val = $(this).val();
                if (val == {{ \Hgs3\Constants\IconRoundType::ROUNDED }}) {
                    userIcon.addClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::ROUNDED) }}');
                } else if (val == {{ \Hgs3\Constants\IconRoundType::CIRCLE }}) {
                    userIcon.addClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::CIRCLE) }}');
                }
            });
        });
    </script>


@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('アイコン変更') }}">アイコン変更</a></li>
            <li class="breadcrumb-item active" aria-current="page">アイコン画像変更</li>
        </ol>
    </nav>
@endsection