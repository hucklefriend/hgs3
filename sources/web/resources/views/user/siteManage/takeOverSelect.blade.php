@extends('layouts.app')

@section('content')
    <p>
        引き継ぐサイトを選択してください。<br>
        何回でも引き継いで登録できますが、同じサイトを複数登録しないようお願いします。
    </p>

    <ul class="list-group">
    @foreach ($hgs2Sites as $hgs2Site)
        <li class="list-group-item">
            <a href="{{ url2('user/site_manage/takeover/' . $hgs2Site->id) }}">{{ $hgs2Site->site_name }}</a>
        </li>
    @endforeach
    </ul>
@endsection