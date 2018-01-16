@extends('layouts.app')

@section('content')
    <h1>システム更新履歴</h1>

    @if(is_admin())
    <div class="btn_area">
        <a class="btn btn-sm btn-outline-dark" href="{{ route('システム更新履歴登録') }}" role="button">更新履歴の新規登録</a>
    </div>
    @endif

    <section>
        <table id="update_history_table" class="table table-responsive">
            @foreach ($histories as $history)
                <tr>
                    <td class="history_date">{{ $history->update_at }}</td>
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