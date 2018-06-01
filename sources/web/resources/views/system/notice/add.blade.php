@extends('layouts.app')

@section('title')お知らせ登録@endsection
@section('global_back_link'){{ route('お知らせ') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>お知らせ登録</h1>
        </header>


        <form method="POST" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="title" class="hgn-label"><i class="fas fa-edit"></i> タイトル</label>
                <input type="text" class="form-control{{ invalid($errors, 'title') }}" id="title" name="title" value="{{ old('title') }}" required maxlength="100">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'name'])
            </div>


            <div class="form-group">
                <label for="message" class="hgn-label"><i class="fas fa-edit"></i> 内容</label>
                <textarea name="message" id="message" class="form-control textarea-autosize{{ invalid($errors, 'message') }}" required>{{ old('message') }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'message'])
            </div>

            <div class="form-group">
                <div>
                    <label for="name" class="hgn-label"><i class="fas fa-check"></i> 種別</label>
                </div>

                @foreach (\Hgs3\Constants\System\NoticeType::getData() as $id => $text)
                    <label class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" name="type" id="type{{ $loop->index }}" value="{{ $id }}"{{ checked($id, old('type', \Hgs3\Constants\System\NoticeType::NORMAL)) }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">{{ $text }}</span>
                    </label>
                @endforeach
            </div>
            <div class="form-help"></div>

            <div class="form-group">
                <label for="open_at" class="hgn-label"><i class="far fa-calendar-alt"></i> 公開日</label>
                <input type="datetime-local" name="open_at" id="open_at" class="form-control{{ invalid($errors, 'open_at') }}" value="{{ old('open_at', date('Y-m-d').'T'.date('H:00')) }}" required max="2100-12-31T23:59">
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'open_at'])
            </div>

            <div class="form-group">
                <label for="close_at" class="hgn-label"><i class="far fa-calendar-alt"></i> 公開終了日</label>
                <input type="datetime-local" name="close_at" id="close_at" class="form-control{{ invalid($errors, 'close_at') }}" value="{{ old('close_at', '2100-12-31T00:00') }}" required max="2100-12-31T23:59">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'close_at'])
            </div>

            <div class="form-group">
                <label for="top_start_at" class="hgn-label"><i class="far fa-calendar-alt"></i> トップ表示開始日</label>
                <input type="datetime-local" name="top_start_at" id="top_start_at" class="form-control{{ invalid($errors, 'top_start_at') }}" value="{{ old('top_start_at', date('Y-m-d').'T'.date('H:00')) }}" required max="2100-12-31T23:59">
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'open_at'])
            </div>

            <div class="form-group">
                <label for="top_end_at" class="hgn-label"><i class="far fa-calendar-alt"></i> トップ表示終了日</label>
                <input type="datetime-local" name="top_end_at" id="top_end_at" class="form-control{{ invalid($errors, 'top_end_at') }}" value="{{ old('top_end_at', '2100-12-31T00:00') }}" required max="2100-12-31T23:59">
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'top_end_at'])
            </div>

            <button type="submit" class="btn btn-primary">登録</button>
        </form>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('お知らせ') }}">お知らせ</a></li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ登録</li>
        </ol>
    </nav>
@endsection
