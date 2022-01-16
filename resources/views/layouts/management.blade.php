@php
    $routeName = \Route::currentRouteName();
@endphp
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    @if (View::hasSection('title'))
        <title>@yield('title') | [運営]ホラーゲーム・ネットワーク</title>
    @else
        <title>[運営]ホラーゲーム・ネットワーク</title>
    @endif
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="ホラーゲーム・ネットワークの管理用" name="description">
    <meta content="Yuki Takeuchi" name="author">
    <link href="{{ asset('admin/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
</head>
<body>
<div class="app-cover"></div>
<div id="loader" class="app-loader"><span class="spinner"></span></div>
<div id="app" class="app app-header-fixed app-sidebar-fixed">
    <div id="header" class="app-header">
        <div class="navbar-header">
            <a href="{{ route('管理') }}" class="navbar-brand"><span class="navbar-logo"><i class="ion-ios-cloud"></i></span> <b class="me-1">hgn</b> MGR</a>
            <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-nav">
            <div class="navbar-item navbar-form d-none">
                <form action="" method="POST" name="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter keyword" />
                        <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="navbar-item dropdown">
                <a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon">
                    <i class="fa fa-bell"></i>
                    <span class="badge">0</span>
                </a>
                <div class="dropdown-menu media-list dropdown-menu-end">
                    <div class="dropdown-header">NOTIFICATIONS (0)</div>
                    <div class="text-center w-300px py-3 text-inverse">
                        No notification found
                    </div>
                </div>
            </div>
            <div class="navbar-item navbar-user dropdown">
                <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                    <div class="image image-icon bg-gray-800 text-gray-600">
                        <i class="fa fa-user"></i>
                    </div>
                    <span>
							<span class="d-none d-md-inline">Adam Schwartz</span>
							<b class="caret"></b>
						</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end me-1">
                    <a href="javascript:;" class="dropdown-item">Edit Profile</a>
                    <a href="javascript:;" class="dropdown-item"><span class="badge badge-danger float-end">2</span> Inbox</a>
                    <a href="javascript:;" class="dropdown-item">Calendar</a>
                    <a href="javascript:;" class="dropdown-item">Setting</a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:;" class="dropdown-item">Log Out</a>
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar" class="app-sidebar">
        <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
            <div class="menu">
                <div id="appSidebarProfileMenu" class="collapse">
                    <div class="menu-item pt-5px">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon"><i class="fa fa-cog"></i></div>
                            <div class="menu-text">Settings</div>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon"><i class="fa fa-pencil-alt"></i></div>
                            <div class="menu-text"> Send Feedback</div>
                        </a>
                    </div>
                    <div class="menu-item pb-5px">
                        <a href="javascript:;" class="menu-link">
                            <div class="menu-icon"><i class="fa fa-question-circle"></i></div>
                            <div class="menu-text"> Helps</div>
                        </a>
                    </div>
                    <div class="menu-divider m-0"></div>
                </div>
                <div class="menu-header">Navigation</div>
                <div class="menu-item @if ($menuCategory1 === null) active @endif">
                    <a href="{{ route('管理') }}" class="menu-link">
                        <div class="menu-icon">
                            <i class="fa fa-th-large"></i>
                        </div>
                        <div class="menu-text">Home</div>
                    </a>
                </div>

                <div class="menu-item has-sub @if ($menuCategory1 === 'システム') active @endif">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fas fa-server"></i>
                        </div>
                        <div class="menu-text">システム</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item @if ($menuCategory2 === 'お知らせ') active @endif"><a href="{{ route('管理-システム-お知らせ') }}" class="menu-link"><div class="menu-text">お知らせ</div></a></div>
                        <div class="menu-item @if ($menuCategory2 === '新着情報') active @endif"><a href="javascript:;" class="menu-link"><div class="menu-text">新着情報</div></a></div>
                    </div>
                </div>

                <div class="menu-item has-sub @if ($menuCategory1 === 'マスター') active @endif">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <div class="menu-text">マスター</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item @if ($menuCategory2 === 'メーカー') active @endif"><a href="{{ route('管理-マスター-メーカー') }}" class="menu-link"><div class="menu-text">メーカー</div></a></div>
                        <div class="menu-item @if ($menuCategory2 === 'プラットフォーム') active @endif"><a href="{{ route('管理-マスター-プラットフォーム') }}" class="menu-link"><div class="menu-text">プラットフォーム</div></a></div>
                        <div class="menu-item @if ($menuCategory2 === 'ハード') active @endif"><a href="{{ route('管理-マスター-ハード') }}" class="menu-link"><div class="menu-text">ハード</div></a></div>
                        <div class="menu-item @if ($menuCategory2 === 'フランチャイズ') active @endif"><a href="{{ route('管理-マスター-フランチャイズ') }}" class="menu-link"><div class="menu-text">フランチャイズ</div></a></div>
                        <div class="menu-item @if ($menuCategory2 === 'シリーズ') active @endif"><a href="{{ route('管理-マスター-シリーズ') }}" class="menu-link"><div class="menu-text">シリーズ</div></a></div>
                        <div class="menu-item @if ($menuCategory2 === 'ソフト') active @endif"><a href="{{ route('管理-マスター-ソフト') }}" class="menu-link"><div class="menu-text">ソフト</div></a></div>
                        <div class="menu-item @if ($menuCategory2 === 'パッケージ') active @endif"><a href="{{ route('管理-マスター-パッケージ') }}" class="menu-link"><div class="menu-text">パッケージ</div></a></div>
                    </div>
                </div>

                <div class="menu-item has-sub">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="menu-text">ユーザー</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu">
                        <div class="menu-item"><a href="javascript:;" class="menu-link"><div class="menu-text">ユーザー</div></a></div>
                        <div class="menu-item"><a href="javascript:;" class="menu-link"><div class="menu-text">サイト</div></a></div>
                        <div class="menu-item"><a href="javascript:;" class="menu-link"><div class="menu-text">レビュー</div></a></div>
                    </div>
                </div>
                <div class="menu-item d-flex">
                    <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="app-sidebar-bg"></div>
    <div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
    <div id="content" class="app-content">
        @yield('content')
    </div>
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
</div>
<script src="{{ asset('admin/js/vendor.min.js') }}"></script>
<script src="{{ asset('admin/plugins/autosize/dist/autosize.min.js') }}"></script>
<script src="{{ asset('admin/plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('admin/js/app.min.js') }}"></script>
<script src="{{ asset('admin/js/transparent.min.js') }}"></script>
<script>
    $(()=>{
        autosize($('.textarea-autosize'));
    });
</script>
@yield('js')
</body>
</html>