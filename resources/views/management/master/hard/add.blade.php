@extends('layouts.management')

@section('title', 'ハード登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-ハード') }}">ハード</a></li>
        <li class="breadcrumb-item active">ハード登録</li>
    </ol>
    <h1 class="page-header">ハード登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規登録</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-ハード登録処理') }}">
            {{ csrf_field() }}
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>名前</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'name', 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>よみがな</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'phonetic', 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>略称</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'acronym', 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>表示順(発売日の数値)</th>
                        <td>
                            @include ('management.common.form.input', ['type' => 'number', 'name' => 'sort_order', 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>メーカー</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'maker_id', 'list' => $makers])
                        </td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">登録</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(()=>{
            $("#maker_id").select2();
        });
    </script>
@endsection