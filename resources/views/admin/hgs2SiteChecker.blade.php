@extends('layouts.app')

@section('title')HGS2サイトチェッカー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>HGS2サイトチェッカー</h1>
        </header>

        <table class="table table-borderd">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>URL</th>
                <th>GO</th>
            </tr>
            @foreach ($sites as $site)
                <tr>
                    <td>{{ $site->id }}</td>
                    <td>{{ $site->site_name }}</td>
                    <td>{{ $site->url }}</td>
                    <td>
                        @if (!empty($site->banner_url))
                        <a href="{{ $site->url }}" target="_blank"><img src="{{ $site->banner_url }}"></a>
                        @else
                        <a href="{{ $site->url }}" target="_blank">GO</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection
