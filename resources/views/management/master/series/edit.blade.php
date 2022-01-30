@extends('layouts.management')

@section('title', 'シリーズ編集')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-シリーズ') }}">シリーズ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-シリーズ詳細', $series) }}">シリーズ詳細</a></li>
        <li class="breadcrumb-item active">シリーズ編集</li>
    </ol>
    <h1 class="page-header">シリーズ編集</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $series->name }}</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-シリーズ編集処理', $series) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $series->id }}</td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $series->name) }}" required maxlength="100" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>よみがな</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', $series->phonetic) }}" required maxlength="100" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>フランチャイズ</th>
                        <td>{{ Form::select('franchise_id', $franchises, old('franchise_id', $series->franchise_id), ['class' => 'form-control' . invalid($errors, 'franchise_id'), 'id' => 'franchise_id']) }}</td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        $(()=>{
            $("#franchise_id").select2();
        });
    </script>
@endsection

