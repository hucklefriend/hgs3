@extends('layouts.app')

@section('content')

    <h5>{{ $uc->name }}掲示板</h5>

    <div>
        <a href="{{ url2('community/u') }}/{{ $uc->id }}/topics">トピック一覧</a> |
        <a href="{{ url2('community/u') }}/{{ $uc->id }}">コミュニティトップ</a>
    </div>

    <hr>

    <div>
        <h5>{{ $uct->title }}</h5>
        <div>{{ $uct->wrote_date }}</div>
        <div>writer: <a href="{{ url2('user/profile') }}/{{ $writer->id }}">{{ $writer->name }}</a></div>
        <pre>{{ $uct->comment }}</pre>
    </div>

    {{ $pager->links() }}

    @foreach ($pager->items() as $r)
        <div>
            <div>{{ $r->wrote_date }}</div>
            <div>writer: <a href="{{ url2('user/profile') }}/{{ $r->user_id }}">{{ $users[$r->user_id] }}</a></div>
            <pre>{{ $r->comment }}</pre>
        </div>
    @endforeach

    {{ $pager->links() }}

    <hr>

    <form method="POST" action="{{ url('community/u') }}/{{ $uc->id }}/topic/{{ $uct->id }}">
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