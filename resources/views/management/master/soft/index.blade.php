@extends('layouts.management')

@section('title', 'ソフト')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">Home</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item active">ソフト</li>
    </ol>
    <h1 class="page-header">ソフト</h1>

    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">検索</h4>
        </div>
        <div class="panel-body">
            <form action="{{ route('管理-マスター-ソフト') }}" method="GET">
                <div class="row mb-3">
                    <label class="form-label col-form-label col-md-3">名前</label>
                    <div class="col-md-9">
                        {{ Form::text('name', $search['name'] ?? '', ['class' => 'form-control', 'placeholder' => '名前 or よみがな(半角スペースで単語区切り)', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="form-label col-form-label col-md-3">フランチャイズ</label>
                    <div class="col-md-9">
                        {{ Form::select('franchise', $franchises, $search['franchise'] ?? '', ['class' => 'form-control', 'id' => 'franchise']) }}
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="form-label col-form-label col-md-3">シリーズ</label>
                    <div class="col-md-9">
                        {{ Form::select('series', $series, $search['series'] ?? '', ['class' => 'form-control', 'id' => 'series']) }}
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
                <a href="{{ route('管理-マスター-ソフト登録') }}" class="btn btn-default"><i class="fas fa-plus"></i></a>
            </div>

            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>タイトル</th>
                    <th>フランチャイズ</th>
                    <th>シリーズ</th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                @foreach ($softs as $soft)
                    <tr>
                        <td>{{ $soft->id }}</td>
                        <td>{{ $soft->name }}</td>
                        <td>{{ $soft->franchise->name }}</td>
                        <td>{{ $soft->series->name ?? '' }}</td>
                        <td class="text-center"><a href="{{ route('管理-マスター-ソフト詳細', $soft) }}">詳細</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div>{{ $softs->appends($search)->links() }}</div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(()=>{
            $("#franchise").select2();
            $("#series").select2();
        });
    </script>
@endsection
