@if (empty($imageUrl))
    <i class="far fa-image"></i>
@else
    <div class="text-center">
        <img src="{{ $imageUrl }}" class="img-responsive package-image">
    </div>
@endif