@extends('layouts.app')

@section('title')ゲーム会社@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>ゲーム会社一覧</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach ($companies as $c)
                        <div class="col-xl-2 col-lg-3 col-sm-4 col-12">
                            <div class="contacts__item">
                                <div>
                                    <a href="{{ route('ゲーム会社詳細', ['company' => $c->id]) }}">{{ $c->name }}</a>
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
            <li class="breadcrumb-item active" aria-current="page">ゲーム会社一覧</li>
        </ol>
    </nav>
@endsection