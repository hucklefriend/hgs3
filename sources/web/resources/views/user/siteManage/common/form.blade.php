<div class="form-group">
    <label for="name">サイト名</label>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $site->name) }}" placeholder="サイト名">
    @include('common.error', ['formName' => 'name'])
</div>
<div class="form-group">
    <label for="url">URL</label>
    <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $site->url) }}" placeholder="サイトのURL">
    @include('common.error', ['formName' => 'url'])
</div>
<div class="form-group">
    <label for="open_type">公開範囲</label>
    @foreach (\Hgs3\Constants\Site\OpenType::getData() as $openType => $openTypeText)
        <div class="form-check">
            <label class="form-check-label">
                <input type="radio" class="form-check-input" name="open_type" id="open_type{{ $loop->index }}" value="{{ $openType }}"{{ checked($openType, old('open_type', $site->open_type)) }}>
                {{ $openTypeText }}
            </label>
        </div>
    @endforeach
    <small class="form-text text-danger">
        公開範囲は現在実装していません。設定しても、常に全体に公開されます。
    </small>
</div>
<div class="form-group">
    <label for="title">ゲーム</label>
    @if ($errors->has('handle_soft'))
        <button type="button" class="btn btn-sm btn-outline-danger ml-3" id="select_handle_soft">選択する</button>
    @else
        <button type="button" class="btn btn-sm btn-outline-info ml-3" id="select_handle_soft">選択する</button>
    @endif
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
