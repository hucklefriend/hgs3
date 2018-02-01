@php
if (!isset($isLarge)) $isLarge = false;
$userIconClass = $isLarge ? 'user-icon-img-large' : 'user-icon-img';
@endphp
@if ($u !== null && $u->icon_upload_flag == 1)
    <img src="{{ url('img/user_icon') }}/{{ $u->icon_file_name }}" class="img-responsive {{ $userIconClass }}">
@else
    <i class="fas fa-user-circle"></i>
@endif