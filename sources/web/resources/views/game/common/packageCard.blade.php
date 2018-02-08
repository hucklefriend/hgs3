<div class="package-card">
    <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}" style="width: 100%;display: table;">
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
            </div>
        </div>
    </a>
</div>