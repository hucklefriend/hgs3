@if (empty($imageUrl))
    <img data-normal="{{ url('img/pkg_no_img_m.png') }}" class="img-responsive package-image">
@else
    <img data-normal="{{ $imageUrl }}" class="img-responsive package-image">
@endif