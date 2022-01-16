@extends('layouts.management')

@section('title', 'ハード編集')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-ハード') }}">ハード</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-ハード詳細', $hard) }}">ハード詳細</a></li>
        <li class="breadcrumb-item active">ハード編集</li>
    </ol>
    <h1 class="page-header">ハード編集</h1>
    <form method="POST" action="{{ route('管理-マスター-ハード編集処理', $hard) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">{{ $hard->name }}</h4>
            </div>
            <div class="panel-body">

                    <table class="table">
                        <tr>
                            <th>ID</th>
                            <td>{{ $hard->id }}</td>
                        </tr>
                        <tr>
                            <th>名前</th>
                            <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $hard->name) }}" required maxlength="200"></td>
                        </tr>
                        <tr>
                            <th>よみがな</th>
                            <td><input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', $hard->phonetic) }}" required maxlength="200"></td>
                        </tr>
                        <tr>
                            <th>略称</th>
                            <td><input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', $hard->acronym) }}" required maxlength="200"></td>
                        </tr>
                        <tr>
                            <th>表示順</th>
                            <td><input type="number" class="form-control{{ invalid($errors, 'sort_order') }}" id="sort_order" name="sort_order" value="{{ old('sort_order', $hard->sort_order) }}" required min="0" max="99999999"></td>
                        </tr>
                        <tr>
                            <th>メーカー</th>
                            <td>{{ Form::select('maker_id', $makers, old('maker_id', $hard->maker_id), ['class' => 'form-control' . invalid($errors, 'maker_id'), 'id' => 'maker_id']) }}</td>
                        </tr>
                    </table>
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">更新</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        $(()=>{
            $("#maker_id").select2();
        });
    </script>
@endsection