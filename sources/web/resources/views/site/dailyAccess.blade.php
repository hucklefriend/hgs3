@extends('layouts.app')

@section('content')
    <h4>{{ $site->name }}日別アクセス数</h4>
    <div>
        <a href="{{ url2('site/detail/' . $site->id) }}">{{ $site->name }}の詳細</a>
    </div>

    <form>
        {{ Form::select('y', $years, $year, ['class' => 'form_control']) }}
        {{ Form::select('month', $months, $month, ['class' => 'form_control']) }}
    </form>


    @foreach ($footprints as $footprint)
        <div>{{ date('Y-m-d H:i:s', $footprint->time) }}</div>
        <div class="row">
            <div class="col-1">
                @include('user.common.icon', ['u' => $users[$footprint->user_id] ?? null])
            </div>
            <div class="col-10">
                @if (isset($users[$footprint->user_id]))
                @include('user.common.user_name', ['u' => $users[$footprint->user_id]])
                @else
                    ゲストさん
                @endif
            </div>
        </div>
        <hr>
    @endforeach

    {{ $pager->links() }}

@endsection