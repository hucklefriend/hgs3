@extends('layouts.app')

@section('content')
    <h4>{{ $company->name }}</h4>

    @if ($company->url != null)
        <div>公式サイト: <a href="{{ $company->url }}" target="_blank">{{ $company->url }}</a></div>
    @endif
    @if ($company->wikipedia != null)
        <div>Wikipedia: <a href="{{ $company->wikipedia }}" target="_blank">{{ $company->wikipedia }}</a></div>
    @endif

    @if (\Hgs3\Constants\UserRole::isDataEditor())
    <div>
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