@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイト詳細', ['site' => $site->id]) }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>{{ $site->name }}のアクセスログ</h1>

    <section class="one-content">
        <table class="table table-sm table-no-border table-responsive">
            <tr>
                <th>累計OUT</th>
                <td>{{ number_format($site->out_count) }}</td>
            </tr>
            <tr>
                <th>累計IN</th>
                <td>{{ number_format($site->in_count) }}</td>
            </tr>
        </table>
    </section>

    <section class="one-content">
        <h2>最近の足跡</h2>
    </section>

    <section class="one-content">
        <h2>
            {{ $date->format('Y年n月') }}
            <a href="javascript:void(0)"><i class="far fa-calendar-alt"></i></a>
        </h2>
    </section>


@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト詳細', ['site' => $site->id]) }}">詳細</a></li>
            <li class="breadcrumb-item active" aria-current="page">アクセスログ</li>
        </ol>
    </nav>
@endsection