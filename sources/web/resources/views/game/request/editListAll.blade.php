@extends('layouts.app')

@section('content')
    <h4></h4>


    <div>
        <a href="{{ url('game/soft') }}">ソフト一覧</a>
    </div>

    <table class="table table-bordered">
        @foreach ($list as $r)
            <tr>
                <td>@if(isset($gameHash[$r->game_id])){{ $gameHash[$r->game_id] }}@else -- @endif</td>
                <td>@if(isset($userHash[$r->user_id])){{ $userHash[$r->user_id] }}@else{{ '匿名' }}@endif</td>
                <td><a href="{{ url('game/request/show/edit') }}/{{ $r->id }}">詳細</a></td>
            </tr>
        @endforeach
    </table>
@endsection