<div class="form-group">
    <label for="name" class="hgn-label"><i class="fas fa-edit"></i> サイト名</label>
    <span class="badge badge-secondary ml-2">必須</span>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $site->name) }}">
    <i class="form-group__bar"></i>
</div>
<div class="form-help">
    @include('common.error', ['formName' => 'name'])
    <p class="form-text text-muted">
        <small>最大文字数：100</small>
    </p>
</div>

<div class="form-group">
    <label for="url" class="hgn-label"><i class="fas fa-edit"></i> URL</label>
    <span class="badge badge-secondary ml-2">必須</span>
    <input type="url" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $site->url) }}">
    <i class="form-group__bar"></i>
</div>
<div class="form-help">
    @include('common.error', ['formName' => 'url'])
</div>

<div class="form-group">
    <label for="title" class="hgn-label"><i class="fas fa-edit"></i> ゲーム</label>
    <span class="badge badge-secondary ml-2">必須</span>
    <div class="mt-2">
        @if ($errors->has('handle_soft'))
            <button type="button" class="btn btn-outline-danger" id="select_handle_soft">選択する</button>
        @else
            <button type="button" class="btn btn-light" id="select_handle_soft">選択する</button>
        @endif
    </div>
    <div id="selected_soft" class="d-flex flex-wrap mt-3"></div>
    @php
    $handleSoft = old('handle_soft', $site->handle_soft);
    if (is_array($handleSoft)) {
        $handleSoft = implode(',', $handleSoft);
    }

    @endphp
    <input type="hidden" name="handle_soft" value="{{ $handleSoft }}" id="handle_soft">
</div>
<div class="form-help">
    @if ($errors->has('handle_soft'))
        <p class="invalid-feedback">
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
    <p class="form-text text-muted">
        <small>サイト内で扱っているゲームを選択してください。</small>
    </p>
</div>

<div class="form-group">
    <div>
        <label for="main_contents" class="hgn-label"><i class="fas fa-check"></i> メインコンテンツ</label>
        <span class="badge badge-secondary ml-2">必須</span>
    </div>
    <div class="mt-3">
    @foreach (\Hgs3\Constants\Site\MainContents::getData() as $val => $name)
        <label class="custom-control custom-radio mb-2">
            <input type="radio" class="custom-control-input" name="main_contents" id="main_contents{{ $val }}" value="{{ $val }}"{{ checked(old('main_contents', $site->main_contents_id), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ $name }}</span>
        </label>
    @endforeach
    </div>
</div>
<div class="form-help">
    <p class="form-text text-muted">
        <small>
            サイト内で一番メインに扱っているコンテンツを1つだけ選択してください。<br>
            複数あるかもしれませんが、その中でも中心となるものを1つだけでお願いします。
        </small>
    </p>
</div>

<div class="form-group">
    <label for="presentation" class="hgn-label"><i class="fas fa-edit"></i> 紹介文</label>
    <textarea class="form-control textarea-autosize{{ invalid($errors, 'presentation') }}" id="presentation" name="presentation">{{ old('presentation', $site->presentation) }}</textarea>
    <i class="form-group__bar"></i>
</div>
<div class="form-help">
    @include('common.error', ['formName' => 'presentation'])
    <p class="form-text text-muted">
        <small>
            最大文字数：1000<br>
            サイトでやっていることなど、サイトの紹介文を記入してください。
        </small>
    </p>
</div>

<div class="form-group">
    <div>
        <label for="list_banner_upload_flag" class="hgn-label"><i class="fas fa-check"></i> 対象年齢</label><span class="badge badge-secondary ml-2">必須</span>
    </div>
    <div class="mt-3">
        <label class="custom-control custom-radio">
            @php $val = \Hgs3\Constants\Site\Rate::ALL; @endphp
            <input type="radio" class="custom-control-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ \Hgs3\Constants\Site\Rate::getText($val) }}</span>
        </label>

        <label class="custom-control custom-radio">
            @php $val = \Hgs3\Constants\Site\Rate::R15; @endphp
            <input type="radio" class="custom-control-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ \Hgs3\Constants\Site\Rate::getText($val) }}</span>
        </label>

        <label class="custom-control custom-radio">
            @php $val = \Hgs3\Constants\Site\Rate::R18; @endphp
            <input type="radio" class="custom-control-input" name="rate" id="rate{{ $val }}" value="{{ $val }}"{{ checked(old('rate', $site->rate), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ \Hgs3\Constants\Site\Rate::getText($val) }}</span>
        </label>
        <div class="clearfix"></div>
    </div>
</div>
<div class="form-help">
    <p class="form-text text-muted">
        <small>年齢制限コンテンツを扱っている場合は選択してください。</small>
    </p>
</div>


<div class="form-group">
    <div>
        <label for="list_banner_upload_flag" class="hgn-label"><i class="fas fa-check"></i> 性別傾向</label><span class="badge badge-secondary ml-2">必須</span>
    </div>
    <div class="mt-3">
        <label class="custom-control custom-radio">
            @php $val = \Hgs3\Constants\Site\Gender::NONE; @endphp
            <input type="radio" class="custom-control-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ \Hgs3\Constants\Site\Gender::getText($val) }}</span>
        </label>

        <label class="custom-control custom-radio">
            @php $val = \Hgs3\Constants\Site\Gender::MALE; @endphp
            <input type="radio" class="custom-control-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ \Hgs3\Constants\Site\Gender::getText($val) }}</span>
        </label>

        <label class="custom-control custom-radio">
            @php $val = \Hgs3\Constants\Site\Gender::FEMALE; @endphp
            <input type="radio" class="custom-control-input" name="gender" id="gender{{ $val }}" value="{{ $val }}"{{ checked(old('gender', $site->gender), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ \Hgs3\Constants\Site\Gender::getText($val) }}</span>
        </label>
        <div class="clearfix"></div>
    </div>
</div>
<div class="form-help">
    <p class="form-text text-muted">
        <small>コンテンツに性別の傾向がある場合は選択してください。</small>
    </p>
</div>

