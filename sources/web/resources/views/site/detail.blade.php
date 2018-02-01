@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('サイトトップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    @if ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::WAIT)
        <div class="alert alert-warning" role="alert">
            承認待ち状態です。登録者と管理人以外には表示されません。
        </div>
    @elseif ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::REJECT)
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">登録できませんでした。</h4>
            <p>
                内容に問題があるため、登録できませんでした。<br>
                下記に記載の問題点をご確認いただき、サイト情報を修正してください。
            </p>
            <hr>
            <p>{!! nl2br(e($site->reject_reason)) !!}</p>
        </div>
    @endif

    @include('site.common.detail')

    @if ($isWebMaster)
        <div class="card card-hgn border-info">
            <div class="card-body">
                <h5 class="card-title">管理人さま用</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="{{ route('サイト編集', ['site' => $site->id]) }}">サイト情報を編集</a></li>
                <li class="list-group-item"><a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}">アクセスログ</a></li>
                <li class="list-group-item text-right">
                    <form method="POST" action="{{ route('サイト削除', ['site' => $site->id]) }}" onsubmit="return confirm('{{ $site->name }}を削除します。\nよろしいですか？')" style="margin: 5px 0;">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button class="btn btn-danger btn-sm">サイトを削除</button>
                    </form>
                </li>
            </ul>
        </div>
    @endif
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト詳細</li>
        </ol>
    </nav>
@endsection