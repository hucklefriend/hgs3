@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-stretch">
        <div class="align-self-top p-2">
            @include ('game.common.package_image', ['imageUrl' => $gamePackage->small_image_url])
        </div>
        <div class="align-self-top">
            <div>
                <h4>{{ $gamePackage->name }}のレビュー入力内容確認</h4>
            </div>
        </div>
    </div>

    <section>
        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center">
                <div class="review_point_outline">
                    <p class="review_point">{{ $draft->point }}</p>
                </div>
            </div>
            <div class="p-12 align-self-center">
                @if($draft->is_spoiler == 1) <span class="badge badge-pill badge-danger">ネタバレあり！</span> @endif
                <div class="break_word" style="width: 100%;"><h5>{{ $draft->title }}</h5></div>
                <div>
                    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $user->id }}">{{ $user->name }}</a>
                    {{ $draft->post_date }}
                </div>
            </div>
        </div>

        @include('review.common.chart', ['r' => $draft])

        <div style="margin-top: 10px;">
            <h5>プレイ状況</h5>
            <p class="break_word">{{ $draft->progress }}</p>
            <h5>レビュー @if($draft->is_spoiler == 1) <span class="badge badge-pill badge-danger">ネタバレあり！</span> @endif </h5>
            <p class="break_word">{{ $draft->text }}</p>
        </div>
    </section>

    <form method="POST" action="{{ url('review/save') }}/{{ $gamePackage->id }}">
        {{ csrf_field() }}

        <input type="hidden" name="game_id" value="{{ $draft->game_id }}">
        <input type="hidden" name="package_id" value="{{ $draft->package_id }}">
        <input type="hidden" name="title" value="{{ $draft->title }}">
        <input type="hidden" name="fear" value="{{ $draft->fear }}">
        <input type="hidden" name="story" value="{{ $draft->story }}">
        <input type="hidden" name="volume" value="{{ $draft->volume }}">
        <input type="hidden" name="difficulty" value="{{ $draft->difficulty }}">
        <input type="hidden" name="graphic" value="{{ $draft->graphic }}">
        <input type="hidden" name="sound" value="{{ $draft->sound }}">
        <input type="hidden" name="crowded" value="{{ $draft->crowded }}">
        <input type="hidden" name="controllability" value="{{ $draft->controllability }}">
        <input type="hidden" name="recommend" value="{{ $draft->recommend }}">
        <input type="hidden" name="progress" value="{{ $draft->progress }}">
        <input type="hidden" name="text" value="{{ $draft->text }}">
        <input type="hidden" name="is_spoiler" value="{{ $draft->is_spoiler }}">
        <div class="form-group">
            <button class="btn btn-link" name="draft" value="-1">入力画面に戻る</button>
            <button class="btn btn-warning" style="margin-left: 30px;" name="draft" value="1">下書き保存</button>
            <button class="btn btn-primary" style="margin-left: 30px;" name="draft" value="0">保存</button>
        </div>
    </form>
@endsection
