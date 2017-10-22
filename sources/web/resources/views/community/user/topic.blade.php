@extends('layouts.app')

@section('content')

    <h5>{{ $uc->name }}掲示板</h5>

    <div>
        <a href="{{ url2('community/u') }}/{{ $userCommuinity->id }}/topics">トピック一覧</a> |
        <a href="{{ url2('community/u') }}/{{ $userCommuinity->id }}">コミュニティトップ</a>
    </div>

    <hr>

    <div>
        <h5>{{ $userCommunityTopic->title }}</h5>
        <div>{{ $userCommunityTopic->wrote_date }}</div>
        <div>writer: <a href="{{ url2('user/profile') }}/{{ $writer->id }}">{{ $writer->name }}</a></div>
        <pre>{{ $userCommunityTopic->comment }}</pre>

        @if ($userCommunityTopic->user_id == $userId)
            <form method="POST" action="{{ url('community/u') }}/{{ $userCommunity->id }}/topic/{{ $userCommunityTopic->id }}">
                <input type="hidden" name="_token" value="{{ $csrfToken }}">
                {{ method_field('DELETE') }}
                <button class="btn btn-danger btn-sm">削除</button>
            </form>
        @endif
    </div>

    {{ $responses->links() }}

    @foreach ($responses as $res)
        <div>
            <div>{{ $res->wrote_date }}</div>
            <div>writer: <a href="{{ url2('user/profile') }}/{{ $res->user_id }}">{{ $users[$res->user_id] }}</a></div>
            <pre>{{ $res->comment }}</pre>

            @if ($res->user_id == $userId)
                <form method="POST" action="{{ url2('community/u') }}/{{ $userCommunity->id }}/topic_response/{{ $res->id }}">
                    <input type="hidden" name="_token" value="{{ $csrfToken }}">
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-sm">削除</button>
                </form>
            @endif
        </div>
    @endforeach

    {{ $responses->links() }}

    <hr>

    <form method="POST" action="{{ url('community/u') }}/{{ $userCommunity->id }}/topic/{{ $userCommunityTopic->id }}">
        <input type="hidden" name="_token" value="{{ $csrfToken }}">
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