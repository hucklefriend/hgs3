<p class="text-muted"><small>※お気に入りに登録できるゲームは最大{{ \Hgs3\Constants\User\FavoriteSoft::MAX }}個です。</small></p>
<div class="card">
    <div class="card-body">
        @if ($favoriteSofts->count() <= 0)
            <div>お気に入りゲームはありません。</div>
        @else
        <div class="row">
        @foreach ($favoriteSofts as $fg)
            @isset($softs[$fg->soft_id])
                @php $soft = $softs[$fg->soft_id] @endphp
                <div class="col-12 col-lg-6 mb-4">
                    <div class="favorite-soft-list">
                        @if ($isMyself)
                        <div class="d-flex justify-content-between">
                            <div><span style="color: yellow;"><i class="fas fa-star"></i></span>登録した日　{{ format_date($fg->register_timestamp) }}</div>
                            <div>
                                <form method="POST" action="{{ route('お気に入りゲーム削除処理') }}" onsubmit="return confirm('お気に入り解除します。よろしいですか？');" class="align-self-center">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="soft_id" value="{{ $fg->soft_id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-star"></i>取り消し</button>
                                </form>
                            </div>
                        </div>
                        @endif
                        <div class="package-card">
                            <div>
                                <div><img data-normal="{{ small_image_url($soft, true) }}"></div>
                                <div>{{ $soft->name }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}" class="and-more and-more-sm">詳細を見る <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            @endisset
        @endforeach
        </div>

        @include('common.pager', ['pager' => $favoriteSofts])
        @endif
    </div>
</div>