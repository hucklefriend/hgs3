
<nav class="nav nav-pills flex-column">
    <a class="nav-link @if($active == 'タイムライン') active @endif" href="#">タイムライン</a>
    <a class="nav-link @if($active == '新着') active @endif" href="#">新着</a>
    <a class="nav-link @if($active == '更新') active @endif" href="#">更新</a>
    <a class="nav-link @if($active == 'ランキング') active @endif" href="#">ランキング</a>
    <a class="nav-link @if($active == 'ゲームソフト一覧') active @endif" href="#">ゲームソフト一覧</a>
</nav>

@if ($yourSites != null && $yourSites->count() > 0)
<nav class="nav nav-pills flex-column">
    <span>あなたのサイト</span>
    <a class="nav-link @if($active == '新着') active @endif" href="#">新着</a>
    <a class="nav-link @if($active == '更新') active @endif" href="#">更新</a>
    <a class="nav-link @if($active == 'ランキング') active @endif" href="#">ランキング</a>
    <a class="nav-link @if($active == 'ゲームソフト一覧') active @endif" href="#">ゲームソフト一覧</a>
</nav>
@endif

