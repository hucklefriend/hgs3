@extends('layouts.app')

@section('content')
    @foreach ($reviews as $r)
        @include('review.common.normalSplit', ['review' => $r, 'writer' => $writers[$r->user_id], 'gamePackage' => $gamePackages[$r->package_id]])
        <hr>
    @endforeach

    {{ $reviews->links() }}
@endsection