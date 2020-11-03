@extends('layouts.app')

@section('title'){{ $date->format('Y年n月j日') }}の足跡@endsection
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
            <h1>{{ $site->name }}</h1>
            <p>{{ $date->format('Y年n月j日') }}の足跡</p>
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
