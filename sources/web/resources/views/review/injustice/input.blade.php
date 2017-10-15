@extends('layouts.app')

@section('content')

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/review/detail') }}/{{ $review->id }}">戻る</a>
    </nav>

    <section>
        <div class="row">
            <div class="col-1 text-center">
                <img src="{{ $pkg->small_image_url }}" class="thumbnail"><br>
                {{ $pkg->name }}
            </div>
            <div class="col-1">{{ $review->point }}</div>
            <div class="col-10"><h5>{{ $review->title }}</h5></div>
        </div>
    </section>

    <p>
        こちらのレビューに対して不正報告を行います。<br>
        どこにどのような問題があるか、記入の上、送信してください。
    </p>

    <form method="POST" onsubmit="return confirm('不正レビューを報告します。よろしいですか？');">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="comment">内容</label>
            <textarea name="comment" class="form-control" id="comment"></textarea>
            <p class="help-block"></p>
        </div>
@if (Auth::check())
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" value="1" name="anonymous">
                匿名で投稿する
            </label>
        </div>
@endif
        <div class="form-group">
            <button class="btn btn-danger">送信</button>
        </div>
    </form>
@endsection