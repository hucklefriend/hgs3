<div class="form-group">
    <label for="name">サイト名</label>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $site->name) }}" autocomplete="off">
    @include('common.error', ['formName' => 'name'])
</div>
<div class="form-group">
    <label for="url">URL</label>
    <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $site->url) }}" autocomplete="off">
    @include('common.error', ['formName' => 'url'])
</div>
<div class="form-group">
    <label for="title">取扱いゲーム</label>
    @if ($errors->has('handle_soft'))
        <button type="button" class="btn btn-danger" id="select_handle_soft">ゲームを選択する</button>
    @else
        <button type="button" class="btn btn-default" id="select_handle_soft">ゲームを選択する</button>
    @endif
    <p id="selected_soft"></p>
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

    @foreach (\Hgs3\Constants\Site\MainContents::getData() as $mcId => $mcName)

    <div class="form-check">
        <label class="form-check-label">
            <input type="radio" class="form-check-input" name="main_contents" id="main_contents{{ $loop->index }}" value="{{ $mcId }}"{{ checked($mcId, old('main_contents', $site->main_contents)) }}>
            {{ $mcName }}
        </label>
    </div>

    @endforeach
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
