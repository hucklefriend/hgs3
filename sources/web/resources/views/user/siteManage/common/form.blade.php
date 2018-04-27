<div class="form-group">
    <label for="name">サイト名</label><span class="badge badge-secondary ml-2">必須</span>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $site->name) }}" placeholder="サイト名">
    <i class="form-group__bar"></i>
</div>
<div class="form-help">
    @include('common.error', ['formName' => 'name'])
</div>

<div class="form-group">
    <label for="url">URL</label><span class="badge badge-secondary ml-2">必須</span>
    <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $site->url) }}" placeholder="サイトのURL">
    <i class="form-group__bar"></i>
</div>
<div class="form-help">
    @include('common.error', ['formName' => 'url'])
</div>

<div class="form-group">
    <label for="title">ゲーム</label><span class="badge badge-secondary ml-2">必須</span>
    <div class="mt-2">
        @if ($errors->has('handle_soft'))
            <button type="button" class="btn btn-outline-danger" id="select_handle_soft">選択する</button>
        @else
            <button type="button" class="btn btn-light" id="select_handle_soft">選択する</button>
        @endif
    </div>
    <div id="selected_soft" class="d-flex flex-wrap"></div>
    <input type="hidden" name="handle_soft" value="{{ old('handle_soft', $site->handle_soft) }}" id="handle_soft">
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
</div>

<div class="form-group">
    <div>
        <label for="main_contents">メインコンテンツ</label><span class="badge badge-secondary ml-2">必須</span>
    </div>
    <div class="mt-3">
    @foreach (\Hgs3\Constants\Site\MainContents::getData() as $val => $name)
        <label class="custom-control custom-radio">
            <input type="radio" class="custom-control-input" name="main_contents" id="main_contents{{ $val }}" value="{{ $val }}"{{ checked(old('main_contents', $site->main_contents_id), $val) }}>
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">{{ $name }}</span>
        </label>
    @endforeach
    </div>
</div>
<div class="form-help">

</div>

<div class="form-group">
    <label for="presentation">紹介文</label>
    <textarea class="form-control textarea-autosize{{ invalid($errors, 'presentation') }}" id="presentation" name="presentation">{{ old('presentation', $site->presentation) }}</textarea>
    <i class="form-group__bar"></i>
</div>
<div class="form-help">
    @include('common.error', ['formName' => 'presentation'])
</div>

<div class="form-group">
    <div>
        <label for="list_banner_upload_flag">対象年齢</label><span class="badge badge-secondary ml-2">必須</span>
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

</div>


<div class="form-group">
    <div>
        <label for="list_banner_upload_flag">性別傾向</label><span class="badge badge-secondary ml-2">必須</span>
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

</div>

