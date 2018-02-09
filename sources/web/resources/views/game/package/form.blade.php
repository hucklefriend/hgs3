<div class="form-group">
    <label for="name">名称</label>
    <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $package->name) }}">
    @include('common.error', ['formName' => 'name'])
</div>

<div class="form-group">
    <label for="phonetic">プラットフォーム</label>
    {{ platform_select(old('platform_id', $package->platform_id)) }}
</div>

<div class="form-group">
    <label for="company_id">メーカー</label>
    {{ company_select(old('company_id', $package->company_id), true) }}
</div>

<div class="form-group">
    <label for="url">公式サイト</label>
    <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $package->url) }}">
    @include('common.error', ['formName' => 'url'])
</div>

<div class="form-group">
    <label for="release_at">発売日</label>
    <input type="text" class="form-control{{ invalid($errors, 'release_at') }}" id="release_at" name="release_at" value="{{ old('release_at', $package->release_at) }}">
    @include('common.error', ['formName' => 'release_at'])
</div>

<div class="form-group">
    <label for="release_int">発売日(数値)</label>
    <input type="text" class="form-control{{ invalid($errors, 'release_int') }}" id="release_int" name="release_int" value="{{ old('release_int', $package->release_int) }}">
    @include('common.error', ['formName' => 'release_int'])
</div>

<div class="form-group">
    <label for="asin">ASIN</label>
    <input type="text" class="form-control{{ invalid($errors, 'asin') }}" id="asin" name="asin" value="{{ old('asin', $package->asin) }}">
    @include('common.error', ['formName' => 'asin'])
</div>
