@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h4>{{ $user->name }}さんのアイコン変更</h4>

    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}

        <p>
            アイコン画像に使える形式は、jpg/gif/png/svg/bmpです。<br>
            容量は3MBまで、表示サイズは通常3rem、最大5remです。
        </p>

        <div class="form-group">
            <input type="file" name="icon" id="icon_uploader" class="form-control-file">

            <div class="alert alert-danger" role="alert" id="alert_msg" @if (!$errors->has('icon')) style="display:none;" @endif>
                @if ($errors->has('icon'))
                    アイコンに利用できる画像ファイルを選択してください。
                @endif
            </div>
        </div>

        <div class="row" style="margin-bottom: 10px;">
            <div class="col-sm-5 text-center">
                <div>現在のアイコン</div>
                @include('user.common.icon', ['u' => $user, 'isLarge' => true])
            </div>
            <div class="col-sm-5 text-center">
                <div>選択したアイコン</div>
                <img id="thumbnail" class="img-responsive user-icon-img-large">
                <p id="select_message" class="text-muted">画像ファイルを選択すると<br>ここに表示されます。</p>
                <div style="margin-top: 10px;">
                    <button class="btn btn-info" id="submit_button" style="display:none;">このアイコンにする</button>
                </div>
            </div>
        </div>
    </form>

    @if ($user->icon_upload_flag)
    <form method="POST" style="margin-top: 20px;">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button class="btn btn-warning">アイコンを削除して、初期状態に戻す</button>
    </form>
    @endif
    <script>
        $(function() {
            // アップロードするファイルを選択
            $('#icon_uploader').change(function() {
                let file = $(this).prop('files')[0];

                // 画像以外は処理を停止
                if (! file.type.match('image.*')) {
                    // クリア
                    $(this).val('');
                    $('#thumbnail').attr('src', '');
                    $('#alert_msg').text('画像ファイルを選択してください。');
                    $('#alert_msg').show();
                    $('#select_message').show();
                    $('#submit_button').hide();
                    return;
                }

                $('#select_message').hide();
                $('#alert_msg').hide();
                $('#submit_button').show();

                // 画像表示
                let fd = new FileReader();
                fd.onload = function() {
                    $('#thumbnail').attr('src', fd.result);
                };
                fd.readAsDataURL(file);
            });
        });
    </script>


@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('プロフィール', ['showId' => $user->show_id]) }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">アイコン変更</li>
        </ol>
    </nav>
@endsection