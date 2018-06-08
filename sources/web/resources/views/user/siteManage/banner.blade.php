@extends('layouts.app')

@section('title')サイトバナー設定@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteBanner($site) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイトバナー設定</h1>
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
            <a href="{{ route('サイト詳細', ['site' => $site->id]) }}">バナーを設定せずにスキップ</a>
        </div>
        @endif

        <form method="POST" action="{{ route('サイトバナー設定処理', ['site' => $site->id]) }}" enctype="multipart/form-data" autocomplete="off">
            @include('user.siteManage.common.banner')

            @if ($site->rate == 18)
                <div class="form-group text-center text-md-left mt-5">
                    <p>下書き保存して・・・</p>
                    <button class="btn btn-primary mr-3" name="">確認画面へ</button>
                    <button class="btn btn-danger" name="">R-18用バナー設定画面へ</button>
                </div>
            @else
            <div class="form-group text-center text-md-left mt-5">
                <button class="btn btn-primary">下書き保存して確認画面へ</button>
            </div>
            @endif
            @if ($site->approval_status != \Hgs3\Constants\Site\ApprovalStatus::OK)
                <p class="text-muted mt-2">
                    <small>この時点ではまだ下書き状態で、公開されることはありません</small>
                </p>
            @endif
        </form>
    </div>

@endsection
