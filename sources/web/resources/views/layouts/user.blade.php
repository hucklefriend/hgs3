<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title') {{ env('APP_NAME') }} (β)</title>

        <link rel="stylesheet" href="{{ url('css/super_admin.min.css') }}">
        <link rel="stylesheet" href="{{ url('vendors/bower_components/animate.css/animate.min.css') }}">
        @if (env('APP_ENV') != 'production')
            <link rel="stylesheet" href="{{ url('css/hgs3sa.css') }}?ver={{ time() }}">
        @else
            <link rel="stylesheet" href="{{ url('css/hgs3sa.css') }}?ver=20180519">
        @endif

        <script src="{{ url('/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ url('/js/fontawesome-all.min.js') }}" defer></script>
        <script src="{{ url('vendors/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ url('/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ url('/vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ url('/vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
        <script src="{{ url('/js/super_admin.min.js') }}"></script>
        <script src="{{ url('/js/common.js') }}"></script>

        @yield('head_append')

        @if (env('APP_ENV') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114831632-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-114831632-1');
        </script>
        @endif
    </head>
    <body data-sa-theme="5">
        <main class="main">
            <header class="header">
                <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
                    <i class="zmdi zmdi-menu"></i>
                </div>

                <div class="global-link hidden-sm-down">
                    @if (View::hasSection('global_back_link'))
                        <a href="@yield('global_back_link')" class="d-flex justify-content-center">
                            <i class="fas fa-angle-left align-self-center"></i>
                        </a>
                    @endif
                </div>
                <div class="logo hidden-sm-down">
                    @if (env('APP_ENV') == 'staging')
                        <h1><a href="{{ route('トップ') }}">STG</a></h1>
                    @else
                        <h1><a href="{{ route('トップ') }}">β版</a></h1>
                    @endif
                </div>

                <ul class="top-nav">

                    <li class="hidden-xs-down">
                        <a href="{{ route('ゲーム一覧') }}">ゲーム</a>
                    </li>

                    <li class="hidden-xs-down">
                        <a href="{{ route('サイトトップ') }}">サイト</a>
                    </li>

                    @if (is_admin())
                        <li class="hidden-xs-down">
                            <a href="{{ route('管理メニュー') }}">管理メニュー</a>
                        </li>
                    @endif

                    @if (Auth::check())
                        <li class="hidden-xs-down">
                            <a href="{{ route('マイページ') }}">マイページ</a>
                        </li>
                    @else
                        <li class="hidden-xs-down">
                            <a href="{{ route('ログイン') }}">ログイン</a>
                        </li>
                    @endif

                    <li class="dropdown hidden-sm-up">
                        <a href="#" data-toggle="dropdown" aria-expanded="false"><i class="fas fa-bars"></i></a>

                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; transform: translate3d(-112px, 37px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <a href="{{ route('ゲーム一覧') }}" class="dropdown-item">ゲーム</a>
                            <a href="{{ route('サイトトップ') }}" class="dropdown-item">サイト</a>
                            @if (Auth::check())
                                @if (is_admin())
                                    <a href="{{ route('管理メニュー') }}" class="dropdown-item">管理メニュー</a>
                                @endif
                            <a href="{{ route('マイページ') }}" class="dropdown-item">マイページ</a>
                            @else
                            <a href="{{ route('ログイン') }}" class="dropdown-item">ログイン</a>
                            @endif
                        </div>
                    </li>

                </ul>
            </header>

            <aside class="sidebar">
                <div class="scrollbar-inner">

                    <div class="user">
                        <div class="user__info" data-toggle="dropdown">
                            @include('user.common.icon', ['u' => Auth::user()])
                            <div>
                                <div class="user__name">Malinda Hollaway</div>
                                <div class="user__email">malinda-h@gmail.com</div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="">View Profile</a>
                            <a class="dropdown-item" href="">Settings</a>
                            <a class="dropdown-item" href="">Logout</a>
                        </div>
                    </div>

                    <ul class="navigation">
                        <li class="navigation__active"><a href="index.html"><i class="zmdi zmdi-home"></i> Home</a></li>

                        <li class="navigation__sub @@variantsactive">
                            <a href=""><i class="zmdi zmdi-view-week"></i> Variants</a>

                            <ul>
                                <li class="@@sidebaractive"><a href="hidden-sidebar.html">Hidden Sidebar</a></li>
                                <li class="@@boxedactive"><a href="boxed-layout.html">Boxed Layout</a></li>
                                <li class="@@hiddensidebarboxedactive"><a href="hidden-sidebar-boxed-layout.html">Boxed Layout with Hidden Sidebar</a></li>
                            </ul>
                        </li>

                        <li class="@@typeactive"><a href="typography.html"><i class="zmdi zmdi-format-underlined"></i> Typography</a></li>

                        <li class="@@widgetactive"><a href="widgets.html"><i class="zmdi zmdi-widgets"></i> Widgets</a></li>

                        <li class="navigation__sub @@tableactive">
                            <a href=""><i class="zmdi zmdi-view-list"></i> Tables</a>

                            <ul>
                                <li class="@@normaltableactive"><a href="html-table.html">HTML Table</a></li>
                                <li class="@@datatableactive"><a href="data-table.html">Data Table</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@formactive">
                            <a href=""><i class="zmdi zmdi-collection-text"></i> Forms</a>

                            <ul>
                                <li class="@@formelementactive"><a href="form-elements.html">Basic Form Elements</a></li>
                                <li class="@@formcomponentactive"><a href="form-components.html">Form Components</a></li>
                                <li class="@@formvalidationactive"><a href="form-validation.html">Form Validation</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@uiactive">
                            <a href=""><i class="zmdi zmdi-swap-alt"></i> User Interface</a>

                            <ul>
                                <li class="@@colorsactive"><a href="colors.html">Colors</a></li>
                                <li class="@@cssanimationsactive"><a href="css-animations.html">CSS Animations</a></li>
                                <li class="@@buttonsactive"><a href="buttons.html">Buttons</a></li>
                                <li class="@@iconsactive"><a href="icons.html">Icons</a></li>
                                <li class="@@listviewactive"><a href="listview.html">Listview</a></li>
                                <li class="@@toolbarsactive"><a href="toolbars.html">Toolbars</a></li>
                                <li class="@@cardsactive"><a href="cards.html">Cards</a></li>
                                <li class="@@alertactive"><a href="alerts.html">Alerts</a></li>
                                <li class="@@badgesactive"><a href="badges.html">Badges</a></li>
                                <li class="@@breadcrumbsactive"><a href="breadcrumbs.html">Bredcrumbs</a></li>
                                <li class="@@jumbotronactive"><a href="jumbotron.html">Jumbotron</a></li>
                                <li class="@@navsactive"><a href="navs.html">Navs</a></li>
                                <li class="@@paginationactive"><a href="pagination.html">Pagination</a></li>
                                <li class="@@progressactive"><a href="progress.html">Progress</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@componentsactive">
                            <a href=""><i class="zmdi zmdi-group-work"></i> Javascript Components</a>

                            <ul class="navigation__sub">
                                <li class="@@carouselactive"><a href="carousel.html">Carousel</a></li>
                                <li class="@@collapseactive"><a href="collapse.html">Collapse</a></li>
                                <li class="@@dropdownsactive"><a href="dropdowns.html">Dropdowns</a></li>
                                <li class="@@modalsactive"><a href="modals.html">Modals</a></li>
                                <li class="@@popoveractive"><a href="popover.html">Popover</a></li>
                                <li class="@@tabsactive"><a href="tabs.html">Tabs</a></li>
                                <li class="@@tooltipsactive"><a href="tooltips.html">Tooltips</a></li>
                                <li class="@@notificationsactive"><a href="notifications-alerts.html">Notifications & Alerts</a></li>
                                <li class="@@treeactive"><a href="treeview.html">Tree View</a></li>
                            </ul>
                        </li>

                        <li class="navigation__sub @@chartsactive">
                            <a href=""><i class="zmdi zmdi-trending-up"></i> Charts</a>

                            <ul>
                                <li class="@@flotchartsactive"><a href="flot-charts.html">Flot</a></li>
                                <li class="@@otherchartsactive"><a href="other-charts.html">Other Charts</a></li>
                            </ul>
                        </li>

                        <li class="@@calendaractive"><a href="calendar.html"><i class="zmdi zmdi-calendar"></i> Calendar</a></li>

                        <li class="@@photogalleryactive"><a href="photo-gallery.html"><i class="zmdi zmdi-image"></i> Photo Gallery</a></li>

                        <li class="navigation__sub @@samplepagesactive">
                            <a href=""><i class="zmdi zmdi-collection-item"></i> Sample Pages</a>

                            <ul>
                                <li class="@@profileactive"><a href="profile-about.html">Profile</a></li>
                                <li class="@@messagesactive"><a href="messages.html">Messages</a></li>
                                <li class="@@contactsactive"><a href="contacts.html">Contacts</a></li>
                                <li class="@@newcontactsactive"><a href="new-contact.html">New Contact</a></li>
                                <li class="@@groupsactive"><a href="groups.html">Groups</a></li>
                                <li class="@@pricingtablesactive"><a href="pricing-tables.html">Pricing Tables</a></li>
                                <li class="@@invoiceactive"><a href="invoice.html">Invoice</a></li>
                                <li class="@@todoactive"><a href="todo-lists.html">Todo Lists</a></li>
                                <li class="@@notesactive"><a href="notes.html">Notes</a></li>
                                <li class="@@searchresultsactive"><a href="search-results.html">Search Results</a></li>
                                <li class="@@issuesactive"><a href="issue-tracker.html">Issues Tracker</a></li>
                                <li class="@@faqactive"><a href="faq.html">FAQ</a></li>
                                <li class="@@teamactive"><a href="team.html">Team</a></li>
                                <li class="@@blogactive"><a href="blog.html">Blog</a></li>
                                <li class="@@blogdetailactive"><a href="blog-detail.html">Blog Detail</a></li>
                                <li class="@@qaactive"><a href="questions-answers.html">Questions & Answers</a></li>
                                <li class="@@qadetailactive"><a href="questions-answers-details.html">Questions & Answers Details</a></li>
                                <li class="@@loginactive"><a href="login.html">Login & SignUp</a></li>
                                <li class="@@lockscreenactive"><a href="lockscreen.html">Lockscreen</a></li>
                                <li class="@@lockscreenactive"><a href="404.html">404</a></li>
                                <li class="@@emptyactive"><a href="empty.html">Empty Page</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </aside>

            <section class="content">
                @yield('content')
            </section>

            <footer class="footer">
                <div style="overflow: hidden;">@yield('breadcrumb')</div>
                <div style="white-space: nowrap;" class="text-right">
                    <a href="{{ route('サイトマップ') }}" class="align-self-center">サイトマップ</a>
                </div>
                <div style="height: 40px;line-height: 40px;" class="text-left;">
                    &copy; yu-ki
                    <a href="mailto:{{ env('ADMIN_MAIL') }}" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::MAIL) }}</a>
                    <a href="https://twitter.com/huckle_friend" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::TWITTER) }}</a>
                    <a href="https://github.com/hucklefriend/hgs3" target="_blank">{{ sns_icon(\Hgs3\Constants\SocialSite::GITHUB) }}</a>
                    / since 2003.9.28
                </div>
            </footer>

            @yield('outsideContent')
        </main>
    </body>
</html>
