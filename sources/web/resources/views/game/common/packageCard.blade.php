<div class="package-card d-flex">
    <a href="{{ route('ゲーム詳細', ['game' => $soft->id]) }}" class="d-flex p-1 align-self-center">
        <div class="package-card-image d-flex justify-content-center">
            @if (empty($soft->small_image_url))
                <i class="far fa-image align-self-center"></i>
            @else
                <img src="{{ $soft->small_image_url }}" class="img-responsive align-self-center">
            @endif
        </div>
        <div class="package-card-name d-flex">
            <span class="align-self-center"><small>{{ $soft->name }}</small></span>
        </div>
    </a>
</div>