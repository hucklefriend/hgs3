@if (empty($imageUrl))
    <div class="text-center no_image_text_outer">
        <div class="no_image_text_inner">NO IMAGE</div>
    </div>
@else
    <div class="text-center">
        <img src="{{ $pkg->medium_image_url }}" class="img-responsive" style="max-width: 100%;">
    </div>
@endif