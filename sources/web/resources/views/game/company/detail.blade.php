@extends('layouts.app')

@section('content')
    <h4>{{ $company->name }}</h4>

    <div>
        @if ($company->url != null)
        <a href="{{ $company->url }}" target="_blank">公式サイト</a>
        @endif
        @if ($company->wikipedia != null)
        <a href="{{ $company->wikipedia }}" target="_blank">Wikipedia</a>
        @endif
    </div>


    @if (is_data_editor())
    <div class="text-right">
        <a href="{{ url('game/company/edit/') }}/{{ $company->id }}">データ編集</a>
    </div>
    @endif

    <hr>

    <div class="d-flex flex-wrap">

    @foreach ($packages as $package)
            <div class="card" style="width: 250px;margin: 10px;padding-top: 10px;">
                @include('game.common.package_image', ['imageUrl' => $package->medium_image_url])
                <div class="card-body">
                    <h4 class="card-title">{{ $package->name }}</h4>
                    <p class="card-text">
                        @isset($shops[$package->id])
                            @foreach ($shops[$package->id] as $shop)
                                @include('game.common.shop', ['shopId' => $shop->shop_id, 'shopUrl' => $shop->shop_url])
                            @endforeach
                        @endisset
                    </p>
                </div>
            </div>
    @endforeach
    </div>


    {{ $packages->links() }}
@endsection