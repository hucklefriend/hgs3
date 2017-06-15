@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('master/game_company/create') }}">新規登録</a>
    </div>

    <div>
        <ul class="">
            @foreach ($list as $company)
                <li><a href="{{ url('master/game_company') }}/{{ $company->id }}">{{ $company->name }}</a></li>
            @endforeach
        </ul>
    </div>


@endsection