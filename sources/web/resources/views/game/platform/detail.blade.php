@extends('layouts.app')

@section('content')
    <h4>{{ $platform->name }}</h4>

    <div>
        @if ($platform->url != null)
        <a href="{{ $platform->url }}" target="_blank">公式サイト</a>
        @endif
        @if ($platform->wikipedia != null)
        <a href="{{ $platform->wikipedia }}" target="_blank">Wikipedia</a>
        @endif
    </div>

    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ url('game/platform/edit/') }}/{{ $platform->id }}">データ編集</a>
    </div>
    @endif

    <hr>

    <ul class="list-group">
    @foreach ($packages as $pkg)
        <li class="list-group-item">
            <div class="d-flex align-items-stretch">
                <div class="align-self-top p-2">
                    @include('game.common.package_image', ['imageUrl' => $pkg->small_image_url])
                </div>
                <div class="align-self-top">
                    <div><h4>{{ $pkg->name }}</h4></div>
                    @isset($companies[$pkg->company_id])
                        <div>
                            <i class="fa fa-building-o" aria-hidden="true"></i>&nbsp;<a href="{{ url2('game/company') }}/{{ $pkg->company_id }}">{{ $companies[$pkg->company_id] }}</a>
                        </div>
                    @endisset
                    <div>{{ $pkg->release_date }}</div>
                    <div>
                        @isset($pkg->item_url)
                            <a href="{{ $pkg->item_url }}" target="_blank"><img src="{{ url('img/assocbutt_or_detail._V371070159_.png') }}"></a>
                        @endisset
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    </ul>

    {{ $packages->links() }}

@endsection