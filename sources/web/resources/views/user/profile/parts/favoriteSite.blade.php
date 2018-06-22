<div class="card">
    <div class="card-body">

@if ($favoriteSites->count() == 0)
    お気に入りサイトはありません。
@endif
@foreach ($favoriteSites as $fs)
    @isset($sites[$fs->site_id])
        @php $s = $sites[$fs->site_id]; @endphp
    <div class="mb-5">
        <div class="site-list-prepend">
            <div>
                <span style="color:yellow;"><i class="fas fa-star"></i></span>登録した日 {{ format_date(strtotime($fs->created_at)) }}
            </div>
            <div>
                <form method="POST" action="{{ route('お気に入りサイト削除処理', ['site' => $s->id]) }}" onsubmit="return confirm('{{ $s->name }}へのいいねを取り消します。');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-outline-danger btn-sm"><small><i class="fas fa-star"></i>取り消し</small></button>
                </form>
            </div>
        </div>
    @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
    </div>
    @endif
@endforeach

@include('common.pager', ['pager' => $favoriteSites])
    </div>
</div>