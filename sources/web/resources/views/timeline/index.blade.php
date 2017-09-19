@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url2('timeline/add') }}">追加</a>
    </div>

    <hr>

    {{ $pager->render() }}

    @foreach ($timelines as $tl)
        <div class="row">
            <div class="col-10">
                <div>{{ date('Y-m-d H:i:s', $tl['time']) }} type: {{ $tl['type'] }}</div>
                <p>{!!  $tl['text'] !!}</p>
            </div>
            <div class="col-2">
                <form method="post" action="{{ url2('timeline') }}">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $tl['_id'] }}">
                    <button class="btn btn-sm btn-danger">削除</button>
                </form>
            </div>
        </div>
        <hr>

    @endforeach
@endsection