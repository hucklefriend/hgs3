@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-stretch">
        <div class="p-2 align-self-center" style="min-width: 3em;">
            @include('game.common.packageImage', ['imageUrl' => $package->medium_image_url])
        </div>
        <div class="p-10 align-self-top">
            <div class="break-word" style="width: 100%;"><h5>{{ $soft->name }}<small>のコミュニティ</small></h5></div>
            <div>
                <a href="{{ url('game/soft') }}/{{ $soft->id }}">ゲームの詳細</a>
            </div>
            <br>
            @if ($isMember)
                <form method="POST" action="{{ url('community/g') }}/{{ $soft->id }}/leave">
                    {{ csrf_field() }}
                    <button class="btn btn-sm btn-warning">脱退する</button>
                </form>
            @else
                <form method="POST" action="{{ url('community/g') }}/{{ $soft->id }}/join">
                    {{ csrf_field() }}
                    <button class="btn btn-sm btn-primary">参加する</button>
                </form>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-7">
            <div class="card card-hgn">
                <div class="card-header">
                    トピック
                </div>
                <div class="card-body">
                    {{-- TODO トピックがないパターン --}}
                    @foreach ($topics as $topic)
                        {{-- TODO レス数と投稿者を出したい --}}
                        <div>
                            <p class="" style="word-break: break-all;"><a href="{{ url('community/g/' . $soft->id . '/topic/' . $topic->id) }}">{{ $topic->title }}</a></p>
                            <p class="text-muted"><small>{{ $topic->wrote_at }}</small></p>
                        </div>
                        <hr>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ url2('community/g/' . $soft->id . '/topics') }}">全てのトピックを見る</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="card card-hgn">
                <div class="card-header">
                    参加メンバー({{ $memberNum }}人)
                </div>
                <div class="card-body">
                    {{-- TODO メンバーがいないパターン --}}
                    @foreach ($members as $u)
                        <div class="row">
                            <div class="col-1">
                                @include('user.common.icon', ['u' => $u])
                            </div>
                            <div class="col-10">
                                @include('user.common.user_name', ['u' => $u])
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ url('community/g/' . $soft->id . '/member') }}">全てのメンバーを見る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection