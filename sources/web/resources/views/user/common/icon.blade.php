@php
if (!isset($isLarge)) $isLarge = false;
$userIconClass = $isLarge ? 'user-icon-img-large' : 'user-icon-img';
@endphp
@if ($u !== null && $u->icon_upload_flag == 1)
    <img src="{{ url2('img/user-icn') }}/{{ $u->icon_file_name }}" class="img-responsive {{ $userIconClass }}">
@else
    <i class="fa fa-user-circle user-icn" aria-hidden="true"></i>
@endif