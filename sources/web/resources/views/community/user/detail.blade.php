@extends('layouts.app')

@section('content')

    <h5>{{ $userCommunity->name }}</h5>

    @if ($isMember)
    <div class="row">
        <div class="col-4">参加中</div>
        <div class="col-8">
            <form method="POST" action="{{ url2('community/u') }}/{{ $userCommunity->id }}/secession">Member
                {{ csrf_field() }}
                <button class="btn btn-primary">脱退する</button>
            </form>
        </div>
    </div>
    @else
        <form method="POST" action="{{ url2('community/u') }}/{{ $userCommunity->id }}/join">
            {{ csrf_field() }}
            <button class="btn btn-primary">参加する</button>
        </form>
    @endif

    <hr>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    参加メンバー({{ $userCommunity->user_num }}人)
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($members as $member)
                            <li class="list-group-item">{{ $users[$member->user_id] }}</li>
                        @endforeach
                    </ul>
                    ⇒ <a href="{{ url2('community/u') }}/{{ $userCommunity->id }}/member">もっと見る</a>
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
                            @foreach ($topics as $topic)
                            <tr>
                                <td><a href="{{ url2('community/u') }}/{{ $userCommunity->id }}/topic/{{ $topic->id }}">{{ $topic->title }}</a></td>
                                <td>{{ $t->wrote_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    ⇒ <a href="{{ url('community/u') }}/{{ $userCommunity->id }}/topics">もっと見る</a>
                </div>
            </div>
        </div>
    </div>

@endsection