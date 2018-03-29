@if (empty($imageUrl))
    <i class="far fa-image"></i>
@else
    <img src="{{ $imageUrl }}" class="img-responsive package-image">
@endif