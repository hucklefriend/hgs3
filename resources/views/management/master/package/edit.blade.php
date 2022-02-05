@extends('layouts.management')

@section('title', 'パッケージ編集')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ') }}">パッケージ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ詳細', $maker) }}">パッケージ詳細</a></li>
        <li class="breadcrumb-item active">パッケージ編集</li>
    </ol>
    <h1 class="page-header">パッケージ編集</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $maker->name }}</h4>
        </div>

        <form method="POST" action="{{ route('管理-マスター-パッケージ編集処理', $maker) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>名前</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'name', 'value' => $package->name, 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>略称</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'acronym', 'value' => $package->acronym, 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>メーカー</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'maker_id', 'value' => $package->maker_id, 'list' => $makers])
                        </td>
                    </tr>
                    <tr>
                        <th>ハード</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'hard_id', 'value' => $package->hard_id, 'list' => $hards])
                        </td>
                    </tr>
                    <tr>
                        <th>プラットフォーム</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'platform_id', 'value' => $package->platform_id, 'list' => $platforms])
                        </td>
                    </tr>
                    <tr>
                        <th>リリース日(数値)</th>
                        <td>
                            @include ('management.common.form.input', ['type' => 'number', 'name' => 'release_at', 'value' => $package->release_at, 'options' => ['required', 'maxlength' => 20]])
                        </td>
                    </tr>
                    <tr>
                        <th>リリース日(数値)</th>
                        <td>
                            @include ('management.common.form.input', ['type' => 'number', 'name' => 'release_int', 'value' => $package->release_int, 'options' => ['required', 'max' => 99999999, 'min' => 0]])
                        </td>
                    </tr>
                    <tr>
                        <th>R-18</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'is_adult', 'value' => $package->is_adult, 'list' => $ratedR])
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