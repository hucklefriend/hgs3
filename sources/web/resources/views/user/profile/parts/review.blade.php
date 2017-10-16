@foreach ($reviews as $review)
    @include('review.common.noUser', ['r' => $review, 'writer' => $user, 'gamePackage' => $gamePackages[$review->package_id]])
    @if (!$loop->last) <hr> @endif
@endforeach

{{ $reviews->links('vendor.pagination.simple-bootstrap-4') }}