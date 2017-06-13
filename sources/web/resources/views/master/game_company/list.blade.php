@extends('layouts.app')

@section('content')
    <div>
        <ul class="nav pull-right">
            @foreach ($list as $company)
                <li>{{ $company->name  }}</li>
            @endforeach

        </ul>
    </div>


@endsection