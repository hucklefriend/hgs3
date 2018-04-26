@php
if (isset($toPackage) && $toPackage) {
    $url = route('パッケージからゲーム詳細', ['packageId' => $soft->id]);
} else {
    $url = route('ゲーム詳細', ['game' => $soft->id]);
}

$imageUrl = small_image_url($soft);

@endphp
<div class="package-card col-xl-3 col-lg-4 col-sm-6 col-12">
    <a href="{{ $url }}" style="width: 100%;display: table;">
        <div style="display: table-row;">
            <div class="package-card-image">
                @if (empty($imageUrl))
                    <i class="far fa-image"></i>
                @else
                    <img data-normal="{{ $imageUrl }}" class="img-responsive lazy-img-load">
                @endif
            </div>
            <div class="package-card-name">
                <small>{{ $soft->name }}</small>
                @isset($favorites[$soft->id])
                    <span class="favorite-icon"><i class="fas fa-star"></i></span>
                @endisset
            </div>
        </div>
    </a>
</div>