@extends('layouts.app')

@section('title')承認待ちサイト@endsection
@section('global_back_link'){{ route('承認待ちサイト一覧') }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>承認判定</h1>
        </header>

        @include('site.common.detail')

        <div class="row" style="margin-top:2rem;">
            <div class="col-sm-6">
                <form action="{{ route('サイト承認', ['site' => $site->id]) }}" method="POST" onsubmit="return confirm('承認します')" class="mb-5">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    <button type="submit" class="btn btn-block btn-primary">承認</button>
                </form>
            </div>
            <div class="col-sm-6">
                <form action="{{ route('サイト拒否', ['site' => $site->id]) }}" method="POST" onsubmit="return confirm('否認します')">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="form-group">
                        <label for="message" class="hgn-label"><i class="fas fa-edit"></i> 拒否理由</label>
                        <textarea class="form-control textarea-autosize{{ invalid($errors, 'message') }}" id="message" name="message">{{ old('message') }}</textarea>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        @include('common.error', ['formName' => 'message'])
                    </div>
                    <button type="submit" class="btn btn-block btn-danger">拒否</button>
                </form>
            </div>
        </div>
    </div>
@endsection
