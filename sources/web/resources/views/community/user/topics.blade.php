@extends('layouts.app')

@section('content')

    <h5>{{ $uc->name }}掲示板</h5>

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
                    <td><a href="{{ url('community/u') }}/{{ $uc->id }}/topic/{{ $t->id }}">{{ $t->title }}</a></td>
                    <td>{{ $users[$t->user_id] }}</td>
                    <td>{{ $t->wrote_date }}</td>
                    <td>{{ $t->response_num }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $pager->links() }}

    <form method="POST" action="{{ url('community/u') }}/{{ $uc->id }}/topics">
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