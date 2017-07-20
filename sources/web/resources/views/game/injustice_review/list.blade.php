@extends('layouts.app')

@section('content')

    <nav style="margin-top: 10px; margin-bottom: 10px;">
        <a href="{{ url('game/review/detail') }}/{{ $review->id }}">レビューに戻る</a>
    </nav>

    <div>
        <a href="{{ url('game/injustice_review/input') }}/{{ $review->id }}">不正報告する</a>
    </div>

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

    <hr>

    <table class="table table-responsive table-bordered">
        <tr>
            <th>報告者</th>
            <th>内容</th>
            <th>対応状況</th>
            <th>返信数</th>
            <th></th>
        </tr>
    @foreach ($data as $r)
        <tr>
            <td>{{ $users[$r->user_id] }}</td>
            <td>{{ mb_strimwidth($r->comment, 0, 30, '...') }}</td>
            <td>{{ \Hgs3\Constants\InjusticeStatus::getText($r->status) }}</td>
            <td>{{ $num[$r->id] ?? 0 }}</td>
            <td><a href="{{ url('game/injustice_review/detail/') }}/{{ $r->id }}">詳細</a></td>
        </tr>
    @endforeach
    </table>
@endsection