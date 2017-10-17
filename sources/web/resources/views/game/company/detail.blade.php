@extends('layouts.app')

@section('content')
    <h4>{{ $company->name }}</h4>

    <div>
        @if ($company->url != null)
        <a href="{{ $company->url }}" target="_blank">公式サイト</a>
        @endif
        @if ($company->wikipedia != null)
        <a href="{{ $company->wikipedia }}" target="_blank">Wikipedia</a>
        @endif
    </div>


    @if (\Hgs3\Constants\UserRole::isDataEditor())
    <div class="text-right">
        <a href="{{ url('game/company/edit/') }}/{{ $company->id }}">データ編集</a>
    </div>
    @endif

    <hr>

    <ul class="list-group">
    @foreach ($detail['soft'] as $soft)
        <li class="list-group-item">
            <a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a>
        </li>
    @endforeach
    </ul>
@endsection