<div class="card">
    <div class="card-body">

@if ($goodSites->count() == 0)
    いいねしたサイトはありません。
@endif
@foreach ($goodSites as $fs)
    @isset($sites[$fs->site_id])
        @php $s = $sites[$fs->site_id]; $u = $users[$s->user_id]; @endphp
    <div class="mb-5">
        <div class="site-list-prepend">
            <div>
                <i class="fas fa-thumbs-up"></i>いいねした日 {{ format_date(strtotime($fs->good_at)) }}
            </div>
            <div>
                <form method="POST" action="{{ route('サイトいいねキャンセル', ['site' => $s->id]) }}" onsubmit="return confirm('{{ $s->name }}へのいいねを取り消します。');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-outline-danger btn-sm"><small><i class="fas fa-thumbs-up"></i>取り消し</small></button>
                </form>
            </div>
        </div>
        @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
    </div>
    @endisset
@endforeach

@include('common.pager', ['pager' => $goodSites])
    </div>
</div>