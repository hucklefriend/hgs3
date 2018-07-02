@extends('layouts.app')

@section('title'){{ $user->name }}さんへメッセージを送る@endsection
@section('global_back_link'){{ route('プロフィール', ['showId' => $user->show_id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>メッセージを送る(to {{ $user->name }}さん)</h1>
        </header>

        <form method="POST" action="{{ route('管理人メッセージ送信', ['user' => $user->id]) }}" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="res_id" value="{{ $resId }}">

            <div class="form-group">
                <label for="message" class="hgn-label"><i class="fas fa-edit"></i> メッセージ</label>
                <textarea name="message" id="message" class="form-control textarea-autosize{{ invalid($errors, 'message') }}">{{ old('message') }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                <small>最大文字数：10,000</small>
                @include('common.error', ['formName' => 'message'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">メッセージ送信</button>
            </div>
        </form>
    </div>
@endsection

