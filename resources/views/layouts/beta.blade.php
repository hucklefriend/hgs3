<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    @if (View::hasSection('title'))
        <title>@yield('title') | ホラーゲーム・ネットワーク</title>
    @else
        <title>ホラーゲームファンのためのポータルサイト</title>
    @endif
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="ホラーゲーム・ネットワーク" name="description">
    <meta content="Yuki Takeuchi" name="author">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Antique&display=swap" rel="stylesheet">
    <link href="{{ asset('beta/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('beta/css/app.min.css') }}" rel="stylesheet">
    <link href="{{ asset('beta/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .form-control, .select2.select2-container .selection .select2-selection.select2-selection--multiple, .select2.select2-container .selection .select2-selection.select2-selection--single {
            background-color: rgba(0, 0, 0, 0.5) !important;
            color: white !important;
        }
    </style>
</head>
<body>
<div class="app-cover"></div>
<div id="loader" class="app-loader"><span class="spinner"></span></div>
<div id="app" class="app app-header-fixed app-without-sidebar">
    <div id="header" class="app-header">
        <div class="navbar-header">
            <a href="{{ route('トップ') }}" class="navbar-brand"><span class="navbar-logo"><i class="ion-ios-cloud"></i></span> <b class="me-1">hgn</b></a>
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
            <div class="navbar-item dropdown d-none">
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
            @isset ($user)
            <div class="navbar-item navbar-user dropdown">
                <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                    <div class="image image-icon bg-gray-800 text-gray-600">
                        <i class="fa fa-user"></i>
                    </div>
                    <span>
                        <span class="d-none d-md-inline">{{ $user->name }}</span>
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
            @endif
        </div>
    </div>
    <div id="content" class="app-content">
        <div class="container">
            @hasSection('page_links') @yield('page_links') @endif
            <h1 class="page-header">
                @yield('page_title') @hasSection('page_sub_title')<small>@yield('page_sub_title')</small>@endif
            </h1>
            @hasSection('page_description')
            <p class="mb-20px">
                @yield('page_description')
            </p>
            @endif

            @yield('content')
        </div>
    </div>
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top" data-toggle="scroll-to-top"><i class="fa fa-angle-up"></i></a>
</div>
<script src="{{ asset('beta/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('beta/js/vendor.min.js') }}"></script>
<script src="{{ asset('beta/plugins/autosize/dist/autosize.min.js') }}"></script>
<script src="{{ asset('beta/plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('beta/js/app.min.js') }}"></script>
<script>
    $(()=>{
        autosize($('.textarea-autosize'));
    });
</script>
@yield('js')
</body>
</html>