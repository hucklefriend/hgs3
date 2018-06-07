@extends('layouts.app')

@section('title')新着レビュー@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::reviewNewList() }}@endsection

@section('content')
    @foreach ($reviews as $r)
        @include('review.common.normalSplit', ['review' => $r, 'writer' => $writers[$r->user_id], 'gamePackage' => $gamePackages[$r->package_id]])
        <hr>
    @endforeach

    {{ $reviews->links() }}
@endsection