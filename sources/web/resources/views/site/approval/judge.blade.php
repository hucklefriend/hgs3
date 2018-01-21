@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('承認待ちサイト一覧') }}">&lt;</a>
@endsection

@section('content')
    @include('site.common.detail')

    <div class="row align-items-end" style="margin-top:2rem;">
        <div class="col-6">
            <form action="{{ route('サイト承認', ['site' => $site->id]) }}" method="POST" onsubmit="return confirm('承認します')">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <button type="submit" class="btn btn-block btn-primary">承認</button>
            </form>
        </div>
        <div class="col-6">
            <form action="{{ route('サイト拒否', ['site' => $site->id]) }}" method="POST" onsubmit="return confirm('否認します')">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="form-group">
                    <label for="message">拒否理由</label>
                    <textarea class="form-control{{ invalid($errors, 'message') }}" id="message" name="message" rows="5">{{ old('message') }}</textarea>
                    @include('common.error', ['formName' => 'message'])
                </div>
                <button type="submit" class="btn btn-block btn-danger">拒否</button>
            </form>
        </div>
    </div>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb_footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">マイページ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('管理メニュー') }}">管理メニュー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('承認待ちサイト一覧') }}">サイト承認</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト承認実行</li>
        </ol>
    </nav>
@endsection