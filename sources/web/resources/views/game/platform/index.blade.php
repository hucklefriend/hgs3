@extends('layouts.app')

@section('title')プラットフォーム@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>プラットフォーム一覧</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach ($platforms as $p)
                    <div class="col-xl-2 col-lg-3 col-sm-4 col-12">
                        <div class="contacts__item">
                            <div>
                                <a href="{{ route('プラットフォーム詳細', ['platform' => $p->id]) }}">{{ $p->name }}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">プラットフォーム一覧</li>
        </ol>
    </nav>
@endsection
