@extends('layouts.app')

@section('content')

    <h5>コミュニティ</h5>

    <div class="row">
        <div class="col-6">
            <h5>コミュニティ</h5>
            <p>特定のゲームソフトにこだわらないコミュニティです。運営に関することなどはこちらへ。</p>

            @if (is_admin())
                <div>コミュニティ追加</div>
            @endif

            @foreach ($userCommunities as $uc)
                <div><a href="{{ url2('community/u') }}/{{ $uc->id }}">{{ $uc->name }}</a></div>
            @endforeach
        </div>

        <div class="col-6">
            <h5>ゲームコミュニティ</h5>
            <p>特定のゲームを好きなメンバーが集まるコミュニティです。</p>

            <div>⇒ <a href="{{ url2('community/g/') }}">全部見る</a></div>
        </div>
    </div>

@endsection