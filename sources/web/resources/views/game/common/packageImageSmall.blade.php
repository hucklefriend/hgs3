@if (empty($imageUrl))
    <div class="text-center no-image-text-outer no-image-text-outer-small">
        <div class="no-image-text-inner">NO<br>IMAGE</div>
    </div>
@else
    <div class="text-center">
        <img data-normal="{{ $imageUrl }}" class="img-responsive package-image">
    </div>
@endif