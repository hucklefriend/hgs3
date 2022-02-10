@extends('layouts.management')

@section('title', 'シリーズ')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">Home</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item active">シリーズ</li>
    </ol>
    <h1 class="page-header">シリーズ</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">検索</h4>
        </div>
        <div class="panel-body">
            <form action="{{ route('管理-マスター-シリーズ') }}" method="GET">
                <div class="row mb-3">
                    <label class="form-label col-form-label col-md-3">名前</label>
                    <div class="col-md-9">
                        {{ Form::text('name', $search['name'] ?? '', ['class' => 'form-control', 'placeholder' => '名前 or よみがな(半角スペースで単語区切り)', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 offset-md-3">
                        <button type="submit" class="btn btn-sm btn-primary w-100px me-5px">検索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">一覧</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-default" data-toggle="panel-expand"><i class="fa fa-expand"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <div class="text-end">
                <a href="{{ route('管理-マスター-シリーズ登録') }}" class="btn btn-default"><i class="fas fa-plus"></i></a>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>タイトル</th>
                    <th>よみがな</th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach ($serieses as $series)
                    <tr>
                        <td>{{ $series->id }}</td>
                        <td>{{ $series->name }}</td>
                        <td>{{ $series->phonetic }}</td>
                        <td class="text-center"><a href="{{ route('管理-マスター-シリーズ詳細', $series) }}">詳細</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div>{{ $serieses->appends($search)->links() }}</div>
        </div>
    </div>
@endsection
