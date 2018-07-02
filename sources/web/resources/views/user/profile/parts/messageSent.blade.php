<div class="text-right mb-4"><a href="{{ route('メッセージ入力', ['resId' => 0]) }}" class="and-more"><i class="far fa-edit"></i> 管理人へのメッセージを書く</a></div>

<div class="card">
    <div class="card-body">
        <ul class="nav nav-fill nav-tabs mb-5">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('プロフィール2', ['showId' => $user->show_id, 'show' => 'message']) }}">受信</a>
            </li>
            <li class="nav-item">
                <span class="nav-link active">送信済み</span>
            </li>
        </ul>

        @if ($messages->isEmpty())
            <p class="mb-0">メッセージはありません。</p>
        @else

            @foreach ($messages as $message)
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1">{{ format_date(strtotime($message->created_at)) }}</p>
                        <p class="mb-0">{{ str_limit($message->message, 100) }}</p>
                    </div>
                    <div>
                        <a href="{{ route('メッセージ表示', ['message' => $message->id]) }}" class="btn btn-light btn--icon"><i class="fas fa-angle-right"></i></a>
                    </div>
                </div>
                @if (!$loop->last)
                    <hr>
                @endif
            @endforeach

            @include('common.pager', ['pager' => $messages])
        @endif
    </div>
</div>