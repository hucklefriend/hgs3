@extends('layouts.app')

@section('title')アクセスログ@endsection
@section('global_back_link'){{ route('サイト詳細', ['site' => $site->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $site->name }}のアクセスログ</h1>
        </header>

        <div class="row quick-stats">
            <div class="col-6 col-sm-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2>{{ number_format($site->out_count) }}</h2>
                        <small>累計OUT数</small>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2>{{ number_format($site->in_count) }}</h2>
                        <small>累計IN数</small>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2>XXX</h2>
                        <small>今日のOUT数</small>
                    </div>
                </div>
            </div>

            <div class="col-6 col-sm-3">
                <div class="quick-stats__item">
                    <div class="quick-stats__info">
                        <h2>XXX</h2>
                        <small>今日のIN数</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">直近の足跡</h5>

                <table class="table table-no-border" style="width: auto !important;">
                @foreach ($nearlyFootprints as $footprint)
                    <tr>
                        <td style="white-space: nowrap;">{{ format_date($footprint->time) }}</td>
                        <td>
                            @isset($footprintUsers[$footprint->user_id])
                                @include('user.common.icon', ['u' => $footprintUsers[$footprint->user_id]])
                                @include('user.common.user_name', ['u' => $footprintUsers[$footprint->user_id]])
                            @else
                                ゲストさん
                            @endif
                        </td>
                    </tr>
                @endforeach
                </table>
                <div class="mt-3 text-right">
                    <a href="{{ route('サイト足跡', ['site' => $site->id]) }}" class="badge badge-pill and-more">すべて見る <i class="fas fa-angle-right"></i></a>
                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <div class="text-center">

                    <a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $prev->format('Y-m') }}" class="btn btn-sm btn-outline-secondary mr-5"><i class="fas fa-chevron-left"></i></a>

                    <label for="ym" style="font-size: 1.5rem;">{{ $date->format('Y年n月') }}</label>
                    <span class="date">
                        <input type="hidden" name="ym_tmp" id="ym_tmp" readonly class="form-control-plaintext" value="{{ $date->format('Y-m') }}" style="width: 5px;visibility: hidden;">
                        <button class="btn btn-light btn--icon" type="button" id="month_picker"><i class="far fa-calendar-alt"></i></button>
                    </span>
                    <a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}?ym={{ $next->format('Y-m') }}" class="btn btn-sm btn-outline-secondary ml-5"><i class="fas fa-chevron-right"></i></a>
                </div>

                <div>
                    <table class="table table-bordered table-responsive mt-3 calendar-hgn">
                        <thead>
                        <tr>
                            <th class="text-center">日</th>
                            <th class="text-center">月</th>
                            <th class="text-center">火</th>
                            <th class="text-center">水</th>
                            <th class="text-center">木</th>
                            <th class="text-center">金</th>
                            <th class="text-center">土</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @php $days = 0; @endphp
                            @foreach ($accesses as $access)
                                @if ($access->disable)
                                    @if ($access->otherMonth)
                                    <td>&nbsp;</td>
                                    @else
                                    <td>
                                        <span class="calendar-hgn-day">{{ $access->day }}</span>
                                        <div class="calendar-hgn-access">&nbsp;<br>&nbsp;</div>
                                    </td>
                                    @endif
                                @else
                                    <td>
                                        <span class="calendar-hgn-day">{{ $access->day }}</span>
                                        @isset($access->date)
                                        <a href="{{ route('サイト日別足跡', ['site' => $site->id, 'date' => $access->date]) }}" class="calendar-hgn-link">
                                            <div class="calendar-hgn-access">
                                                <i class="fas fa-sign-out-alt"></i> {{ number_format($access->out) }}<br>
                                                <i class="fas fa-sign-in-alt"></i> {{ number_format($access->in) }}
                                            </div>
                                        </a>
                                        @else
                                        <div class="calendar-hgn-access">
                                            <i class="fas fa-sign-out-alt"></i> {{ number_format($access->out) }}<br>
                                            <i class="fas fa-sign-in-alt"></i> {{ number_format($access->in) }}
                                        </div>
                                        @endisset
                                    </td>
                                @endif
                            @if (++$days == 7 && !$loop->last)
                        </tr>
                        <tr>
                            @php $days = 0; @endphp
                            @endif

                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <small>
                        <i class="fas fa-sign-out-alt"></i> OUT数
                        <i class="fas fa-sign-in-alt"></i> IN数
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ url('js/bootstrap-datepicker.ja.min.js') }}"></script>

    <script>
        $(function (){
            $('.date').datepicker({
                format: 'yyyy-mm',
                language: 'ja',
                autoclose: true,
                minViewMode: 'months'
            }).on('changeMonth', function (e){
                $('#ym').val(e.date.getFullYear() + '-' + (e.date.getMonth() + 1));
                $('#ym_form').submit();
            });
        });
    </script>

    <link rel="stylesheet" href="{{ url('css/bootstrap-datepicker.min.css') }}">
    <style>
        .calendar-hgn {
            table-layout: fixed !important;
            white-space: nowrap;
        }

        .calendar-hgn thead tr th {
            border-top: solid 1px rgba(255,255,255,.125) !important;
        }

        .calendar-hgn td {
            min-width: 100px;
            padding-top: 15px;
            position: relative;
        }

        .calendar-hgn-day {
            position: absolute;
            left: 0;
            top: 0;
            padding: 5px 8px;
            background-color: rgba(255,255,255,.125);
        }

        .calendar-hgn-access {
            padding: 10px;
        }

        .calendar-hgn-link {
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
    <form action="{{ route('サイトアクセスログ', ['site' => $site->id]) }}" id="ym_form">
        <input type="hidden" name="ym" id="ym" value="{{ $date->format('Y-m') }}">
    </form>
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