@extends('layouts.app')

@section('content')

    <h5>{{ $game->name }}</h5>

    @if ($isMember)
    <div class="row">
        <div class="col-4">参加中</div>
        <div class="col-8">
            <form method="POST" action="{{ url('community/g') }}/{{ $game->id }}/secession">
                {{ csrf_field() }}
                <button class="btn btn-primary">脱退する</button>
            </form>
        </div>
    </div>
    @else
        <form method="POST" action="{{ url('community/g') }}/{{ $game->id }}/join">
            {{ csrf_field() }}
            <button class="btn btn-primary">参加する</button>
        </form>
    @endif

    <hr>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    参加メンバー({{ $memberNum }}人)
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($members as $u)
                            <li class="list-group-item">{{ un($users, $u->user_id) }}</li>
                        @endforeach
                    </ul>
                    ⇒ <a href="{{ url('community/g') }}/{{ $game->id }}/member">もっと見る</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    直近の書き込み
                </div>
                <div class="card-body">
                    <table class="table table-responsive">
                        <tbody>
                            @foreach ($topics as $t)
                            <tr>
                                <td><a href="{{ url('community/g') }}/{{ $game->id }}/topic/{{ $t->id }}">{{ $t->title }}</a></td>
                                <td>{{ $t->wrote_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    ⇒ <a href="{{ url('community/g') }}/{{ $game->id }}/topics">もっと見る</a>
                </div>
            </div>
        </div>
    </div>

@endsection