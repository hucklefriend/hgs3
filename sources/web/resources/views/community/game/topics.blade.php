@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-stretch">
        <div class="p-2 align-self-center" style="min-width: 3em;">
            @include('game.common.package_image', ['imageUrl' => $pkg->medium_image_url])
        </div>
        <div class="p-10 align-self-top">
            <div class="break_word" style="width: 100%;"><h5>{{ $game->name }}<small>のトピックス</small></h5></div>
            <div>
                <a href="{{ url('community/g') }}/{{ $game->id }}">コミュニティトップ</a>　
                <a href="{{ url('game/soft') }}/{{ $game->id }}">ゲームの詳細</a>
            </div>
            <br>
            @if ($isMember)
                <form method="POST" action="{{ url('community/g') }}/{{ $game->id }}/secession">
                    {{ csrf_field() }}
                    <button class="btn btn-sm btn-warning">脱退する</button>
                </form>
            @else
                <form method="POST" action="{{ url('community/g') }}/{{ $game->id }}/join">
                    {{ csrf_field() }}
                    <button class="btn btn-sm btn-primary">参加する</button>
                </form>
            @endif
        </div>
    </div>
    <hr>

    {{ $pager->links() }}

    <table class="table table-responsive">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>投稿者</th>
                <th>投稿日時</th>
                <th>返信数</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pager->items() as $t)
                <tr>
                    <td><a href="{{ url('community/g') }}/{{ $game->id }}/topic/{{ $t->id }}">{{ $t->title }}</a></td>
                    <td>{{ $users[$t->user_id] }}</td>
                    <td>{{ $t->wrote_date }}</td>
                    <td>{{ $t->response_num }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $pager->links() }}

    <hr>

    <form method="POST" action="{{ url('community/g') }}/{{ $game->id }}/topics">
        {{ csrf_field() }}
        <div class="form-group row">
            <label for="title" class="col-3 col-form-label">件名</label>
            <div class="col-9">
                <input class="form-control" type="text" value="" id="title" name="title">
            </div>
        </div>
        <div class="form-group row">
            <label for="comment" class="col-3 col-form-label">内容</label>
            <div class="col-9">
                <textarea class="form-control" name="comment" id="comment"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-xs-offset-3 col-9">
                <button class="btn btn-primary">投稿</button>
            </div>
        </div>
    </form>

@endsection