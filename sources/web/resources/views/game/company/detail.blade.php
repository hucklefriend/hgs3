@extends('layouts.app')

@section('content')
    <h4>{{ $company->name }}</h4>

    @if ($company->url != null)
        <div>公式サイト: <a href="{{ $company->url }}" target="_blank">{{ $company->url }}</a></div>
    @endif
    @if ($company->wikipedia != null)
        <div>公式サイト: <a href="{{ $company->wikipedia }}" target="_blank">{{ $company->wikipedia }}</a></div>
    @endif

    <div>
        <a href="{{ url('game/company') }}">会社一覧</a> |
    @if ($isAdmin)
        <a href="{{ url('game/company/edit/') }}/{{ $company->id }}">データ編集</a>
    @endif
    </div>


    <hr>

    <ul>
    @foreach ($detail['soft'] as $soft)
        <li><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
    @endforeach
    </ul>
@endsection