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
                    <td><a href="{{ url('community/u') }}/{{ $t->id }}/topic/{{ $t->id }}">{{ $t->title }}</a></td>
                    <td>{{ $users[$t->user_id] }}</td>
                    <td>{{ $t->wrote_date }}</td>
                    <td>{{ $t->response_num }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $pager->links() }}

@endsection