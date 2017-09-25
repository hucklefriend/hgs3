@extends('layouts.app')

@section('content')

    <h5>{{ $uc->name }}</h5>

    @if ($isMember)
    <div class="row">
        <div class="col-4">参加中</div>
        <div class="col-8">
            <form method="POST" action="{{ url('community/u') }}/{{ $uc->id }}/secession">Member
                {{ csrf_field() }}
                <button class="btn btn-primary">脱退する</button>
            </form>
        </div>
    </div>
    @else
        <form method="POST" action="{{ url('community/u') }}/{{ $uc->id }}/join">
            {{ csrf_field() }}
            <button class="btn btn-primary">参加する</button>
        </form>
    @endif

    <hr>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    参加メンバー({{ $uc->user_num }}人)
                </div>
                <div class="card-block">
                    <ul class="list-group">
                        @foreach ($members as $u)
                            <li class="list-group-item">{{ $users[$u->user_id] }}</li>
                        @endforeach
                    </ul>
                    ⇒ <a href="{{ url('community/u') }}/{{ $uc->id }}/member">もっと見る</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    直近の書き込み
                </div>
                <div class="card-block">
                    <table class="table table-responsive">
                        <tbody>
                            @foreach ($topics as $t)
                            <tr>
                                <td><a href="{{ url('community/u') }}/{{ $uc->id }}/topic/{{ $t->id }}">{{ $t->title }}</a></td>
                                <td>{{ $t->wrote_date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    ⇒ <a href="{{ url('community/u') }}/{{ $uc->id }}/topics">もっと見る</a>
                </div>
            </div>
        </div>
    </div>

@endsection