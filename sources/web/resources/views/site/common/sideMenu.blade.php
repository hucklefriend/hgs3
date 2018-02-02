
<nav class="nav nav-pills flex-column">
    <a class="nav-link @if($active == 'タイムライン') active @endif" href="{{ route('サイトタイムライン') }}">タイムライン</a>
    <a class="nav-link @if($active == '新着') active @endif" href="{{ route('新着サイト一覧') }}">新着</a>
    <a class="nav-link @if($active == '更新') active @endif" href="{{ route('更新サイト一覧') }}">更新</a>
    <a class="nav-link @if($active == 'ランキング') active @endif" href="#">ランキング</a>
    <a class="nav-link @if($active == 'ゲームソフト一覧') active @endif" href="#">ゲームソフト一覧</a>
</nav>

@if ($yourSites != null && $yourSites->count() > 0)
<nav class="nav nav-pills flex-column mt-4">
    <span>あなたのサイト</span>
    @foreach ($yourSites as $yourSite)
        <a class="nav-link" href="{{ route('サイト詳細', ['site' => $yourSite->id]) }}">{{ $yourSite->name }}</a>
    @endforeach
</nav>
@endif
