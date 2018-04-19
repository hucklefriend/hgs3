@extends('layouts.app')

@section('title')アクセスログ@endsection
@section('global_back_link'){{ route('サイト詳細', ['site' => $site->id]) }}@endsection

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
        <h2>直近の足跡</h2>
        @foreach ($nearlyFootprints as $footprint)
            <div>
                {{ date('Y-m-d H:i', $footprint->time) }}
                @include('user.common.icon', ['u' => $footprintUsers[$footprint->user_id]])
                @include('user.common.user_name', ['u' => $footprintUsers[$footprint->user_id]])
            </div>
        @endforeach
        <div style="margin-top: 10px;">
            <a href="{{ route('サイト足跡', ['site' => $site->id]) }}">すべて見る</a>
        </div>
    </section>

    <section class="one-content">
        <div class="d-flex justify-content-around">
            <div>
                <a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $prev->format('Y-m') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-left"></i></a>
            </div>
            <div>
                <form action="{{ route('サイトアクセスログ', ['site' => $site->id]) }}" id="ym_form" class="form-inline">
                    <h2><label for="ym">{{ $date->format('Y年n月') }}</label></h2>
                    <div class="input-group date">
                        <input type="text" name="ym" id="ym" readonly class="form-control-plaintext" value="{{ $date->format('Y-m') }}" style="width: 5px;visibility: hidden;">
                        <span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
                    </div>
                </form>
            </div>
            <div>
                <a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $next->format('Y-m') }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <table class="table table-responsive table-no-border">
            <thead>
                <tr class="text-center">
                    <th>日</th>
                    <th>OUT</th>
                    <th>IN</th>
                    <th>足跡</th>
                </tr>
            </thead>
            <tbody>
            @for ($day = 1; $day <= $maxDay; $day++)
                <tr>
                    <td>{{ $day }}日</td>
                    @isset ($accesses[$day])
                        <td>{{ number_format($accesses[$day]->out) }}</td>
                        <td>{{ number_format($accesses[$day]->in) }}</td>
                        @if ($accesses[$day]->out > 0)
                        <td><a href="{{ route('サイト日別足跡', ['site' => $site->id, 'date' => $accesses[$day]->date]) }}">この日の足跡</a></td>
                        @else
                        <td></td>
                        @endif
                    @else
                        <td>0</td>
                        <td>0</td>
                        <td></td>
                    @endif
                </tr>
            @endfor
            </tbody>
        </table>
    </section>

    <script>
        $(function (){
            $('.input-group.date').datepicker({
                format: 'yyyy-mm',
                language: 'ja',
                autoclose: true,
                minViewMode: 'months'
            });

            $('#ym').change(function (){
                $('#ym_form').submit();
            });
        });
    </script>


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