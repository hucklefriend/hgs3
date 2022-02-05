@extends('layouts.management')

@section('title', 'ソフト登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-ソフト') }}">ソフト</a></li>
        <li class="breadcrumb-item active">ソフト登録</li>
    </ol>
    <h1 class="page-header">ソフト登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規登録</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-ソフト登録処理') }}">
            {{ csrf_field() }}

            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>名前</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', '') }}" required maxlength="200" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>よみがな</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'phonetic') }}" id="phonetic" name="phonetic" value="{{ old('phonetic', '') }}" required maxlength="200" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>よみがな(ソート用)</th>
                        <td>
                            <input type="text" class="form-control{{ invalid($errors, 'phonetic2') }}" id="phonetic2" name="phonetic2" value="{{ old('phonetic2', '') }}" required maxlength="250" autocomplete="off">
                            @if ($errors->has('phonetic2'))
                            <div class="invalid-feedback">{{$errors->first('phonetic2')}}</div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>ジャンル</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'genre') }}" id="genre" name="genre" value="{{ old('genre', '') }}" required maxlength="150" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>シリーズ</th>
                        <td>{{ Form::select('series_id', $series, old('series_id', ''), ['class' => 'form-control' . invalid($errors, 'series_id'), 'id' => 'series_id']) }}</td>
                    </tr>
                    <tr>
                        <th>フランチャイズ</th>
                        <td>{{ Form::select('franchise_id', $franchises, old('franchise_id', ''), ['class' => 'form-control' . invalid($errors, 'franchise_id'), 'id' => 'franchise_id']) }}</td>
                    </tr>
                    <tr>
                        <th>あらすじ</th>
                        <td><textarea class="form-control{{ invalid($errors, 'introduction') }}" id="introduction" name="introduction" rows="10">{{ old('introduction') }}</textarea></td>
                    </tr>
                    <tr>
                        <th>あらすじの引用元</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'introduction_from') }}" id="introduction_from" name="introduction_from" value="{{ old('introduction_from', '') }}" required maxlength="150" autocomplete="off"></td>
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
        let series2Franchise = {!! json_encode($series2Franchise) !!};

        $(()=>{
            $("#franchise_id").select2();
            $("#series_id").select2();


            $("#series_id").change(function (){
                let seriesId = $(this).val();
                if (seriesId.length > 0) {
                    $("#franchise_id").val(series2Franchise[seriesId]);
                }
            });
        });
    </script>
@endsection
