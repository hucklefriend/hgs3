@extends('layouts.app')

@section('content')
    <div>
        <small><a href="{{ url2('community/g/' . $soft->id . '/topics') }}">トピック一覧へ</a></small>
        <h4>{{ $topic->title }}</h4>
        <div>
            <i class="fa fa-user-o" aria-hidden="true"></i> <a href="{{ url2('user/profile/' . $writer->id) }}">{{ $writer->name }}</a>
            {{ $topic->wrote_at }}
            @if ($topic->user_id == $userId)
                <form method="POST" action="{{ url('community/g/' . $soft->id  . '/topic/' . $topic->id) }}" class="d-inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-sm">削除</button>
                </form>
            @endif
        </div>
        <div>

        </div>

        <p class="community-topic-comment">{{ $gct->comment }}</p>
    </div>

    @foreach ($responses as $res)
        <div>
            <div>
                <i class="fa fa-user-o" aria-hidden="true"></i> <a href="{{ url2('user/profile/' . $res->user_id) }}">{{ $users[$r->user_id] }}</a>
                {{ $res->wrote_at }}
            </div>
            <p class="community-topic-comment">{{ $res->comment }}</p>

            @if ($res->user_id == $userId)
                <form method="POST" action="{{ url2('community/g/' . $soft->id . '/topic_response/' . $res->id) }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-sm">削除</button>
                </form>
            @endif
        </div>
    @endforeach

    {{ $pager->links() }}

    <hr>

    <form method="POST" action="{{ url('community/g/' . $gameSoft->id . '/topic/' . $topic->id) }}" autocomplete="off">
        {{ csrf_field() }}
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