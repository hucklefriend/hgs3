@extends('layouts.app')

@section('title')サイト編集@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('サイト詳細', ['site' => $site->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト編集</h1>
        </header>


        @foreach ($errors->all() as $msg)
            {{ $msg }}<br>
        @endforeach

        <form method="POST" enctype="multipart/form-data" action="{{ route('サイト編集処理', ['site' => $site->id]) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            @include('user.siteManage.common.form')

            @include('user.siteManage.common.handleSoftSelect')

            <div class="form-group">
                <label for="list_banner_upload_flag" class="hgn-label"><i class="fas fa-upload"></i> 一覧用バナー</label>

                @if (!empty($site->list_banner_url))
                    <div>
                        <div class="list-site-banner-outline">
                            <img src="{{ $site->list_banner_url }}" class="img-responsive" id="list_banner_url_thumbnail">
                        </div>
                    </div>
                @endif


                <div class="my-3">
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="list_banner_edit" id="list_banner_edit1" value="1"{{ checked(old('list_banner_edit', 1), 1) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">変更しない</span>
                    </label>

                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="list_banner_edit" id="list_banner_edit2" value="2"{{ checked(old('list_banner_edit', 1), 2) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">変更する</span>
                    </label>

                    @if (!empty($site->list_banner_url))
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="list_banner_edit" id="list_banner_edit3" value="3"{{ checked(old('list_banner_edit', 1), 3) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">削除する</span>
                    </label>
                    @endif
                    <div class="clearfix"></div>
                </div>

                <div class="row" id="list-banner-uploader">
                    <div class="col-md-6">
                        <div class="form-group" id="list_banner_upload_form">
                            <input type="file" name="list_banner_upload" id="list_banner_upload" class="form-control-file{{ invalid($errors, 'list_banner_upload') }}" accept="image/*">
                            @include('common.error', ['formName' => 'list_banner_upload'])
                            <div>
                                <p class="text-muted">
                                    <small class="show_list_banner_upload">
                                        アップロードする画像ファイルを選択してください。<br>
                                        容量は1MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                                        幅は最大468pxで、レスポンシブルに拡縮します。<br>
                                        高さは最大60pxで、60pxを超えている分はカットされます。
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group show_list_banner_upload" id="list_banner_upload_form" style="{!! display_none($listBannerUploadFlag, false) !!}">
                            @if ($listBannerUploadFlag)
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
            <div class="form-help"></div>
            <div class="form-group">
                <label for="list_banner_upload_flag" class="hgn-label"><i class="fas fa-upload"></i> 詳細用バナー</label>

                @if (!empty($site->detail_banner_url))
                    <div class="row">
                        <div class="col-6">
                            <div class="detail-site-banner-outline">
                                <img src="{{ $site->detail_banner_url }}" class="img-responsive rounded">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="my-3">
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="detail_banner_edit" id="detail_banner_edit1" value="1"{{ checked(old('detail_banner_edit', 1), 1) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">変更しない</span>
                    </label>

                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="detail_banner_edit" id="detail_banner_edit2" value="2"{{ checked(old('detail_banner_edit', 1), 2) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">変更する</span>
                    </label>

                    @if (!empty($site->detail_banner_url))
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="detail_banner_edit" id="detail_banner_edit3" value="3"{{ checked(old('detail_banner_edit', 1), 3) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">削除する</span>
                    </label>
                    @endif
                    <div class="clearfix"></div>
                </div>


                <div class="row" id="detail-banner-uploader">
                    <div class="col-md-6">
                        <div class="form-group show_detail_banner_upload" id="detail_banner_upload_form">
                            <input type="file" name="detail_banner_upload" id="detail_banner_upload" class="form-control-file{{ invalid($errors, 'detail_banner_upload') }}" accept="image/*">
                            @include('common.error', ['formName' => 'detail_banner_upload'])
                            <div>
                                <p class="text-muted">
                                    <small class="show_detail_banner_upload">
                                        アップロードする画像ファイルを選択してください。<br>
                                        容量は3MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                                        画像はレスポンシブルに拡縮します。
                                    </small>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group show_detail_banner_upload" id="detail_banner_upload_form">
                            @if ($detailBannerUploadFlag)
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
                                <img src="" class="img-responsive rounded" id="detail_banner_upload_thumbnail">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-help"></div>
            <script>
                let listBannerUploader = null;
                let detailBannerUploader = null;
                $(function (){
                    listBannerUploader = $('#list-banner-uploader');
                    detailBannerUploader = $('#detail-banner-uploader');

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

                    $('input[name="list_banner_edit"]:radio').change(function (){
                        showBannerUploader(parseInt($(this).val()), listBannerUploader);
                    });
                    showBannerUploader(parseInt($('input[name="list_banner_edit"]:radio').val()), listBannerUploader);

                    $('input[name="detail_banner_edit"]:radio').change(function (){
                        showBannerUploader(parseInt($(this).val()), detailBannerUploader);
                    });
                    showBannerUploader(parseInt($('input[name="detail_banner_edit"]:radio').val()), detailBannerUploader);
                });

                function showBannerUploader(val, uploader)
                {
                    if (val == 1) {
                        uploader.hide();
                    } else if (val == 2) {
                        uploader.show();
                    } else if (val == 3) {
                        uploader.hide();
                    }
                }

                function changeUploadImage(target, file)
                {
                    // 画像以外は処理を停止
                    if (!file.type.match('image.*')) {
                        // クリア
                        $(this).val('');
                        $('#' + target + '_banner_upload_thumbnail').attr('src', '');
                        $('#' + target + '_banner_upload').hide();

                        alert('選択したファイルは対応していない形式のファイルです。\n別のファイルを選択してください。');

                        return false;
                    }

                    // 容量チェック
                    if (target == 'list') {
                        if (file.size > 1048576) {
                            alert('1MBを超えています');
                            return false;
                        }
                    } else {
                        if (file.size > 3145728) {
                            alert('3MBを超えています');
                            return false;
                        }
                    }

                    // 画像表示
                    let fd = new FileReader();
                    fd.onload = function() {
                        $('#' + target + '_banner_upload').show();
                        $('#' + target + '_banner_upload_thumbnail').attr('src', fd.result);
                        $('#' + target + '_banner_upload_text').hide();
                    };
                    fd.readAsDataURL(file);

                    return true;
                }

            </script>
            @if ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::OK || $site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::WAIT)
            <div class="form-group mt-5">
                <button class="btn btn-primary" name="draft" value="0">編集</button>
            </div>
            @else
            <div class="form-group mt-5">
                <div class="row">
                    <div class="col-6 text-center">
                        <button class="btn btn-outline-secondary" style="width: 90%;" name="draft" value="1">下書き保存</button>

                        <p class="text-muted">
                            <small>
                                下書き保存でも、必須項目は入力が必要です。
                            </small>
                        </p>
                    </div>
                    <div class="col-6 text-center">
                        <button class="btn btn-outline-primary" style="width: 90%;" name="draft" value="0">登録</button>
                    </div>
                </div>
            </div>
            @endif
        </form>
    </div>
@endsection

@section('outsideContent')
    @include('user.siteManage.common.handleSoftSelect')
@endsection
