@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト管理') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    @if ($isTakeOver)
        <p>
            「{{ $site->name }}」から引き継ぎます。<br>
            変更がある場合は入力内容を修正して、登録してください。<br>
            下記の入力項目のほかに、登録日時、INカウント、OUTカウントを自動で引き継ぎます。
        </p>
    @endif

    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        {{ csrf_field() }}
        @include('user.siteManage.common.form')

        <div class="form-group">
            <label for="list_banner_upload_flag">一覧用バナー</label>
            <div class="mb-3">
                {{ Form::select('list_banner_upload_flag', [
                    0 => 'なし', 1 => 'URLを指定(直リン)', 2 => 'H.G.N.にアップロード'
                ],
                old('list_banner_upload_flag', $site->list_banner_upload_flag),
                [
                    'class' => 'form-control',
                    'id'    => 'list_banner_select'
                ]) }}
            </div>
            <div class="form-group show_list_banner_url" id="list_banner_url_form" style="{!! display_none(old('list_banner_upload_flag'), 1) !!} }">
                <input type="text" class="form-control{{ invalid($errors, 'list_banner_url') }}" id="list_banner_url" name="list_banner_url" value="{{ old('list_banner_url', $site->list_banner_url) }}">
                @include('common.error', ['formName' => 'list_banner_url'])
                <div>
                    <p class="text-muted">
                        <small>
                            画像のURLを入力してください。<br>
                            幅は最大468pxで、レスポンシブルに拡縮します。
                            高さは最大60pxで、60pxを超えている分はカットされます。<br>
                        </small>
                    </p>
                </div>
                <div class="list-site-banner-outline">
                    <img src="{{ old('list_banner_url') }}" class="img-responsive" id="list_banner_url_thumbnail">
                </div>
            </div>
            <div class="form-group show_list_banner_upload" id="list_banner_upload_form" style="{!! display_none(old('list_banner_upload_flag'), 2) !!} }">
                <input type="file" name="list_banner_upload" id="list_banner_upload" class="form-control-file{{ invalid($errors, 'list_banner_upload') }}" accept="image/*">
                @include('common.error', ['formName' => 'list_banner_upload'])
                <div>
                    <p class="text-muted">
                        <small class="show_list_banner_upload">
                            アップロードする画像ファイルを選択してください。<br>
                            容量は1MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                            幅は最大468pxで、レスポンシブルに拡縮します。
                            高さは最大60pxで、60pxを超えている分はカットされます。<br>
                        </small>
                    </p>
                </div>
                <div class="list-site-banner-outline">
                    <img src="" class="img-responsive" id="list_banner_upload_thumbnail">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="detail_banner_upload_flag">詳細用バナー</label>
            <div class="mb-3">
                {{ Form::select('detail_banner_upload_flag', [
                    0 => 'なし', 1 => 'URLを指定(直リン)', 2 => 'H.G.N.にアップロード'
                ],
                old('detail_banner_upload_flag', $site->detail_banner_upload_flag),
                [
                    'class' => 'form-control',
                    'id'    => 'detail_banner_select'
                ]) }}
            </div>
            <div class="form-group show_detail_banner_url" id="detail_banner_url_form" style="{!! display_none(old('list_banner_upload_flag'), 1) !!} }">
                <input type="text" class="form-control-file{{ invalid($errors, 'detail_banner_url') }}" id="detail_banner_url" name="detail_banner_url" value="{{ old('detail_banner_url', $site->detail_banner_url) }}">
                @include('common.error', ['formName' => 'detail_banner_url'])
                <div>
                    <p class="text-muted">
                        <small>
                            画像のURLを入力してください。<br>
                            画像はレスポンシブルに拡縮します。
                        </small>
                    </p>
                    <div class="detail-site-banner-outline">
                        <img src="{{ old('detail_banner_url') }}" class="img-responsive" id="detail_banner_url_thumbnail">
                    </div>
                </div>
            </div>
            <div class="form-group show_detail_banner_upload" id="detail_banner_upload_form" style="{!! display_none(old('detail_banner_upload_flag'), 2) !!} }">
                <input type="file" name="detail_banner_upload" id="detail_banner_upload" class="form-control-file{{ invalid($errors, 'detail_banner_upload') }}" accept="image/*">
                @include('common.error', ['formName' => 'detail_banner_upload'])
                <div id="detail_banner_text" class="form-group show_detail_banner_upload show_detail_banner_url">
                    <p class="text-muted">
                        <small>
                            アップロードする画像ファイルを選択してください。<br>
                            容量は3MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                            画像はレスポンシブルに拡縮します。
                        </small>
                    </p>
                    <div class="detail-site-banner-outline">
                        <img src="" class="img-responsive" id="detail_banner_upload_thumbnail">
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="hgs2_site_id" value="{{ $hgs2SiteId ?? 0 }}">

        <div class="form-group">
            <div class="row">
                <div class="col-6 text-center">
                    <button class="btn btn-outline-secondary" style="width: 90%;" name="approval_status" value="{{ \Hgs3\Constants\Site\ApprovalStatus::DRAFT }}">下書き保存</button>

                    <p class="text-muted">
                        <small>
                            下書き保存でも、必須項目は入力が必要です。
                        </small>
                    </p>
                </div>
                <div class="col-6 text-center">
                    <button class="btn btn-outline-primary" style="width: 90%;" name="approval_status" value="{{ \Hgs3\Constants\Site\ApprovalStatus::WAIT }}">登録</button>
                </div>
            </div>
        </div>
    </form>
    @include('user.siteManage.common.handleSoftSelect')

    <script>
        $(function (){
            $('#list_banner_select').change(function() {
                let flag = $(this).val();
                changeUploadForm('list', flag);
            });
            $('#detail_banner_select').change(function() {
                let flag = $(this).val();
                changeUploadForm('detail', flag);
            });

            changeUploadForm('list', {{ old('list_banner_upload_flag', $site->list_banner_upload_flag) }});
            changeUploadForm('detail', {{ old('detail_banner_upload_flag', $site->detail_banner_upload_flag) }});

            // アップロードするファイルを選択
            $('#list_banner_upload').change(function() {
                let file = $(this).prop('files')[0];
                if (!changeUploadImage('list', file)) {
                    $(this).val('');
                }
            });
            $('#detail_banner_upload').change(function() {
                let file = $(this).prop('files')[0];
                if (!changeUploadImage('detail', file)) {
                    $(this).val('');
                }
            });

            $('#list_banner_url').change(function (){
                $('#list_banner_url_thumbnail').attr('src', $(this).val());
            });
            $('#detail_banner_url').change(function (){
                $('#detail_banner_url_thumbnail').attr('src', $(this).val());
            });
        });

        function changeUploadForm(target, flag)
        {
            $('.show_' + target + '_banner_url').hide();
            $('.show_' + target + '_banner_upload').hide();
            $('.show_' + target + '_banner_none').hide();

            if (flag == 1) {
                $('.show_' + target + '_banner_url').show();
            } else if (flag == 2) {
                $('.show_' + target + '_banner_upload').show();
            } else {
                $('.show_' + target + '_banner_none').show();
            }
        }

        function changeUploadImage(target, file)
        {
            // 画像以外は処理を停止
            if (!file.type.match('image.*')) {
                // クリア
                $(this).val('');
                $('#' + target + '_banner_upload_thumbnail').attr('src', '');

                alert('選択したファイルは対応していない形式のファイルです。\n別のファイルを選択してください。');

                return false;
            }

            // 画像表示
            let fd = new FileReader();
            fd.onload = function() {
                $('#' + target + '_banner_upload_thumbnail').attr('src', fd.result);
            };
            fd.readAsDataURL(file);

            return true;
        }

    </script>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト管理') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">新規登録</li>
        </ol>
    </nav>
@endsection
