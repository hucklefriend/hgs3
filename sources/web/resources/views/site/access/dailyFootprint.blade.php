@extends('layouts.app')


@section('title')アクセスログ@endsection
@section('global_back_link')
    @isset($ym)
    {{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $ym }}
    @else
    {{ route('サイトアクセスログ', ['site' => $site->id]) }}
    @endif
@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $date->format('Y年n月j日') }}の足跡</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <table class="table table-no-border" style="width: auto !important;">
                    @foreach ($footprints as $footprint)
                        <tr>
                            <td style="white-space: nowrap;">{{ format_date($footprint->time) }}</td>
                            <td>
                                @isset($users[$footprint->user_id])
                                    @include('user.common.icon', ['u' => $users[$footprint->user_id]])
                                    @include('user.common.user_name', ['u' => $users[$footprint->user_id]])
                                @else
                                    ゲストさん
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div>
                    @include('common.pager', ['pager' => $pager])
                </div>
            </div>
        </div>
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイト詳細', ['site' => $site->id]) }}">詳細</a></li>
            @isset($ym)
            <li class="breadcrumb-item"><a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $ym }}">アクセスログ</a></li>
            @else
            <li class="breadcrumb-item"><a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}">アクセスログ</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">足跡</li>
        </ol>
    </nav>
@endsection
