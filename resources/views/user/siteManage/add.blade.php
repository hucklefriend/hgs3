@extends('layouts.app')

@section('title')サイト登録@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteAdd() }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト登録</h1>
            <p>サイト情報を入力してください。</p>
        </header>

        <form method="POST" action="{{ route('サイト登録処理') }}" autocomplete="off">
            {{ csrf_field() }}
            @include('user.siteManage.common.form')

            <div class="form-group text-center">
                <button class="btn btn-primary">下書き保存してバナーの登録へ</button>

                <p class="text-muted mt-2">
                    <small>この時点ではまだ公開されません。</small>
                </p>
            </div>
        </form>
        @include('user.siteManage.common.handleSoftSelect')
    </div>
@endsection
