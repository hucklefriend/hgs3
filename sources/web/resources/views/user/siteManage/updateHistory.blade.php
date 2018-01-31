@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト詳細', ['site' => $site->id]) }}">&lt;</a>
@endsection

@section('content')
    <form method="POST" autocomplete="off">
        {{ csrf_field() }}

        @if ($isEdit)
        {{ method_field('PATCH') }}
        @else
        @endif

        <div class="form-group">
            <label for="name">更新日</label>
            <input type="date" class="form-control{{ invalid($errors, 'site_updated_at') }}" id="site_updated_at" name="site_updated_at" value="{{ old('site_updated_at', $updateHistory->site_updated_at) }}">
            @include('common.error', ['formName' => 'site_updated_at'])
        </div>
        <div class="form-group">
            <label for="presentation">更新内容</label>
            <textarea class="form-control{{ invalid($errors, 'detail') }}" id="detail" name="detail" rows="5">{{ old('detail', $updateHistory->detail) }}</textarea>
            @include('common.error', ['formName' => 'detail'])
            <p class="help-block">最大500文字まで</p>
        </div>

        <div class="form-group">
            <button class="btn">編集</button>
        </div>
    </form>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト詳細', ['site' => $site->id]) }}">サイト詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">更新履歴登録</li>
        </ol>
    </nav>
@endsection