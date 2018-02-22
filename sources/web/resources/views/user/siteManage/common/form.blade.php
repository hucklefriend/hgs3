<div class="form-group">
    <label for="name">サイト名</label><span class="badge badge-info ml-2">必須</span>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $site->name) }}" placeholder="サイト名">
    @include('common.error', ['formName' => 'name'])
</div>
<div class="form-group">
    <label for="url">URL</label><span class="badge badge-info ml-2">必須</span>
    <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $site->url) }}" placeholder="サイトのURL">
    @include('common.error', ['formName' => 'url'])
</div>
<div class="form-group">
    <div class="d-flex mb-2">
        <div class="align-self-center">
            <label for="title">ゲーム</label><span class="badge badge-info ml-2">必須</span>
        </div>
        <div class="ml-3">
    @if ($errors->has('handle_soft'))
            <button type="button" class="btn btn-sm btn-outline-danger" id="select_handle_soft">選択する</button>
    @else
            <button type="button" class="btn btn-sm btn-outline-info" id="select_handle_soft">選択する</button>
        </div>
    @endif
    </div>
    <div id="selected_soft" class="d-flex flex-wrap"></div>
    <input type="hidden" name="handle_soft" value="{{ old('handle_soft', $site->handle_soft) }}" id="handle_soft">
    @if ($errors->has('handle_soft'))
        <p class="text-danger">
            <small>
            @foreach ($errors->get('handle_soft') as $msg)
                {{ $msg }}
                @if (!$loop->last)
                    <br>
                @endif
            @endforeach
            </small>
        </p>
    @endif
</div>
<div class="form-group">
    <label for="main_contents">メインコンテンツ</label>
    {{ Form::select('main_contents', \Hgs3\Constants\Site\MainContents::getData(), old('main_contents', $site->main_contents_id), ['class' => 'form-control']) }}
</div>
<div class="form-group">
    <label for="presentation">紹介文</label>
    <textarea class="form-control{{ invalid($errors, 'presentation') }}" id="presentation" name="presentation" rows="5">{{ old('presentation', $site->presentation) }}</textarea>
    @include('common.error', ['formName' => 'presentation'])
</div>
<div class="form-group">
    <label for="list_banner_upload_flag">対象年齢</label>
    <div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                @php $val = \Hgs3\Constants\Site\Rate::ALL; @endphp
                <input type="radio" class="form-check-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
                {{ \Hgs3\Constants\Site\Rate::getText($val) }}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                @php $val = \Hgs3\Constants\Site\Rate::R15; @endphp
                <input type="radio" class="form-check-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
                {{ \Hgs3\Constants\Site\Rate::getText($val) }}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                @php $val = \Hgs3\Constants\Site\Rate::R18; @endphp
                <input type="radio" class="form-check-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
                {{ \Hgs3\Constants\Site\Rate::getText($val) }}
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="list_banner_upload_flag">性別傾向</label>
    <div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                @php $val = \Hgs3\Constants\Site\Gender::NONE; @endphp
                <input type="radio" class="form-check-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
                {{ \Hgs3\Constants\Site\Gender::getText($val) }}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                @php $val = \Hgs3\Constants\Site\Gender::MALE; @endphp
                <input type="radio" class="form-check-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
                {{ \Hgs3\Constants\Site\Gender::getText($val) }}
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                @php $val = \Hgs3\Constants\Site\Gender::FEMALE; @endphp
                <input type="radio" class="form-check-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
                {{ \Hgs3\Constants\Site\Gender::getText($val) }}
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="list_banner_upload_flag">一覧用バナー</label>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::select('list_banner_upload_flag', $bannerSelect, $listBannerUploadFlag,
                [
                    'class' => 'form-control',
                    'id'    => 'list_banner_select'
                ]) }}
            </div>
            <div class="form-group show_list_banner_url" id="list_banner_url_form" style="{!! display_none($listBannerUploadFlag, 1) !!} }">
                <input type="text" class="form-control{{ invalid($errors, 'list_banner_url') }}" id="list_banner_url" name="list_banner_url" value="{{ old('list_banner_url') }}">
                @include('common.error', ['formName' => 'list_banner_url'])
                <div>
                    <p class="text-muted">
                        <small>
                            画像のURLを入力してください。<br>
                            幅は最大468pxで、レスポンシブルに拡縮します。<br>
                            高さは最大60pxで、60pxを超えている分はカットされます。<br>
                        </small>
                    </p>
                </div>
            </div>
            <div class="form-group show_list_banner_upload" id="list_banner_upload_form" style="{!! display_none($listBannerUploadFlag, 2) !!} }">
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
            <div class="form-group show_list_banner_url" style="{!! display_none($listBannerUploadFlag, 1) !!}">
                <p class="text-muted" id="list_banner_url_text" @if (!empty(old('list_banner_url', ''))) style="display:none;" @endif >
                    <small>
                        画像のURLを入力すると、ここに画像が表示されます。
                    </small>
                </p>
                <div class="list-site-banner-outline">
                    <img src="{{ old('list_banner_url', '') }}" class="img-responsive" id="list_banner_url_thumbnail">
                </div>
            </div>
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
    <label for="detail_banner_upload_flag">詳細用バナー</label>
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                {{ Form::select('detail_banner_upload_flag', $bannerSelect, $detailBannerUploadFlag,
                [
                    'class' => 'form-control',
                    'id'    => 'detail_banner_select'
                ]) }}
            </div>
            <div class="form-group show_detail_banner_url" id="detail_banner_url_form" style="{!! display_none($detailBannerUploadFlag, 1) !!} }">
                <input type="text" class="form-control{{ invalid($errors, 'detail_banner_url') }}" id="detail_banner_url" name="detail_banner_url" value="{{ old('detail_banner_url') }}">
                @include('common.error', ['formName' => 'detail_banner_url'])
                <div>
                    <p class="text-muted">
                        <small>
                            画像のURLを入力してください。<br>
                            画像はレスポンシブルに拡縮します。
                        </small>
                    </p>
                </div>
            </div>
            <div class="form-group show_detail_banner_upload" id="detail_banner_upload_form" style="{!! display_none($detailBannerUploadFlag, 2) !!} }">
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
            <div class="form-group show_detail_banner_url" style="{!! display_none($detailBannerUploadFlag, 1) !!}">
                <p class="text-muted" id="detail_banner_url_text" @if (!empty(old('detail_banner_url', ''))) style="display:none;" @endif >
                    <small>
                        画像のURLを入力すると、ここに画像が表示されます。
                    </small>
                </p>
                <div class="detail-site-banner-outline rounded">
                    <img src="{{ old('detail_banner_url', '') }}" class="img-responsive" id="detail_banner_url_thumbnail">
                </div>
            </div>
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
            let url = $(this).val();

            if (url.length == 0) {
                $('#list_banner_url_thumbnail').attr('src', '');
                $('#list_banner_url_text').show();
            } else {
                $('#list_banner_url_thumbnail').attr('src', $(this).val());
                $('#list_banner_url_text').hide();
            }
        });
        $('#detail_banner_url').change(function (){
            let url = $(this).val();

            if (url.length == 0) {
                $('#detail_banner_url_thumbnail').attr('src', '');
                $('#detail_banner_url_text').show();
            } else {
                $('#detail_banner_url_thumbnail').attr('src', $(this).val());
                $('#detail_banner_url_text').hide();
            }
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