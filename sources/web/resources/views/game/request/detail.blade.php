@extends('layouts.app')

@section('content')
    <ul>
        <li><a href="{{ url('game/request') }}">リクエスト一覧へ</a></li>
        <li><a href="{{ url('game/request/input') }}">リクエスト入力へ</a></li>

        <li><a href="{{ url('game/soft') }}">ソフト一覧へ</a></li>
    </ul>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $gr->name }}</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">@if($user == null)ゲスト@else{{ $user->name }}@endif</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $gr->url }}</div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-10">{{ $gr->other }}</div>
    </div>


    @if($isAdmin)
    <form method="POST" action="{{ url2('game/request') }}/{{ $gr->id }}/change_status">
        {{{ csrf_tag($csrfToken) }}}
        {{ csrf_field() }}
        {{ Form::select('status', \Hgs3\Constants\GameRequestStatus::getSelectOptions(), $gr->status, ['class' => 'form-control']) }}
        <button class="btn btn-default">ステータス更新</button>
    </form>
    @endif

    <hr>

    <form method="POST" action="{{ url2('game/request') }}/{{ $gr->id }}/comment">
        {{ csrf_tag($csrfToken) }}
        <textarea class="form-control" name="comment">{{ old('comment') }}</textarea><br>
        <button class="btn btn-default">コメントを投稿</button>
    </form>

    {{ $comments->links() }}

    @foreach ($comments as $comment)
        <div>
            <pre>{{ $comment->comment }}</pre>

            <div class="row">
                <div class="col-10">{{ un($users, $comment->user_id) }} {{ $comment->created_at }}</div>
                <div class="col-2">
                    @if ($comment->user_id == \Illuminate\Support\Facades\Auth::id())
                    <form method="POST" action="{{ url2('game/request') }}/{{ $gr->id }}/comment/{{ $comment->id }}">
                        {{ csrf_tag($csrfToken) }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger btn-sm">削除</button>
                    </form>
                    @endif
                </div>
            </div>
            <hr>
        </div>
    @endforeach

    {{ $comments->links() }}

@endsection