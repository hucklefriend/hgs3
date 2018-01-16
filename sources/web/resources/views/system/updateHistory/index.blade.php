@extends('layouts.app')

@section('content')
    <h1>システム更新履歴</h1>

    @if(is_admin())
    <div class="add_group">
        <a class="btn btn-sm btn-outline-dark" href="{{ route('システム更新履歴登録') }}" role="button">更新履歴の新規登録</a>
    </div>
    @endif

    <section>
        <table id="update_history_table" class="table table-responsive">
            @foreach ($histories as $history)
                <tr>
                    <td class="history_date">{{ $history->update_at }}</td>
                    <td><a href="{{ route('システム更新履歴詳細', ['updateHistory' => $history->id]) }}">{{ $history->title }}</a></td>
                </tr>
            @endforeach
        </table>
    </section>
    {{ $histories->links() }}

    <style>
        .history_date {
            padding-right: 10px;
        }
    </style>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">システム更新履歴</li>
        </ol>
    </nav>
@endsection