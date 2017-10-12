@if (empty($imageUrl))
    <div class="text-center no_image_text_outer no_image_text_outer_small">
        <div class="no_image_text_inner">NO<br>IMAGE</div>
    </div>
@else
    <div class="text-center">
        <img src="{{ $imageUrl }}" class="img-responsive package_image">
    </div>
@endif