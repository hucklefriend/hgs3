<div class="form-group">
    <label for="name">サイト名</label>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $site->name) }}">
    @include('common.error', ['formName' => 'name'])
</div>
<div class="form-group">
    <label for="url">URL</label>
    <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $site->url) }}">
    @include('common.error', ['formName' => 'url'])
</div>
<div class="form-group">
    <label for="title">取扱いゲーム</label>
    <button type="button" class="btn btn-default" id="select_handle_game">ゲームを選択する</button>
    <p id="selected_game"></p>
    <input type="hidden" name="handle_game" value="{{ old('handle_game', $site->url) }}" id="handle_game">
    @include('common.error', ['formName' => 'handle_game'])
</div>
<fieldset class="form-group">
    <legend>メインコンテンツ</legend>

    @foreach (\Hgs3\Constants\Site\MainContents::getData() as $mcId => $mcName)

    <div class="form-check">
        <label class="form-check-label">
            <input type="radio" class="form-check-input" name="main_contents" id="main_contents{{ $loop->index }}" value="{{ $mcId }}"{{ checked($mcId, old('main_contents', $site->main_contents)) }}>
            {{ $mcName }}
        </label>
    </div>

    @endforeach
</fieldset>
<div class="form-group">
    <label for="presentation">紹介文</label>
    <textarea class="form-control{{ invalid($errors, 'presentation') }}" id="presentation" name="presentation" rows="5">{{ old('presentation', $site->presentation) }}</textarea>
    @include('common.error', ['formName' => 'presentation'])
</div>
<fieldset class="form-group">
    <legend>対象年齢</legend>
    <div class="form-check">
        <label class="form-check-label">
            @php $val = \Hgs3\Constants\Site\Rate::ALL; @endphp
            <input type="radio" class="form-check-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
            {{ \Hgs3\Constants\Site\Rate::getText($val) }}
        </label>
    </div>
    <div class="form-check">
        <label class="form-check-label">
            @php $val = \Hgs3\Constants\Site\Rate::R15; @endphp
            <input type="radio" class="form-check-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
            {{ \Hgs3\Constants\Site\Rate::getText($val) }}
        </label>
    </div>
    <div class="form-check">
        <label class="form-check-label">
            @php $val = \Hgs3\Constants\Site\Rate::R18; @endphp
            <input type="radio" class="form-check-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
            {{ \Hgs3\Constants\Site\Rate::getText($val) }}
        </label>
    </div>
</fieldset>
<fieldset class="form-group">
    <legend>性別傾向</legend>
    <div class="form-check">
        <label class="form-check-label">
            @php $val = \Hgs3\Constants\Site\Gender::NONE; @endphp
            <input type="radio" class="form-check-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
            {{ \Hgs3\Constants\Site\Gender::getText($val) }}
        </label>
    </div>
    <div class="form-check">
        <label class="form-check-label">
            @php $val = \Hgs3\Constants\Site\Gender::MALE; @endphp
            <input type="radio" class="form-check-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
            {{ \Hgs3\Constants\Site\Gender::getText($val) }}
        </label>
    </div>
    <div class="form-check">
        <label class="form-check-label">
            @php $val = \Hgs3\Constants\Site\Gender::FEMALE; @endphp
            <input type="radio" class="form-check-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
            {{ \Hgs3\Constants\Site\Gender::getText($val) }}
        </label>
    </div>
</fieldset>
<div class="form-group">
    <label for="list_banner_upload_flag">一覧用バナー</label>
    <div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="list_banner_upload_flag" id="list_banner_upload_flag_0" value="0"> 不要
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="list_banner_upload_flag" id="list_banner_upload_flag_1" value="1"> URLを指定(直リン)
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="list_banner_upload_flag" id="list_banner_upload_flag_2" value="2"> H.G.N.にアップロード
            </label>
        </div>
    </div>
    <div class="form-group" id="list_banner_url_form" style="{!! display_none(old('list_banner_upload_flag'), 1) !!} }">
        <label for="list_banner_url">一覧用バナーURL</label>

        <input type="text" class="form-control{{ invalid($errors, 'list_banner_url') }}" id="list_banner_url" name="list_banner_url" value="{{ old('list_banner_url', $site->list_banner_url) }}">
        @include('common.error', ['formName' => 'list_banner_url'])
    </div>
    <div class="form-group" id="list_banner_upload_form" style="{!! display_none(old('list_banner_upload_flag'), 2) !!} }">
        <label for="list_banner_upload">一覧用バナーアップロード</label>
        <input type="file" name="list_banner_upload" id="list_banner_upload" class="form-control-file{{ invalid($errors, 'list_banner_upload') }}">
        @include('common.error', ['formName' => 'list_banner_upload'])
    </div>
</div>
<div id="list_banner_text">
    <p class="text-muted">
        <small>
            画像サイズは最大468×60、容量は1MBまで、形式はjpg/png/gif/bmp/svgに対応しています。<br>
            幅に合わせて自動で縮小されますが、高さが60pxを超えている分はカットされます。
        </small>
    </p>
    <div id="" style="max-width: 468px;height: 60px;width: 100%;overflow:hidden;">
        <img src="" class="img-responsive" id="list_banner_thumbnail">
    </div>
</div>

<div class="form-group">
    <label for="detail_banner_url">詳細用バナーURL</label>
    <input type="text" class="form-control{{ invalid($errors, 'detail_banner_url') }}" id="detail_banner_url" name="detail_banner_url" value="{{ old('detail_banner_url', $site->detail_banner_url) }}">
    @include('common.error', ['formName' => 'detail_banner_url'])
</div>

<script>
    $(function (){
        $('input[name="list_banner_upload_flag"]:radio').change(function() {
            let flag = $(this).val();
            $('#list_banner_thumbnail').attr('src', '');
            $('#list_banner_url').val('');
            $('#list_banner_upload').val('');

            if (flag == 1) {
                $('#list_banner_url_form').show();
                $('#list_banner_upload_form').hide();
                $('#list_banner_text').show();
            } else if (flag == 2) {
                $('#list_banner_url_form').hide();
                $('#list_banner_upload_form').show();
                $('#list_banner_text').show();
            } else {
                $('#list_banner_url_form').hide();
                $('#list_banner_upload_form').hide();
                $('#list_banner_text').hide();
            }
        });

        // アップロードするファイルを選択
        $('#list_banner_upload').change(function() {
            let file = $(this).prop('files')[0];

            // 画像以外は処理を停止
            if (! file.type.match('image.*')) {
                // クリア
                $(this).val('');
                $('#list_banner_thumbnail').attr('src', '');
                $('#list_banner_alert_msg').text('画像ファイルを選択してください。');
                $('#list_banner_alert_msg').show();
                return;
            }

            $('#list_banner_select_message').hide();
            $('#list_banner_alert_msg').hide();

            // 画像表示
            let fd = new FileReader();
            fd.onload = function() {
                $('#list_banner_thumbnail').attr('src', fd.result);
            };
            fd.readAsDataURL(file);
        });

        $('#list_banner_url').change(function (){
            $('#list_banner_thumbnail').attr('src', $(this).val());
        });
    });
</script>