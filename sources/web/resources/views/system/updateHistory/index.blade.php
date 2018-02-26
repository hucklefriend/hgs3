@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    @if (is_admin())
        <div class="d-flex justify-content-between">
            <h1>システム更新履歴</h1>
            <div>
                <a href="{{ route('システム更新履歴登録') }}" class="btn btn-sm btn-outline-dark">新規登録</a>
            </div>
        </div>
    @else
        <h1>システム更新履歴</h1>
    @endif

    <section>
        <table id="update_history_table" class="table table-responsive table-no-border">
            @foreach ($histories as $history)
                <tr class="mb-5">
                    <td class="history_date">{{ format_date($history->update_at_ts) }}</td>
                    <td><a href="{{ route('システム更新内容', ['updateHistory' => $history->id]) }}">{{ $history->title }}</a></td>
                    @if (is_admin())
                        <td><a class="btn btn-sm btn-outline-info" href="{{ route('システム更新履歴更新', ['updateHistory' => $history->id]) }}" role="button">編集</a></td>
                        <td>
                            <form action="{{ route('システム更新履歴削除', ['updateHistory' => $history->id]) }}" onsubmit="return confirm('削除してよろしいですか？');" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button class="btn btn-sm btn-danger" type="submit">削除</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </section>

    @include('common.pager', ['pager' => $histories])

    <style>
        .history_date {
            padding-right: 10px;
        }
    </style>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">システム更新履歴</li>
        </ol>
    </nav>
@endsection