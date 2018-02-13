@php
if (isset($toPackage) && $toPackage) {
    $url = route('パッケージからゲーム詳細', ['packageId' => $soft->id]);
} else {
    $url = route('ゲーム詳細', ['game' => $soft->id]);
}
@endphp
<div class="package-card">
    <a href="{{ $url }}" style="width: 100%;display: table;">
        <div style="display: table-row;">
            <div class="package-card-image">
                @if (empty($soft->small_image_url))
                    <i class="far fa-image"></i>
                @else
                    <img src="{{ $soft->small_image_url }}" class="img-responsive">
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