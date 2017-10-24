<div class="form-group">
    <label for="name">サイト名</label>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $site->name) }}">
    @include('common.error', ['formName' => 'name'])
</div>
<div class="form-group">
    <label for="url">URL</label>
    <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('name', $site->url) }}">
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