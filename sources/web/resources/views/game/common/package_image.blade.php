@if (empty($imageUrl))
    <div class="text-center no_image_text_outer">
        <div class="no_image_text_inner">NO<br>IMAGE</div>
    </div>
@else
    <div class="text-center">
        <img src="{{ $imageUrl }}" class="img-responsive package_image">
    </div>
@endif