@if (empty($imageUrl))
    <i class="far fa-image"></i>
@else
    <img data-normal="{{ $imageUrl }}" class="img-responsive package-image">
@endif