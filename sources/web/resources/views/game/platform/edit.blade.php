@extends('layouts.app')

@section('content')
    <form method="POST" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">メーカー</label>
            {{ company_select(old('company_id', $gamePlatform->company_id), false) }}
        </div>
        <div class="form-group">
            <label for="name">名称</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $gamePlatform->name) }}" required maxlength="100" autocomplete="off">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="acronym">略称</label>
            <input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', $gamePlatform->acronym) }}" required maxlength="100" autocomplete="off">
            @include('common.error', ['formName' => 'acronym'])
        </div>
        <div class="form-group">
            <label for="sort_order">表示順</label>
            <input type="number" class="form-control{{ invalid($errors, 'sort_order') }}" id="sort_order" value="{{ old('sort_order', $gamePlatform->sort_order) }}" name="sort_order" autocomplete="off">
            @include('common.error', ['formName' => 'sort_order'])
            <small class="form-text text-muted">発売日の数値を入力(例：2010年1月12日発売なら20100112)</small>
        </div>
        <div class="form-group">
            <label for="url">公式サイトURL</label>
            <input type="text" class="form-control{{ invalid($errors, 'url') }}" id="url" name="url" value="{{ old('url', $gamePlatform->url) }}" maxlength="500" autocomplete="off">
            @include('common.error', ['formName' => 'wikipedia'])
        </div>
        <div class="form-group">
            <label for="wikipedia">Wikipedia URL</label>
            <input type="text" class="form-control{{ invalid($errors, 'wikipedia') }}" id="wikipedia" name="wikipedia" value="{{ old('wikipedia', $gamePlatform->wikipedia) }}" maxlength="500" autocomplete="off">
            @include('common.error', ['formName' => 'wikipedia'])
        </div>
        <button type="submit" class="btn btn-primary">編集</button>
    </form>
@endsection