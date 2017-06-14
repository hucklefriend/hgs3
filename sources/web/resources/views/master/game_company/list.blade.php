@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ route('master_add_game_company') }}">新規登録</a>
    </div>

    <div>
        <ul class="nav pull-right">
            @foreach ($list as $company)
                <li>{{ $company->name }}</li>
            @endforeach

        </ul>
    </div>


@endsection