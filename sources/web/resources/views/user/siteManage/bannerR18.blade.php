@extends('layouts.app')

@section('title')R-18サイトバナー設定@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteBannerR18($site) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>R-18サイトバナー設定</h1>
        </header>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($isFirst)
        <div class="mb-4 py-2">
            <a href="{{ route('サイト詳細', ['site' => $site->id]) }}">R-18バナーを設定せずにスキップ</a>
        </div>
        @endif

        <form method="POST" action="{{ route('サイトバナー設定処理', ['site' => $site->id]) }}" enctype="multipart/form-data" autocomplete="off">
            @include('user.siteManage.common.banner')

            <div class="form-group text-center text-md-left mt-5">
                <button class="btn btn-primary">下書き保存して確認画面へ</button>
                @if ($isFirst)
                    <p class="text-muted mt-2">
                        <small>この時点ではまだ公開されません。</small>
                    </p>
                @endif
            </div>
        </form>
    </div>

@endsection
