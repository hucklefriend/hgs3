@extends('layouts.management')

@section('title', 'プラットフォーム登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-プラットフォーム') }}">プラットフォーム</a></li>
        <li class="breadcrumb-item active">プラットフォーム登録</li>
    </ol>
    <h1 class="page-header">プラットフォーム登録</h1>
    <div class="panel panel-inverse">
        <form method="POST" action="{{ route('管理-マスター-プラットフォーム登録処理') }}">
            {{ csrf_field() }}
            <div class="panel-heading">
                <h4 class="panel-title">新規登録</h4>
            </div>
            <div class="panel-body">

                <table class="table">
                    <tr>
                        <th>名前</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', '') }}" required maxlength="200" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>略称</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'acronym') }}" id="acronym" name="acronym" value="{{ old('acronym', '') }}" required maxlength="30" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>メーカー</th>
                        <td>{{ Form::select('maker_id', $makers, old('maker_id'), ['class' => 'form-control' . invalid($errors, 'maker_id'), 'id' => 'maker_id']) }}</td>
                    </tr>
                    <tr>
                        <th>表示順</th>
                        <td><input type="number" class="form-control{{ invalid($errors, 'sort_order') }}" id="sort_order" name="sort_order" value="{{ old('sort_order', '') }}" required autocomplete="off"></td>
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