@php
if (isset($toPackage) && $toPackage) {
    $url = route('パッケージからゲーム詳細', ['packageId' => $soft->id]);
} else {
    $url = route('ゲーム詳細', ['game' => $soft->id]);
}
@endphp
<div class="col-xl-3 col-lg-4 col-sm-6 col-12">
    <div class="package-card">
        <div>
            <div><img data-normal="{{ small_image_url($soft, true) }}"></div>
            <div>
                <small>{{ $soft->name }}</small>
                @isset($favoriteSofts[$soft->id])
                    <small><span class="favorite-icon"><i class="fas fa-star"></i></span></small>
                @endisset
            </div>
            <div>
                <a href="{{ $url }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</div>