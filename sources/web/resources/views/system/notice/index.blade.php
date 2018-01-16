@extends('layouts.app')

@section('content')
    <h1>お知らせ</h1>


    @if(is_admin())
        <div class="btn_area">
            <a class="btn btn-sm btn-outline-dark" href="{{ route('お知らせ登録') }}" role="button">お知らせの新規登録</a>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>タイトル</th>
            <th>公開日</th>
            <th>公開終了日</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($notices as $notice)
            <tr>
                <td>{{ str_limit($notice->title, 20) }}</td>
                <td>{{ $notice->open_at }}</td>
                <td>{{ $notice->close_at }}</td>
                @if (is_admin())
                <td><a class="btn btn-sm btn-outline-info" href="{{ route('お知らせ編集', ['notice' => $notice->id]) }}" role="button">更新</a></td>
                <td><button class="btn btn-danger btn-sm" onclick="deleteNotice({{ $notice->id }});">削除</button></td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $notices->links() }}

    <form method="POST" id="delete_form">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <input type="hidden" name="id" value="" id="delete_id">
    </form>

    <script>
        function deleteNotice(id) {
            if (confirm('削除します')) {
                $('#delete_id').val(id);
                $('#delete_form').submit();
            }
        }
    </script>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ</li>
        </ol>
    </nav>
@endsection