@php
if (!isset($isLarge)) $isLarge = false;
$userIconClass = $isLarge ? 'user-icon-large' : '';
@endphp
@if ($u !== null && $u->icon_upload_flag == 1)
    <span class="user-icon {{ $userIconClass }} align-middle {{ \Hgs3\Constants\IconRoundType::getClass($u->icon_round_type) }}" style="background-image: url({{ url('img/user_icon/' . $u->icon_file_name) }});"></span>
@else
    <span class="align-middle {{ $userIconClass }}"><i class="fas fa-user-circle"></i></span>
@endif