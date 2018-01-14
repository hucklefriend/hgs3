@extends('layouts.admin')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-master">
            <li class="breadcrumb-item"><a href="{{ url2('') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ url2('/admin') }}">管理トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">お知らせ</li>
        </ol>
    </nav>


    <h4>お知らせ</h4>

    <div class="text-right">
        <a href="{{ url2('system/notice/add') }}">追加</a>
    </div>

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
                <td><a href="{{ url2('system/notice/edit/' . $notice->id) }}">編集</a></td>
                <td><button class="btn btn-danger btn-sm" onclick="deleteNotice({{ $notice->id }});">削除</button></td>
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