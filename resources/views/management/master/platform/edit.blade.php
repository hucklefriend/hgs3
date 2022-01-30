@extends('layouts.management')

@section('title', 'プラットフォーム編集')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-プラットフォーム') }}">プラットフォーム</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-プラットフォーム詳細', $platform) }}">プラットフォーム詳細</a></li>
        <li class="breadcrumb-item active">プラットフォーム編集</li>
    </ol>
    <h1 class="page-header">プラットフォーム編集</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">{{ $platform->name }}</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-プラットフォーム編集処理', $platform) }}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $platform->id }}</td>
                    </tr>
                    <tr>
                        <th>名前</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $platform->name) }}" required maxlength="200"></td>
                    </tr>
                    <tr>
                        <th>略称</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', $platform->acronym) }}" required maxlength="30"></td>
                    </tr>
                    <tr>
                        <th>メーカー</th>
                        <td>{{ Form::select('maker_id', $makers, old('maker_id', $platform->maker_id), ['class' => 'form-control' . invalid($errors, 'maker_id'), 'id' => 'maker_id']) }}</td>
                    </tr>
                    <tr>
                        <th>表示順</th>
                        <td><input type="number" class="form-control{{ invalid($errors, 'sort_order') }}" id="sort_order" name="sort_order" value="{{ old('sort_order', $platform->sort_order) }}" required autocomplete="off"></td>
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
            $("#maker_id").select2();
        });
    </script>
@endsection