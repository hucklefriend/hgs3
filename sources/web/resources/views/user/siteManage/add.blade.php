@extends('layouts.app')

@section('title')サイト登録@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイト管理') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト登録</h1>
        </header>

        <form method="POST" action="{{ route('サイト登録処理') }}" enctype="multipart/form-data" autocomplete="off">
        {{ csrf_field() }}
        @include('user.siteManage.common.form')

        <div class="form-group">
            <label for="list_banner_upload_flag" class="hgn-label"><i class="fas fa-upload"></i> 一覧用バナー</label>

            @if ($site->list_banner_url)
                <div>
                    <div class="list-site-banner-outline">
                        <img src="{{ $site->list_banner_url }}" class="img-responsive" id="list_banner_url_thumbnail">
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" id="list_banner_upload_form">
                        <input type="file" name="list_banner_upload" id="list_banner_upload" class="form-control-file{{ invalid($errors, 'list_banner_upload') }}" accept="image/*">
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help mt-2">
                        @include('common.error', ['formName' => 'list_banner_upload'])
                        <p class="text-muted">
                            <small>
                                アップロードする画像ファイルを選択してください。<br>
                                容量は1MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                                幅は最大468pxで、レスポンシブルに拡縮します。<br>
                                高さは最大60pxで、60pxを超えている分はカットされます。
                            </small>
                        </p>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group show_list_banner_upload" id="list_banner_upload_form" style="{!! display_none($listBannerUploadFlag, 2) !!} }">
                        @if ($listBannerUploadFlag == 2)
                            <p class="text-danger" id="list_banner_upload_text">
                                <small>
                                    もう一度画像ファイルを選択してください。
                                </small>
                            </p>
                        @else
                            <p class="text-muted" id="list_banner_upload_text">
                                <small>
                                    画像ファイルを選択すると、ここに画像が表示されます。
                                </small>
                            </p>
                        @endif
                        <div class="list-site-banner-outline">
                            <img src="" class="img-responsive" id="list_banner_upload_thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="detail_banner_upload_flag" class="hgn-label"><i class="fas fa-upload"></i> 詳細用バナー</label>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group show_detail_banner_upload" id="detail_banner_upload_form">
                        <input type="file" name="detail_banner_upload" id="detail_banner_upload" class="form-control-file{{ invalid($errors, 'detail_banner_upload') }}" accept="image/*">
                    </div>
                    <div class="form-help mt-2">
                        @include('common.error', ['formName' => 'detail_banner_upload'])
                        <p class="text-muted">
                            <small>
                                アップロードする画像ファイルを選択してください。<br>
                                容量は3MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                                画像はレスポンシブルに拡縮します。
                            </small>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group show_detail_banner_upload" id="detail_banner_upload_form" style="{!! display_none($detailBannerUploadFlag, 2) !!} }">
                        @if ($detailBannerUploadFlag == 2)
                            <p class="text-danger" id="detail_banner_upload_text">
                                <small>
                                    もう一度画像ファイルを選択してください。
                                </small>
                            </p>
                        @else
                            <p class="text-muted" id="detail_banner_upload_text">
                                <small>
                                    画像ファイルを選択すると、ここに画像が表示されます。
                                </small>
                            </p>
                        @endif
                        <div class="detail-site-banner-outline rounded">
                            <img src="" class="img-responsive" id="detail_banner_upload_thumbnail">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function (){
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
            });

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

                // 容量チェック
                if (target == 'list') {

                } else {

                }

                // 画像表示
                let fd = new FileReader();
                fd.onload = function() {
                    $('#' + target + '_banner_upload_thumbnail').attr('src', fd.result);
                    $('#' + target + '_banner_upload_text').hide();
                };
                fd.readAsDataURL(file);

                return true;
            }

        </script>
        <input type="hidden" name="hgs2_site_id" value="{{ $hgs2SiteId ?? 0 }}">

        <div class="form-group">
            <div class="row">
                <div class="col-6 text-center">
                    <button class="btn btn-light" style="width: 90%;" name="draft" value="1">下書き保存</button>

                    <p class="text-muted mt-2">
                        下書き保存でも、必須項目は入力が必要です。
                    </p>
                </div>
                <div class="col-6 text-center">
                    <button class="btn btn-primary" style="width: 90%;" name="draft" value="0">登録</button>
                </div>
            </div>
        </div>
    </form>

        @include('user.siteManage.common.handleSoftSelect')

    </div>
@endsection
