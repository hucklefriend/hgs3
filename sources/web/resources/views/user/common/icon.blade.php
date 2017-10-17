@php
if (!isset($isLarge)) $isLarge = false;
$userIconClass = $isLarge ? 'user_icon_img_large' : 'user_icon_img';
@endphp
@if ($u->icon_upload_flag == 1)
    <img src="{{ url2('img/user_icon') }}/{{ $u->icon_file_name }}" class="img-responsive {{ $userIconClass }}">
@else
    <i class="fa fa-user-circle user_icon" aria-hidden="true"></i>
@endif