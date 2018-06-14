<div class="package-card-small col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
    <a href="{{ route('ゲーム詳細', ['soft' => $soft->id]) }}">
        <img data-normal="{{ small_image_url($soft, true) }}">
        <small>{{ $soft->name }}</small>
    </a>
</div>