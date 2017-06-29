@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('game/request/input') }}">追加リクエスト</a> |
        <a href="{{ url('game/soft') }}">一覧</a>
    </div>

    <table class="table table-bordered">
        @foreach ($list as $r)
            <tr>
                <td>{{ $r->name }}</td>
                <td>@if(isset($userHash[$r->user_id])){{ $userHash[$r->user_id] }}@else{{ '匿名' }}@endif</td>
                <td></td>
            </tr>
        @endforeach
    </table>
@endsection