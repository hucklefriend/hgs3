@extends('layouts.app')

@section('content')

    <div>
        @foreach ($phoneticList as $phoneticId => $phoneticChar)
            <h4>{{ $phoneticChar }}</h4>
            <ul class="">
                @if (isset($list[$phoneticId]))
                @foreach ($list[$phoneticId] as $soft)
                    <li><a href="{{ url('community/g') }}/{{ $soft->id }}">{{ $soft->name }} ({{ $memberNum[$soft->id] ?? 0 }}人)</a></li>
                @endforeach
                @endif
            </ul>
        @endforeach
    </div>
@endsection