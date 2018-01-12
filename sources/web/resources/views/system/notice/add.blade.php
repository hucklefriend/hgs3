@extends('layouts.admin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-master">
            <li class="breadcrumb-item"><a href="{{ url2('') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ url2('/admin') }}">管理トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ url2('/system/notice') }}">お知らせ</a></li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ登録</li>
        </ol>
    </nav>

    <form method="POST" autocomplete="off">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">タイトル</label>
            <input type="text" class="form-control{{ invalid($errors, 'title') }}" id="title" name="title" value="{{ old('title') }}" required maxlength="100">
            @include('common.error', ['formName' => 'name'])
        </div>
        <div class="form-group">
            <label for="message">内容</label>
            <textarea name="message" id="message" class="form-control{{ invalid($errors, 'message') }}" required>{{ old('message') }}</textarea>
            @include('common.error', ['formName' => 'message'])
        </div>
        <div class="form-group">
            <label for="name">種別</label>
            @foreach (\Hgs3\Constants\System\NoticeType::getData() as $id => $text)

                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="type" id="type{{ $loop->index }}" value="{{ $id }}"{{ checked($id, old('type', \Hgs3\Constants\System\NoticeType::NORMAL)) }}>
                        {{ $text }}
                    </label>
                </div>

            @endforeach
        </div>
        <div class="form-group">
            <label for="open_at">公開日</label>
            <input type="datetime-local" name="open_at" id="open_at" class="form-control{{ invalid($errors, 'open_at') }}" value="{{ old('open_at') }}" required>
            @include('common.error', ['formName' => 'open_at'])
        </div>
        <div class="form-group">
            <label for="close_at">公開終了日</label>
            <input type="datetime-local" name="close_at" id="close_at" class="form-control{{ invalid($errors, 'close_at') }}" value="{{ old('close_at', '2100/12/31T00:00') }}" required>
            @include('common.error', ['formName' => 'close_at'])
        </div>
        <button type="submit" class="btn btn-primary">登録</button>
    </form>
@endsection