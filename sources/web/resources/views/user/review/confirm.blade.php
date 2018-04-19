@extends('layouts.app')

@section('title')レビュー投稿@endsection
@section('global_back_link'){{ route('ユーザーのレビュー', ['user' => Auth::id()]) }}@endsection

@section('content')
    <h1>レビュー投稿確認</h1>

    @if ($draft->is_spoiler == 1)
        <div></div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">{{ $soft->name }}</h5>

                    <div class="d-flex flex-wrap">
                        @if (!empty($orgPkgImg))
                        <div class="mr-2">
                            @include('game.common.packageImage', ['imageUrl' => $orgPkgImg])
                        </div>
                        @endif
                        <div>
                            <div>
                                <small><i class="fas fa-user-circle"></i>&nbsp;{{ $user->name }}さん</small>
                            </div>
                            <div>
                                <small><i class="far fa-calendar-alt"></i>&nbsp;まだ投稿していません</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">プレイ状況</h5>

                    <div><small><strong>遊んだゲーム</strong></small></div>
                    <div class="d-flex">
                        @foreach ($packages as $pkg)
                        <div class="d-flex mr-2">
                            <div style="width: 30px;" class="align-self-center text-center mr-2">
                                @include('game.common.packageImage', ['imageUrl' => small_image_url($pkg)])
                            </div>
                            <div class="align-self-center">
                                <small>{{ $pkg->name }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-3"><small><strong>どのくらい遊んだか</strong></small></div>
                    @if (!empty($draft->progress))
                        <div><small>{{ nl2br($draft->progress) }}</small></div>
                    @else
                        <div class="text-muted"><small>記入なし</small></div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    <h5 class="card-title">評価</h5>

                    <div>
                        {{ $draft->calcPoint() }}
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    進捗
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    良い点
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    悪い点
                </div>
            </div>
        </div>
    </div>

    <div class="card card-hgn">
        <div class="card-body">
            総合評価
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hgn">
                <div class="card-body">
                    レビューへの評価
                </div>
            </div>
        </div>
    </div>



    <form method="POST" action="{{ route('レビュー公開') }}" autocomplete="off">
        <input type="hidden" name="soft_id" value="{{ $soft->id }}">
        {{ csrf_field() }}

        <div class="form-group">
            <button class="btn btn-primary">公開</button>
            <p class="text-muted">
                <small>
                    レビュー公開後は、編集できなくなります。<br>
                    よくよくご確認の上、公開してください。
                </small>
            </p>
        </div>
    </form>

@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザーのレビュー', ['user' => Auth::id()]) }}">レビュー</a></li>
            <li class="breadcrumb-item active" aria-current="page">レビュー投稿</li>
        </ol>
    </nav>
@endsection
