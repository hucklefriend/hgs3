<div class="col-12 col-md-6 col-lx-4">
    <div class="card">
        <div class="card-body review-list">
            <div class="review-list-fear">
                {{ \Hgs3\Constants\Review\Fear::$data[$review->fear] }}
                @if($review->is_spoiler == 1)
                    <small><span class="badge badge-danger ml-2">ネタバレ</span></small>
                @endif
            </div>

            <table class="point-only">
                <tr>
                    <td>
                        <span>{{ $review->calcPoint() }}</span>
                    </td>
                    <td>
                        <p class="mb-0 one-line"><small><i class="fas fa-user"></i>&nbsp;{{ $review->user->name }}</small></p>
                        <p class="mb-0"><small><i class="fas fa-calendar-alt"></i>&nbsp;{{ format_date(strtotime($review->post_at)) }}</small></p>
                    </td>
                    <td>
                        <a href="{{ route('レビュー', ['review' => $review->id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
