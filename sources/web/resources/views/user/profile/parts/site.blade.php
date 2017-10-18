@foreach ($sites as $s)
    @include('site.common.normal', ['s' => $s, 'noUser' => true])
    @if (!$loop->last) <hr> @endif
@endforeach

@if ($isMyself && count($sites) < 3)
    @if (count($sites) > 0) <hr> @endif
    <button class="btn btn-link btn-block">
        <a href="{{ url2('site/add') }}">サイトを追加する</a>
    </button>
@endif
<br>
