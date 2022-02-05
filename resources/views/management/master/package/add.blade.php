@extends('layouts.management')

@section('title', 'パッケージ登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ') }}">パッケージ</a></li>
        <li class="breadcrumb-item active">パッケージ登録</li>
    </ol>
    <h1 class="page-header">パッケージ登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規登録</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-パッケージ登録処理') }}">
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
                        <th>略称</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'acronym', 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>メーカー</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'maker_id', 'list' => $makers])
                        </td>
                    </tr>
                    <tr>
                        <th>ハード</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'hard_id', 'list' => $hards])
                        </td>
                    </tr>
                    <tr>
                        <th>プラットフォーム</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'platform_id', 'list' => $platforms])
                        </td>
                    </tr>
                    <tr>
                        <th>リリース日(数値)</th>
                        <td>
                            @include ('management.common.form.input', ['type' => 'number', 'name' => 'release_at', 'options' => ['required', 'maxlength' => 20]])
                        </td>
                    </tr>
                    <tr>
                        <th>リリース日(数値)</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'release_int', 'type' => 'number', 'options' => ['required', 'max' => 99999999, 'min' => 0]])
                        </td>
                    </tr>
                    <tr>
                        <th>R-18</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'is_adult', 'list' => $ratedR])
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
            $("#hard_id").select2();
            $("#platform_id").select2();
        });
    </script>
@endsection
