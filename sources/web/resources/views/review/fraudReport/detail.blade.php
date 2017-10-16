@extends('layouts.app')

@section('content')

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/review/detail') }}/{{ $review->id }}">レビューに戻る</a>
    </nav>

    <section>
        <div class="row">
            <div class="col-1 text-center">
                <img src="{{ $pkg->small_image_url }}" class="thumbnail"><br>
                <a href="{{ url('game/review/detail') }}/{{ $review->id }}">{{ $pkg->name }}</a>
            </div>
            <div class="col-1">{{ $review->point }}</div>
            <div class="col-10"><h5>{{ $review->title }}</h5></div>
        </div>
    </section>

    <section>
        <div class="row">
            <div class="col-2">報告日時</div>
            <div class="col-2">{{ $ir->created_at }}</div>
            <div class="col-2">報告者</div>
            <div class="col-2">
@if ($reporter != null)
                <a href="{{ url('user') }}/{{ $reporter->id }}">{{ $reporter->name }}</a>
@else
                匿名
@endif
            </div>
            <div class="col-2">対応状況</div>
            <div class="col-2">{{ \Hgs3\Constants\InjusticeStatus::getText($ir->status) }}</div>
        </div>
        <pre>
            {{ $ir->comment }}
        </pre>
    </section>

@foreach ($comments as $comment)
    <div class="row">
        <div class="col-2">
            <p>
            @if ($comment->user_id == null)
                匿名
            @else
                <a href="{{ url('user') }}/{{ $reporter->id }}">{{ $reporter->name }}</a>
            @endif
            </p>
            <p>{{ $comment->created_at }}</p>
        </div>
        <div class="col-10">
            <pre>{{ $comment->comment }}</pre>
        </div>
    </div>
@endforeach
    {{ $comments->links() }}

    <form method="POST" action="{{ url('game/injustice_review/comment') }}/{{ $review->id }}">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="comment">コメント</label>
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
            <button class="btn btn-danger">投稿</button>
        </div>
    </form>
@endsection
