@extends('layouts.app')

@section('title')レビュー承認@endsection
@section('global_back_link'){{ route('管理メニュー') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>レビュー承認</h1>
        </header>

        @foreach ($reviews as $review)
            <div class="row">
                <div class="col-12 col-sm-6">
                    <a href="{{ route('レビュー', ['review' => $review->id]) }}" target="_blank" class="mr-3">レビュー</a>
                    <a href="{{ $review->url }}" target="_blank">{{ $review->url }}</a>
                </div>
                <div class="d-flex text-right col-12 col-sm-6">
                    <form method="POST" action="{{ route('レビューURL OK') }}" class="mr-5">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                        <button class="btn btn-primary">OK</button>
                    </form>
                    <form method="POST" action="{{ route('レビューURL NG') }}">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                        <button class="btn btn-danger">NG</button>
                    </form>
                </div>
            </div>
            @if (!$loop->last)
                <hr>
            @endif
        @endforeach
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー</li>
        </ol>
    </nav>
@endsection