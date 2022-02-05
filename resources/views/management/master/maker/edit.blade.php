@extends('layouts.management')

@section('title', 'メーカー編集')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-メーカー') }}">メーカー</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-メーカー詳細', $maker) }}">メーカー詳細</a></li>
        <li class="breadcrumb-item active">メーカー編集</li>
    </ol>
    <h1 class="page-header">メーカー編集</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $maker->name }}</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-メーカー編集処理', $maker) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $maker->id }}</td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'name', 'value' => $maker->name, 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>略称</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'acronym', 'value' => $maker->acronym, 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>よみがな</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'phonetic', 'value' => $maker->phonetic, 'options' => ['required', 'maxlength' => 100]])
                        </td>
                    </tr>
                    <tr>
                        <th>公式サイトURL</th>
                        <td>
                            @include ('management.common.form.input', ['type' => 'url', 'name' => 'url', 'value' => $maker->url, 'options' => ['required', 'maxlength' => 300]])
                        </td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </form>
    </div>
@endsection
