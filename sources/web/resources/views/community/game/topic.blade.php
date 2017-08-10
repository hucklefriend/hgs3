@extends('layouts.app')

@section('content')

    <h5>{{ $game->name }}掲示板</h5>

    <div>
        <a href="{{ url2('community/g') }}/{{ $game->id }}/topics">トピック一覧</a> |
        <a href="{{ url2('community/g') }}/{{ $game->id }}">コミュニティトップ</a>
    </div>

    <hr>

    <div>
        <h5>{{ $gct->title }}</h5>
        <div>{{ $gct->wrote_date }}</div>
        <div>writer: <a href="{{ url2('user/profile') }}/{{ $writer->id }}">{{ $writer->name }}</a></div>
        <pre>{{ $gct->comment }}</pre>

        @if ($gct->user_id == $userId)
            <form method="POST" action="{{ url('community/g') }}/{{ $game->id }}/topic/{{ $gct->id }}">
                <input type="hidden" name="_token" value="{{ $csrfToken }}">
                {{ method_field('DELETE') }}
                <button class="btn btn-danger btn-sm">削除</button>
            </form>
        @endif
    </div>

    {{ $pager->links() }}

    @foreach ($pager->items() as $r)
        <div>
            <div>{{ $r->wrote_date }}</div>
            <div>writer: <a href="{{ url2('user/profile') }}/{{ $r->user_id }}">{{ $users[$r->user_id] }}</a></div>
            <pre>{{ $r->comment }}</pre>

            @if ($r->user_id == $userId)
                <form method="POST" action="{{ url2('community/g') }}/{{ $game->id }}/topic_response/{{ $r->id }}">
                    <input type="hidden" name="_token" value="{{ $csrfToken }}">
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger btn-sm">削除</button>
                </form>
            @endif
        </div>
    @endforeach

    {{ $pager->links() }}

    <hr>

    <form method="POST" action="{{ url('community/g') }}/{{ $game->id }}/topic/{{ $gct->id }}">
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