@extends('layouts.app')

@section('content')
    <h4>システム更新履歴</h4>

    <section>
        @foreach ($histories as $history)
            <div class="row">
                <div class="col-2">{{ $history->update_at }}</div>
                <div class="col-10"><a href="{{ url2('system_update/' . $history->id) }}">{{ $history->title }}</a></div>
            </div>
        @endforeach
    </section>

    {{ $histories->links() }}
@endsection