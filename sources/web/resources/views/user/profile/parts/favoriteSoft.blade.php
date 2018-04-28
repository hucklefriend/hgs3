<div class="card">
    <div class="card-body">
        @if ($favoriteSofts->count() <= 0)
            <div>お気に入りゲームはありません。</div>
        @else

        <div class="d-inline-block">
        @foreach ($favoriteSofts as $fg)
            @isset($softs[$fg->soft_id])
                @php $soft = $softs[$fg->soft_id] @endphp
                <div class="mb-5">
                        <div class="d-flex justify-content-between">
                            <div class="mr-3">
                                <a href="{{ route('ゲーム詳細', ['soft' => $fg->soft_id]) }}" class="d-block">
                                    <span class="package-card-image">
                                        @php $imageUrl = small_image_url($soft); @endphp
                                        @if (empty($imageUrl))
                                            <i class="far fa-image"></i>
                                        @else
                                            <img src="{{ $imageUrl }}" class="img-responsive">
                                        @endif
                                    </span>
                                    <div class="package-card-name">
                                        {{ $soft->name }}
                                        @isset($favorites[$soft->id])
                                            <span class="favorite-icon"><i class="fas fa-star"></i></span>
                                        @endisset
                                    </div>
                                </a>
                                <div>
                                    {{ format_date($fg->register_timestamp) }} 登録
                                </div>
                            </div>
                            @if ($isMyself)
                            <form method="POST" action="{{ route('お気に入りゲーム削除処理') }}" onsubmit="return confirm('お気に入り解除します。よろしいですか？');" class="align-self-center">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="soft_id" value="{{ $fg->soft_id }}">
                                <button type="submit" class="btn btn-sm btn-danger">解除</button>
                            </form>
                            @endif
                        </div>
                    </div>
            @endisset
        @endforeach
        </div>

        @include('common.pager', ['pager' => $favoriteSofts])
        @endif
    </div>
</div>