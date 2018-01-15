@extends('layouts.app')

@section('content')
    <h4>{{ $gamePlatform->name }}</h4>

    <div>
        @if ($gamePlatform->url != null)
        <a href="{{ $gamePlatform->url }}" target="_blank">公式サイト</a>
        @endif
        @if ($gamePlatform->wikipedia != null)
        <a href="{{ $gamePlatform->wikipedia }}" target="_blank">Wikipedia</a>
        @endif
    </div>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ url2('game/platform/edit/' . $gamePlatform->id }}">データ編集</a>
    </div>
    @endif

    <hr>

    <ul class="list-group">
    @foreach ($gamePackages as $gamePackage)
        <li class="list-group-item">
            <div class="d-flex align-items-stretch">
                <div class="align-self-top p-2">
                    @include('game.common.package_image', ['imageUrl' => $gamePackage->small_image_url])
                </div>
                <div class="align-self-top">
                    <div><h4>{{ $gamePackage->name }}</h4></div>
                    @isset($companyNameHash[$gamePackage->company_id])
                        <div>
                            <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;<a href="{{ url2('game/company/' . $gamePackage->company_id }}">{{ $companyNameHash[$pkg->company_id] }}</a>
                        </div>
                    @endisset
                    <div>{{ $gamePackage->release_at }}</div>
                    <div>
                        @isset($gamePackage->item_url)
                            <a href="{{ $gamePackage->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                        @endisset
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    </ul>

    {{ $gamePackages->links() }}

@endsection