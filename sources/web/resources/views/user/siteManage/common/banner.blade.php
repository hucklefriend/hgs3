{{ csrf_field() }}
<div class="tab-container">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#list_banner" role="tab">一覧用</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#detail_banner" role="tab">紹介画像</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active fade show" id="list_banner" role="tabpanel">
            <div class="form-group">
                <div>
                    <label for="list_banner_upload_flag" class="hgn-label"><i class="far fa-image"></i> 一覧用バナー</label>
                </div>
            </div>
            <div class="form-help">
                <p>
                    一覧表示される画面で表示するバナーです。<br>
                    幅は最大468pxで、レスポンシブルに拡縮します。<br>
                    高さは最大60pxで、60pxを超えている分はカットされます。
                </p>
                <p>
                    URLを指定して直リンクするか、当サイト内にアップロードすることができます。
                </p>
            </div>

            <div class="form-group">
                <div>
                    <label for="list_banner_upload_flag" class="hgn-label"><i class="fas fa-check"></i> どうしますか？</label>
                </div>
                <div class="mt-3 mb-2">
                    <label class="custom-control custom-radio mb-3">
                        <input type="radio" class="custom-control-input" name="list_banner_upload_flag" id="list_banner_upload_flag_0" value="0"{{ checked($listBannerUploadFlag, 0) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">バナーなし</span>
                    </label>

                    <label class="custom-control custom-radio mb-3">
                        <input type="radio" class="custom-control-input" name="list_banner_upload_flag" id="list_banner_upload_flag_1" value="1"{{ checked($listBannerUploadFlag, 1) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">URLを指定する</span>
                    </label>

                    <label class="custom-control custom-radio mb-3">
                        <input type="radio" class="custom-control-input" name="list_banner_upload_flag" id="list_banner_upload_flag_2" value="2"{{ checked($listBannerUploadFlag, 2) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">アップロードする</span>
                    </label>

                    @if (!$isFirst)
                        <label class="custom-control custom-radio mb-3">
                            <input type="radio" class="custom-control-input" name="list_banner_upload_flag" id="list_banner_upload_flag_3" value="3"{{ checked($listBannerUploadFlag, 3) }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">今のまま変えない</span>
                        </label>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="list_banner_none_area">
                <div class="form-help"></div>
            </div>

            <div id="list_banner_link_area">
                <div class="form-group">
                    <label for="list_banner_url" class="hgn-label"><i class="fas fa-edit"></i> 画像のURL</label>
                    <input type="url" class="form-control{{ invalid($errors, 'list_banner_url') }}" id="list_banner_url" name="list_banner_url" value="{{ $listBannerUrl }}">
                    <i class="form-group__bar"></i>
                </div>
                <div class="form-help">
                    <p class="form-text text-muted">
                        <small>
                            <strong>httpsで始まるURLのみ</strong><br>
                            それ以外のURLはご利用いただけませんので、画像をアップロードしてください。
                        </small>
                    </p>
                    <p class="form-text text-muted">
                        <small>サーバーによっては直リンクできない所もありますので、事前にご確認ください。</small>
                    </p>
                </div>
            </div>

            <div id="list_banner_upload_area">

                <div class="form-group">
                    <label for="list_banner_url" class="hgn-label"><i class="fas fa-upload"></i> アップロードするファイル</label>
                    <input type="file" name="list_banner_upload" id="list_banner_upload" class="form-control-file{{ invalid($errors, 'list_banner_upload') }}" accept="image/*">
                    <i class="form-group__bar"></i>
                </div>

                <div class="form-help">
                    <p class="form-text text-muted">
                        <small>容量は1MBまで、形式はjpg/png/gif/bmp/svg</small>
                    </p>
                </div>
            </div>

            <h6>表示サンプル</h6>
            <div class="site-normal">
                <div>
                    <div class="no-banner-site-name list_banner_none">
                        <span class="site_name">{{ $site->name }}</span>
                    </div>

                    <div class="list_banner_exist">
                        <span class="site_name">{{ $site->name }}</span>
                    </div>
                    <div class="list-site-banner-outline list_banner_exist">
                        <span><img src="{{ $listBannerUrl }}" class="img-responsive" id="list_banner_img"></span>
                    </div>
                </div>

                <div class="site-presentation mt-2">{{ e(str_limit($site->presentation, 150)) }}</div>

                <div class="d-flex flex-wrap site-badge my-3">
                    <span class="tag simple">{{ \Hgs3\Constants\Site\MainContents::getText($site->main_contents_id) }}</span>
                    @if ($site->rate > 0)
                        <span class="tag simple">{{ \Hgs3\Constants\Site\Rate::getText($site->rate) }}</span>
                    @endif
                    @if ($site->gender != \Hgs3\Constants\Site\Gender::NONE)
                        <span class="tag simple">{{ \Hgs3\Constants\Site\Gender::getText($site->gender) }}</span>
                    @endif
                </div>

                <div class="d-flex align-content-start flex-wrap site-info">
                    <span><i class="far fa-user"></i> {{ $user->name }}</span>
                    <span><span class="good-icon2"><i class="far fa-thumbs-up"></i></span> {{ number_format($site->good_num) }}</span>
                    <span><i class="fas fa-paw"></i> {{ number_format($site->out_count) }}</span>
                    @if ($site->updated_timestamp > 0)
                        <span><i class="fas fa-redo-alt"></i> {{ format_date($site->updated_timestamp) }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="detail_banner" role="tabpanel">
            <div class="form-group">
                <div>
                    <label for="detail_banner_upload_flag" class="hgn-label"><i class="far fa-image"></i> 紹介画像</label>
                </div>
            </div>
            <div class="form-help">
                <p>
                    紹介ページで表示される画像です。<br>
                    画像はレスポンシブルに拡縮します。<br>
                    一覧用バナーのようにトリムはしていません
                </p>
                <p>
                    URLを指定して直リンクするか、当サイト内にアップロードすることができます。
                </p>
            </div>

            <div class="form-group">
                <div>
                    <label for="detail_banner_upload_flag" class="hgn-label"><i class="fas fa-check"></i> どうしますか？</label>
                </div>
                <div class="mt-3 mb-2">
                    <label class="custom-control custom-radio mb-3">
                        <input type="radio" class="custom-control-input" name="detail_banner_upload_flag" id="detail_banner_upload_flag_0" value="0"{{ checked($detailBannerUploadFlag, 0) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">バナーなし</span>
                    </label>

                    <label class="custom-control custom-radio mb-3">
                        <input type="radio" class="custom-control-input" name="detail_banner_upload_flag" id="detail_banner_upload_flag_1" value="1"{{ checked($detailBannerUploadFlag, 1) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">URLを指定する</span>
                    </label>

                    <label class="custom-control custom-radio mb-3">
                        <input type="radio" class="custom-control-input" name="detail_banner_upload_flag" id="detail_banner_upload_flag_2" value="2"{{ checked($detailBannerUploadFlag, 2) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">アップロードする</span>
                    </label>

                    @if (!$isFirst)
                        <label class="custom-control custom-radio mb-3">
                            <input type="radio" class="custom-control-input" name="detail_banner_upload_flag" id="detail_banner_upload_flag_3" value="3"{{ checked($detailBannerUploadFlag, 3) }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">今のまま変えない</span>
                        </label>
                    @endif
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="detail_banner_none_area">
                <div class="form-help"></div>
            </div>

            <div id="detail_banner_link_area">
                <div class="form-group">
                    <label for="detail_banner_url" class="hgn-label"><i class="fas fa-edit"></i> 画像のURL</label>
                    <input type="url" class="form-control{{ invalid($errors, 'detail_banner_url') }}" id="detail_banner_url" name="detail_banner_url" value="{{ $detailBannerUrl }}">
                    <i class="form-group__bar"></i>
                </div>
                <div class="form-help">
                    <p class="form-text text-muted">
                        <small>
                            <strong>httpsで始まるURLのみ</strong><br>
                            それ以外のURLはご利用いただけませんので、画像をアップロードしてください。
                        </small>
                    </p>
                    <p class="form-text text-muted">
                        <small>サーバーによっては直リンクできない所もありますので、事前にご確認ください。</small>
                    </p>
                </div>
            </div>

            <div id="detail_banner_upload_area">
                <div class="form-group">
                    <label for="detail_banner_url" class="hgn-label"><i class="fas fa-upload"></i> アップロードするファイル</label>
                    <input type="file" name="detail_banner_upload" id="detail_banner_upload" class="form-control-file{{ invalid($errors, 'detail_banner_upload') }}" accept="image/*">
                    <i class="form-group__bar"></i>
                </div>

                <div class="form-help">
                    <p class="form-text text-muted">
                        <small>容量は3MBまで、形式はjpg/png/gif/bmp/svg</small>
                    </p>
                </div>
            </div>

            <h6>表示サンプル</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-hgn">
                        <img class="card-img-top detail_banner_exist" src="{{ $detailBannerUrl }}" id="detail_banner_img">

                        <div class="card-body">
                            <h4 class="card-title">{{ $site->name }}</h4>
                            <div class="mb-3">
                                <span class="tag simple">{{ \Hgs3\Constants\Site\MainContents::getText($site->main_contents_id) }}</span>
                                @if ($site->rate > 0)
                                    <span class="tag simple">{{ \Hgs3\Constants\Site\Rate::getText($site->rate) }}</span>
                                @endif
                                @if ($site->gender != \Hgs3\Constants\Site\Gender::NONE)
                                    <span class="tag simple">{{ \Hgs3\Constants\Site\Gender::getText($site->gender) }}</span>
                                @endif
                            </div>
                            <div class="d-flex align-content-start flex-wrap site-info">
                                <span><i class="far fa-user"></i> {{ $user->name }}</span>
                                <span><span class="favorite-icon"><i class="fas fa-star"></i></span> XXX</span>
                                <span><span class="good-icon"><i class="fas fa-thumbs-up"></i></span> XXX</span>
                                <span><i class="fas fa-paw"></i> XXX</span>
                                @if ($site->updated_timestamp > 0)
                                    <span><i class="fas fa-redo-alt"></i> {{ format_date($site->updated_timestamp) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    let originalListBannerUrl = '{{ $listBannerUrl }}';
    let listBannerUrl = '';
    let listBannerUploadImg = '';

    let originalDetailBannerUrl = '{{ $detailBannerUrl }}';
    let detailBannerUrl = '';
    let detailBannerUploadImg = '';

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

        $('input[name=list_banner_upload_flag]').change(function (){
            changeFlag('list');
        });
        $('input[name=detail_banner_upload_flag]').change(function (){
            changeFlag('detail');
        });

        $('#list_banner_url').change(function (){
            let url = $(this).val();

            if (url.startsWith('https')) {
                listBannerUrl = $(this).val();
            } else {
                listBannerUrl = '';
            }

            $('#list_banner_img').attr('src', listBannerUrl);
        });

        $('#detail_banner_url').change(function (){
            let url = $(this).val();

            if (url.startsWith('https')) {
                detailBannerUrl = $(this).val();
            } else {
                detailBannerUrl = '';
            }

            $('#detail_banner_img').attr('src', detailBannerUrl);
        });

        listBannerUrl = $('#list_banner_url').val();
        detailBannerUrl = $('#detail_banner_url').val();
        changeFlag('list');
        changeFlag('detail');

        $('#for_list').click(function (e){
            if (!$('#for_list').hasClass('active')) {
                $('#for_list').addClass('active');
                $('#for_detail').removeClass('active');
                $('#list_banner').show();
                $('#detail_banner').hide();
            }

            e.preventDefault();
            return false;
        });
        $('#for_detail').click(function (e){
            if (!$('#for_detail').hasClass('active')) {
                $('#for_list').removeClass('active');
                $('#for_detail').addClass('active');
                $('#list_banner').hide();
                $('#detail_banner').show();
            }

            e.preventDefault();
            return false;
        });
    });

    function changeFlag(target)
    {
        let flag = parseInt($('input[name=' + target + '_banner_upload_flag]:checked').val());

        switch (flag) {
            case 0:
                $('.' + target + '_banner_none').show();
                $('.' + target + '_banner_exist').hide();
                $('#' + target + '_banner_none_area').show();
                $('#' + target + '_banner_link_area').hide();
                $('#' + target + '_banner_upload_area').hide();
                break;
            case 1:
                $('.' + target + '_banner_none').hide();
                $('.' + target + '_banner_exist').show();
                $('#' + target + '_banner_none_area').hide();
                $('#' + target + '_banner_link_area').show();
                $('#' + target + '_banner_upload_area').hide();

                $('#' + target + '_banner_img').attr('src', target == 'list' ? listBannerUrl : detailBannerUrl);
                break;
            case 2:
                $('.' + target + '_banner_none').hide();
                $('.' + target + '_banner_exist').show();
                $('#' + target + '_banner_none_area').hide();
                $('#' + target + '_banner_link_area').hide();
                $('#' + target + '_banner_upload_area').show();

                $('#' + target + '_banner_img').attr('src', target == 'list' ? listBannerUploadImg : detailBannerUploadImg);
                break;
            case 3: {
                $('#' + target + '_banner_none_area').show();
                $('#' + target + '_banner_link_area').hide();
                $('#' + target + '_banner_upload_area').hide();

                let imgUrl = target == 'list' ? originalListBannerUrl : originalDetailBannerUrl;

                if (imgUrl.length > 0) {
                    $('#' + target + '_banner_img').attr('src', imgUrl);
                    $('.' + target + '_banner_none').hide();
                    $('.' + target + '_banner_exist').show();
                } else {
                    $('#' + target + '_banner_img').attr('src', '');
                    $('.' + target + '_banner_none').show();
                    $('.' + target + '_banner_exist').hide();
                }
            }

                break;
        }
    }

    function changeUploadImage(target, file)
    {
        if (target == 'list') {
            listBannerUploadImg = '';
        } else {
            detailBannerUploadImg = '';
        }

        // 画像以外は処理を停止
        if (!file.type.match('image.*')) {
            // クリア
            $(this).val('');
            $('#' + target + '_banner_img').attr('src', '');

            alert('選択したファイルは対応していない形式のファイルです。\n別のファイルを選択してください。');

            return false;
        }

        // 容量チェック
        if (target == 'list') {
            if (file.size > 1024 * 1024) {
                // クリア
                $(this).val('');
                $('#' + target + '_banner_img').attr('src', '');

                alert('ファイルの容量が大きすぎます。1MB以内のファイルを選択してください。');
                return false;
            }
        } else {
            if (file.size > 1024 * 1024 * 3) {
                // クリア
                $(this).val('');
                $('#' + target + '_banner_img').attr('src', '');

                alert('ファイルの容量が大きすぎます。3MB以内のファイルを選択してください。');
                return false;
            }
        }

        // 画像表示
        let fd = new FileReader();
        fd.onload = function() {
            if (target == 'list') {
                listBannerUploadImg = fd.result;
                $('#list_banner_img').attr('src', listBannerUploadImg);
            } else {
                detailBannerUploadImg = fd.result;
                $('#detail_banner_img').attr('src', detailBannerUploadImg);
            }
        };
        fd.readAsDataURL(file);

        return true;
    }
</script>