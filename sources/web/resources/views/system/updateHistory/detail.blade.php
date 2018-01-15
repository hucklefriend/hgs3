@extends('layouts.app')

@section('content')
    <div>
        <a href="{{ url2('system_update') }}">戻る</a>
    </div>

    <div class="card">
        <div class="card-header">
            {{ $updateHistory->title }}
        </div>
        <div class="card-body">
            <p>{{ $updateHistory->update_at }}</p>
            <p class="card-text">
                {!! nl2br(e($updateHistory->detail)) !!}
            </p>
        </div>
    </div>

@endsection