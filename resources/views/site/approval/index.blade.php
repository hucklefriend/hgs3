@extends('layouts.app')

@section('title')承認待ちサイト@endsection
@section('global_back_link'){{ route('管理メニュー') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>承認待ちサイト一覧</h1>
        </header>

        <table class="table table-responsive">
            <tr>
                <th>サイト名</th>
                <th>登録日時</th>
            </tr>
            @foreach ($sites as $site)
                <tr>
                    <td>
                        <a href="{{ route('サイト判定', ['site' => $site->id]) }}">{{ $site->name }}</a>
                    </td>
                    <td>
                        {{ $site->created_at }}
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $sites->render() }}
    </div>

@endsection
