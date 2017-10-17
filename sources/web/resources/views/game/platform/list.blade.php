@extends('layouts.app')

@section('content')
    <h4>プラットフォーム一覧</h4>

    @if (\Hgs3\Constants\UserRole::isDataEditor())
    <div class="text-right">
        <a href="{{ url2('game/platform/add') }}">プラットフォームを追加</a>
    </div>
    @endif

    <table class="table table-responsive">
        <tr>
            <th>名称</th>
            <th>略称</th>
        </tr>

        @foreach ($platforms as $p)
        <tr>
            <td><a href="{{ url2('game/platform') }}/{{ $p->id }}">{{ $p->name }}</a></td>
            <td>{{ $p->acronym }}</td>
        </tr>
        @endforeach
    </table>
@endsection