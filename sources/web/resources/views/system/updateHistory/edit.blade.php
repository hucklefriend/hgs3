@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('システム更新履歴更新', ['updateHistory' => $updateHistory->id]) }}">&lt;</a>
@endsection

@section('content')
    <form method="POST" autocomplete="off">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">タイトル</label>
            <input type="text" class="form-control{{ invalid($errors, 'title') }}" id="title" name="title" value="{{ old('title', $updateHistory->title) }}" required maxlength="100">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="detail">詳細</label>
            <textarea name="detail" id="detail" class="form-control{{ invalid($errors, 'detail') }}" required>{{ old('detail', $updateHistory->detail) }}</textarea>
            @include('common.error', ['formName' => 'message'])
        </div>
        <div class="form-group">
            <label for="open_at">更新日時</label>
            <input type="datetime-local" name="update_at" id="update_at" class="form-control{{ invalid($errors, 'update_at') }}" value="{{ old('update_at', format_date_local($updateHistory->update_at)) }}" required max="2100-12-31T23:59">
            @include('common.error', ['formName' => 'update_at'])
        </div>
        <button type="submit" class="btn btn-primary">更新</button>
    </form>
@endsection


@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('システム更新履歴') }}">システム更新履歴</a></li>
            <li class="breadcrumb-item active" aria-current="page">システム更新内容更新</li>
        </ol>
    </nav>
@endsection
