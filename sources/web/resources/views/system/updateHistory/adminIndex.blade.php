@extends('layouts.admin')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-master">
            <li class="breadcrumb-item"><a href="{{ url2('') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ url2('/admin') }}">管理トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">システム更新履歴</li>
        </ol>
    </nav>


    <h4>システム更新履歴</h4>

    <div class="text-right">
        <a href="{{ url2('system/update_history/add') }}">追加</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>タイトル</th>
            <th>更新日時</th>
            <th>編集</th>
            <th>削除</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($histories as $history)
            <tr>
                <td>{{ str_limit($history->title, 20) }}</td>
                <td>{{ $history->update_at }}</td>
                <td><a href="{{ url2('system/update_history/edit/' . $history->id) }}">編集</a></td>
                <td><button class="btn btn-danger btn-sm" onclick="deleteHistory({{ $history->id }});">削除</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $histories->links() }}

    <form method="POST" id="delete_form">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <input type="hidden" name="id" value="" id="delete_id">
    </form>

    <script>
        function deleteHistory(id) {
            if (confirm('削除します')) {
                $('#delete_id').val(id);
                $('#delete_form').submit();
            }
        }
    </script>

@endsection