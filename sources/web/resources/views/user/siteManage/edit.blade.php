@extends('layouts.app')

@section('content')

    @foreach ($errors->all() as $msg)
        {{ $msg }}<br>
    @endforeach

    <form method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        @include('user.siteManage.common.form')

        <div class="form-group">
            <label for="list_banner_upload_flag">一覧用バナー</label>
            <div>
                @if (empty($site->list_banner_url))
                    一覧用バナーは登録されていません。
                @else
                    <div class="list-site-banner-outline">
                        <img src="{{ $site->list_banner_url }}" class="img-responsive">
                    </div>
                @endif
            </div>
            <div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="list_banner_upload_flag" id="list_banner_upload_flag_-1" value="-1" {{ checked(old('list_banner_upload_flag', $site->list_banner_upload_flag), -1) }}> 変更しない
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="list_banner_upload_flag" id="list_banner_upload_flag_0" value="0" {{ checked(old('list_banner_upload_flag', $site->list_banner_upload_flag), 0) }}> 削除
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="list_banner_upload_flag" id="list_banner_upload_flag_1" value="1" {{ checked(old('list_banner_upload_flag', $site->list_banner_upload_flag), 1) }}> URLを指定(直リン)
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="list_banner_upload_flag" id="list_banner_upload_flag_2" value="2" {{ checked(old('list_banner_upload_flag', $site->list_banner_upload_flag), 2) }}> 新しくアップロード
                    </label>
                </div>
            </div>
            <div class="form-group show_list_banner_url" id="list_banner_url_form" style="{!! display_none(old('list_banner_upload_flag'), 1) !!} }">
                @php
                $listBannerUrl = $site->list_banner_upload_flag == 1 ? $site->list_banner_url : '';
                @endphp
                <input type="text" class="form-control{{ invalid($errors, 'list_banner_url') }}" id="list_banner_url" name="list_banner_url" value="{{ old('list_banner_url', $listBannerUrl) }}">
                @include('common.error', ['formName' => 'list_banner_url'])
                <div>
                    <p class="text-muted">
                        <small>
                            画像サイズは最大468×60です。<br>
                            幅に合わせて自動で縮小されますが、高さが60pxを超えている分はカットされます。
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
                            画像サイズは最大468×60、容量は3MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                            幅に合わせて自動で縮小されますが、高さが60pxを超えている分はカットされます。<br>
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
            <div>
            @if (empty($site->detail_banner_url))
                詳細用バナーは登録されていません。
            @else
                <div class="detail-site-banner-outline">
                    <img src="{{ $site->detail_banner_url }}" class="img-responsive">
                </div>
            @endif
            </div>
            <div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="detail_banner_upload_flag" id="detail_banner_upload_flag_-1" value="-1" {{ checked(old('detail_banner_upload_flag', $site->detail_banner_upload_flag), -1) }}> 変更しない
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="detail_banner_upload_flag" value="0" {{ checked(old('detail_banner_upload_flag', $site->detail_banner_upload_flag), 0) }}> 削除
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="detail_banner_upload_flag" value="1" {{ checked(old('detail_banner_upload_flag', $site->detail_banner_upload_flag), 1) }}> URLを指定(直リン)
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label">
                        <input class="form-check-input" type="radio" name="detail_banner_upload_flag" value="2" {{ checked(old('detail_banner_upload_flag', $site->detail_banner_upload_flag), 2) }}> 新しくアップロード
                    </label>
                </div>
            </div>
            <div class="form-group show_detail_banner_url" id="detail_banner_url_form" style="{!! display_none(old('list_banner_upload_flag'), 1) !!} }">
                @php
                    $detailBannerUrl = $site->detail_banner_upload_flag == 1 ? $site->detail_banner_url : '';
                @endphp
                <input type="text" class="form-control{{ invalid($errors, 'detail_banner_url') }}" id="detail_banner_url" name="detail_banner_url" value="{{ old('detail_banner_url', $detailBannerUrl) }}">
                @include('common.error', ['formName' => 'detail_banner_url'])
                <div>
                    <p class="text-muted">
                        <small>
                            画像サイズは最大250×400です。<br>
                            幅に合わせて自動で縮小されますが、高さが400pxを超えている分はカットされます。
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
                            画像サイズは最大250×400、容量は3MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
                            幅に合わせて自動で縮小されますが、高さが400pxを超えている分はカットされます。
                        </small>
                    </p>
                    <div class="detail-site-banner-outline">
                        <img src="" class="img-responsive" id="detail_banner_upload_thumbnail">
                    </div>
                </div>
            </div>
        </div>

        @include('user.siteManage.common.handleSoftSelect')

    <script>
        $(function (){
            $('input[name="list_banner_upload_flag"]:radio').change(function() {
                let flag = $(this).val();
                changeUploadForm('list', flag, true);
            });
            $('input[name="detail_banner_upload_flag"]:radio').change(function() {
                let flag = $(this).val();
                changeUploadForm('detail', flag, true);
            });

            changeUploadForm('list', {{ old('list_banner_upload_flag', $site->list_banner_upload_flag) }}, false);
            changeUploadForm('detail', {{ old('detail_banner_upload_flag', $site->detail_banner_upload_flag) }}, false);

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

        /**
         *
         *
         * @param target
         * @param file
         * @param isReset
         * @returns {boolean}
         */
        function changeUploadImage(target, file, isReset)
        {
            if (isReset) {
                $('#' + target + '_banner_url').val('');
                $('#' + target + '_banner_upload').val('');
                $('#' + target + '_banner_url_thumbnail').attr('src', '');
                $('#' + target + '_banner_upload_thumbnail').attr('src', '');
            }

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

        <div class="form-group">
            <button class="btn btn-primary">編集</button>
        </div>
    </form>

@endsection

@section('outsideContent')
    @include('user.siteManage.common.handleSoftSelect')
@endsection