<div class="card">
    <div class="card-body">

@if ($goodSites->count() == 0)
    いいねしたサイトはありません。
@endif
@foreach ($goodSites as $fs)
    @isset($sites[$fs->site_id])
        @php $s = $sites[$fs->site_id]; $u = $users[$s->user_id]; @endphp
    <div class="mb-5">
        <div class="mb-2">
            いいねした日 {{ format_date(strtotime($fs->good_at)) }}
        </div>

        @include('site.common.minimal', ['s' => $s])
        <div class="d-flex align-content-start flex-wrap site-info mt-1">
            <div class="mr-2"><i class="far fa-user"></i> <a href="{{ route('プロフィール', ['showId' => $u->show_id]) }}">{{ $u->name }}</a></div>
            @if ($s->updated_timestamp > 0)
                <div><i class="fas fa-redo-alt"></i> {{ format_date($s->updated_timestamp) }}</div>
            @endif
        </div>
    </div>
    @endisset
@endforeach

@include('common.pager', ['pager' => $goodSites])
    </div>
</div>