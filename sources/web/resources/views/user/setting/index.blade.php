@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('マイページ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>設定</h1>

    <div class="row">
        <div class="col-sm-6 mb-5">
            <a href="{{ route('アイコン変更') }}" class="btn btn-outline-dark d-block">
                <div class="d-flex justify-content-between">
                    <div class="pr-3">
                        @include('user.common.icon', ['isLarge' => true, 'u' => $user])
                        アイコン
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 mb-5">
            <a href="{{ route('プロフィール編集') }}" class="btn btn-outline-dark d-block">
                <div class="d-flex justify-content-between">
                    <div class="align-self-start text-left pr-3">
                        <h5>プロフィール</h5>
                        <div style="word-break: break-all;white-space: normal;"><small>{{ str_limit($user->profile, 100) }}</small></div>
                        <div>
                            <small>
                                @if ($user->adult == 1)
                                    <i class="far fa-square"></i>
                                @else
                                    <i class="far fa-check-square"></i>
                                @endif
                                18歳以上
                            </small>
                        </div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6 mb-5">
            <a href="{{ route('SNS認証設定') }}" class="btn btn-outline-dark d-block">
                <div class="d-flex justify-content-between">
                    <div class="pr-3">
                        <h5>SNS認証</h5>
                        <div>
                        @if ($snsAccounts->isEmpty())
                            未設定
                        @else
                            @foreach ($snsAccounts as $sns)
                                {{ \Hgs3\Constants\SocialSite::getIcon($sns->social_site_id) }}
                            @endforeach
                        @endif
                        </div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 mb-5">
            <a href="{{ route('プロフィール編集') }}" class="btn btn-outline-dark d-block">
                <div class="d-flex justify-content-between">
                    <div class="align-self-start text-left pr-3">
                        <h5>メール認証</h5>
                        <div style="word-break: break-all;white-space: normal;"><small>{{ str_limit($user->profile, 100) }}</small></div>
                        <div>
                            <small>
                                @if ($user->adult == 1)
                                    <i class="far fa-square"></i>
                                @else
                                    <i class="far fa-check-square"></i>
                                @endif
                                18歳以上
                            </small>
                        </div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>



@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item active" aria-current="page">設定</li>
        </ol>
    </nav>
@endsection