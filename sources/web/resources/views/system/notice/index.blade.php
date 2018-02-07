@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>お知らせ</h1>

    @if(is_admin())
        <div class="btn-area">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('お知らせ登録') }}" role="button">お知らせの新規登録</a>
        </div>
    @endif

    <table class="table table-responsive">
        <tbody>
        @foreach ($notices as $notice)
            <tr>
                <td>{{ $notice->open_at }}</td>
                <td><a href="{{ route('お知らせ内容', ['notice' => $notice->id]) }}">{{ str_limit($notice->title, 30) }}</a></td>
                @if (is_admin())
                <td><a class="btn btn-sm btn-outline-info" href="{{ route('お知らせ編集', ['notice' => $notice->id]) }}" role="button">更新</a></td>
                <td>
                    <form action="{{ route('お知らせ削除', ['notice' => $notice->id]) }}" onsubmit="return confirm('削除してよろしいですか？');" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-sm btn-danger" type="submit">削除</button>
                    </form>
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @include('common.pager', ['pager' => $notices])
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ</li>
        </ol>
    </nav>
@endsection