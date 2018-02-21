@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('マイページ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')
    <h1>設定</h1>

    <div class="row">
        <div class="col-sm-6 mb-5">
            <div class="border border-dark rounded p-2">
                <h5>プロフィール</h5>

                <a href="{{ route('プロフィール編集') }}" class="btn btn-sm btn-outline-dark border-0 d-block pt-2 pb-2">
                    <div class="d-flex justify-content-between">
                        <div class="align-self-start text-left pr-3">
                            <div>{{ $user->name }}さん</div>
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
        <div class="col-sm-6 mb-5">
            <div class="border border-dark rounded p-2">
                <h5>アイコン</h5>
                <a href="{{ route('アイコン変更') }}" class="btn btn-sm btn-outline-dark border-0 d-block pt-2 pb-2">
                    <div class="d-flex justify-content-between">
                        <div class="pr-3">
                            @include('user.common.icon', ['isLarge' => true, 'u' => $user])
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 mb-5">
            <div class="border border-dark rounded p-2">
                <h5>SNS認証</h5>
                <a href="{{ route('SNS認証設定') }}" class="btn btn-sm btn-outline-dark border-0 d-block mb-2 pt-2 pb-2">
                    <div class="d-flex justify-content-between">
                        <div class="pr-3">
                            <div>
                                @if ($snsAccounts->isEmpty())
                                    未設定
                                @else
                                    連携中&nbsp;
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
        </div>
        <div class="col-sm-6 mb-5">
            <div class="border border-dark rounded p-2">
                <h5>メール認証</h5>
                @if ($user->isRegisteredMailAuth())
                <div>
                    <a href="{{ route('メールアドレス変更') }}" class="btn btn-sm btn-outline-dark border-0 d-block mb-2 pt-2 pb-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <i class="far fa-envelope"></i>&nbsp;{{ $user->email }}
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('パスワード変更') }}" class="btn btn-sm btn-outline-dark border-0 d-block pt-2 pb-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <i class="fas fa-key"></i>&nbsp;(パスワードは表示できません)
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
                    @if ($snsAccounts->isNotEmpty())
                <div class="mt-3">
                    <form method="POST" action="{{ route('メール認証設定削除') }}" onsubmit="return confirm('メール認証設定を削除します。')">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-sm btn-danger">削除</button>
                    </form>
                </div>
                    @endif
                @else
                    <a href="{{ route('メール認証設定') }}" class="btn btn-sm btn-outline-dark border-0 d-block pt-2 pb-2">
                        <div class="d-flex justify-content-between">
                            <div>未設定</div>
                            <div class="align-self-center">
                                <i class="fas fa-angle-right"></i>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
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