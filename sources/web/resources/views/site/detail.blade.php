@extends('layouts.app')

@section('title'){{ $site->name }}@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::site($site) }}@endsection

@section('content')

    <div class="content__inner">

    @if ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::WAIT)
        <div class="alert alert-warning alert-warning-hgn" role="alert">
            承認待ち状態です。<br>
            登録ユーザーさんと管理人以外には表示されません。<br>
            また、判定結果が出るまでは内容を変更することもできませんので、そのままお待ちください。
            @if (is_admin())
                <div class="text-right">
                    <a href="{{ route('サイト判定', ['site' => $site->id]) }}">ジャッジしにいく</a>
                </div>
            @endif
        </div>
    @elseif ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::REJECT)
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">登録できませんでした。</h4>
            <p>
                内容に問題があるため、登録できませんでした。<br>
                下記に記載の問題点をご確認いただき、<a href="{{ route('サイト編集', ['site' => $site->id]) }}">サイト情報を編集</a>してください。<br>
                編集を行うと、承認待ち状態に戻ります。
            </p>
            <hr>
            <p>{!! nl2br(e($site->reject_reason)) !!}</p>
        </div>
    @elseif ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::DRAFT)
        <div class="alert alert-secondary alert-secondary-hgn" role="alert">
            下書きです。<br>
            登録者ご本人さま以外は見ることができません。<br>
            内容に問題がなければ、下の方にある「登録申請」ボタンを押してください。<br>
            なお、登録申請を行うと確認されるまで登録内容の変更ができなくなりますので、ご注意ください。(削除はできます。)
        </div>
    @endif

    @include('site.common.detail')

    @if ($isWebMaster)
        <div class="card card-hgn border-info">
            <div class="card-body">
                <h4 class="card-title">登録者さま用</h4>

                @if ($site->approval_status != \Hgs3\Constants\Site\ApprovalStatus::WAIT)
                <div class="d-flex flex-wrap">
                    <span class="btn btn-light mr-2 mb-2">
                        <i class="far fa-edit"></i>&nbsp;<a href="{{ route('サイト編集', ['site' => $site->id]) }}">サイト情報を編集</a>
                    </span>
                    <span class="btn btn-light mr-2 mb-2">
                        <i class="fas fa-image"></i>&nbsp;<a href="{{ route('サイトバナー設定', ['site' => $site->id, 'isFirst' => 0]) }}">バナー設定</a>
                    </span>
                    @if ($site->rate == 18)
                    <span class="btn btn-light mr-2 mb-2">
                        🔞&nbsp;<a href="{{ route('R-18サイトバナー設定', ['site' => $site->id, 'isFirst' => 0]) }}">R-18バナー設定</a>
                    </span>
                    @endif
                    @if ($site->approval_status == \Hgs3\Constants\Site\ApprovalStatus::OK)
                    <span class="btn btn-light mr-2 mb-2">
                        <i class="fas fa-history"></i>&nbsp;<a href="{{ route('サイト更新履歴登録', ['site' => $site->id]) }}">サイト更新履歴を登録</a>
                    </span>
                    <span class="btn btn-light mr-2 mb-2">
                        <i class="fas fa-paw"></i>&nbsp;<a href="{{ route('サイトアクセスログ', ['site' => $site->id]) }}">アクセスログ</a>
                    </span>
                    @endif
                </div>
                @endif
                @if ($site->approval_status != \Hgs3\Constants\Site\ApprovalStatus::WAIT || $site->approval_status != \Hgs3\Constants\Site\ApprovalStatus::REJECT)
                <div class="d-flex flex-wrap justify-content-between mt-4">
                    <form method="POST" action="{{ route('サイト登録申請', ['site' => $site->id]) }}" onsubmit="return confirm('登録申請を行います。よろしいですね？')" style="margin: 5px 0;">
                        {{ csrf_field() }}

                        <button class="btn btn-primary btn-lg"><i class="fas fa-clipboard-check"></i>&nbsp;登録申請</button>
                    </form>
                    <div class="text-right align-self-end">
                        <form method="POST" action="{{ route('サイト削除', ['site' => $site->id]) }}" onsubmit="return confirm('{{ $site->name }}を削除します。\nよろしいですか？')" style="margin: 5px 0;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i>&nbsp;サイトを削除</button>
                        </form>
                    </div>
                </div>
                @else
                    <div class="text-right">
                        <form method="POST" action="{{ route('サイト削除', ['site' => $site->id]) }}" onsubmit="return confirm('{{ $site->name }}を削除します。\nよろしいですか？')" style="margin: 5px 0;">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                            <button class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i>&nbsp;サイトを削除</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endif
    </div>

@endsection
