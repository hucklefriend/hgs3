@extends('layouts.app')

@section('title')設定@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('マイページ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>設定</h1>
        </header>

        <div class="row">
            <div class="col-6 col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">公開範囲</h5>
                            <div>
                                <a href="{{ route('プロフィール公開範囲設定') }}"><i class="fas fa-edit"></i>編集</a>
                            </div>
                        </div>

                        @if ($user->open_profile_flag == 0)
                            <p class="mb-0">公開しない</p>
                        @elseif ($user->open_profile_flag == 1)
                            <p class="mb-0">メンバーのみ</p>
                        @elseif ($user->open_profile_flag == 2)
                            <p class="mb-0">誰にでも</p>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">年齢制限</h5>
                            <div>
                                <a href="{{ route('R-18表示設定') }}"><i class="fas fa-edit"></i>変更</a>
                            </div>
                        </div>

                        @if ($user->isAdult())
                            <p class="mb-0">👌表示する</p>
                        @else
                            <p class="mb-0">🔞表示しない</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">アイコン</h5>
                            <div>
                                <a href="{{ route('アイコン変更') }}"><i class="fas fa-edit"></i>編集</a>
                            </div>
                        </div>

                        <div class="text-center">
                            <img src="{{ user_icon_url($user, true) }}" style="max-width: 5rem;max-height: 5rem;">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">足あと</h5>
                            <div>
                                <a href="{{ route('足あと設定') }}"><i class="fas fa-edit"></i>変更</a>
                            </div>
                        </div>

                        @if ($user->footprint == 1)
                            <p class="mb-0">残す</p>
                        @else
                            <p class="mb-0">残さない</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">プロフィール</h5>
                            <div>
                                <a href="{{ route('プロフィール編集') }}"><i class="fas fa-edit"></i>編集</a>
                            </div>
                        </div>

                        <table>
                            <tr>
                                <th class="p-2">名前</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">属性</th>
                                <td>
                                    @empty($attributes)
                                        <p class="text-muted mb-0">属性を設定していません。</p>
                                    @else
                                        @foreach ($attributes as $attr)
                                            <div class="user-attribute">{{ \Hgs3\Constants\User\Attribute::$text[$attr] }}</div>
                                        @endforeach
                                    @endempty
                                </td>
                            </tr>
                            <tr>
                                <th class="p-2">自己紹介</th>
                                @if (strlen($user->profile) == 0)
                                    <td class="text-muted">自己紹介を書いていません。</td>
                                @else
                                    <td>{!! nl2br(e($user->profile)) !!}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">プロフィール</h5>
                            <div>
                                <a href="{{ route('プロフィール編集') }}"><i class="fas fa-edit"></i>編集</a>
                            </div>
                        </div>

                        <table>
                            <tr>
                                <th class="p-2">名前</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th class="p-2">自己紹介</th>
                                @if (strlen($user->profile) == 0)
                                <td class="text-muted">自己紹介を書いていません。</td>
                                @else
                                <td>{!! nl2br(e($user->profile)) !!}</td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        <div class="col-sm-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title">外部サイト連携</h5>
                        <div>
                            <a href="{{ route('SNS認証設定') }}"><i class="fas fa-edit"></i>編集</a>
                        </div>
                    </div>

                    <div>
                        @if ($snsAccounts->isEmpty())
                            連携している外部サイトはありません。
                        @else
                            連携中&nbsp;
                            @foreach ($snsAccounts as $sns)
                                {{ \Hgs3\Constants\SocialSite::getIcon($sns->social_site_id) }}
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
            <div class="col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">

                        @if (!$user->isRegisteredMailAuth())
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">メール認証</h5>
                            <div>
                                <a href="{{ route('メール認証設定') }}"><i class="far fa-envelope"></i><i class="fas fa-key"></i>設定</a>
                            </div>
                        </div>
                        @else
                            <h5 class="card-title">メール認証</h5>
                        @endif


                        @if ($user->isRegisteredMailAuth())
                        <div class="d-flex justify-content-between mb-2">
                            <div class="force-break align-self-center"><i class="far fa-envelope"></i>&nbsp;{{ $user->email }}</div>
                            <div>
                                <a href="{{ route('メールアドレス変更') }}" class="btn btn-light btn--icon"><i class="fas fa-pencil-alt"></i></a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="force-break align-self-center"><i class="fas fa-key"></i>&nbsp;(パスワードは表示できません)</div>
                            <div>
                                <a href="{{ route('パスワード変更') }}" class="btn btn-light btn--icon"><i class="fas fa-pencil-alt"></i></a>
                            </div>
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
                            <p class="mb-0">設定していません。</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">退会</h4>
                        <div class="text-center"><a href="{{ route('退会') }}" class="btn btn-sm btn-danger">退会はこちらへ</a></div>
                    </div>
                </div>
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