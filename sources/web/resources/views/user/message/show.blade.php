@extends('layouts.app')

@section('title')システムメッセージ@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::messageShow() }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>システムメッセージ</h1>
        </header>

        <div class="card">
            <div class="card-body">
                @if ($sendUser->id == 1)
                <h4 class="card-title">管理人からのメッセージ</h4>
                @else
                <h4 class="card-title">{{ $sendUser->name }}さんからのメッセージ</h4>
                @endif
                <p class="card-subtitle">{{ format_date(strtotime($message->created_at)) }} 送信</p>
                <p>{!! nl2br(e($message->message)) !!}</p>
                @if ($message->res_id != null)
                <hr>
                <div class="d-flex justify-content-between flex-wrap">
                    <p class="my-3 pr-4"><a href="{{ route('メッセージ表示', ['message' => $message->res_id]) }}">こちらのメッセージ</a>に対する返信です。</p>
                    @if ($message->to_user_id == \Illuminate\Support\Facades\Auth::id())
                    <div class="align-self-center text-right"><a href="{{ route('メッセージ入力', ['resId' => $message->id]) }}" class="and-more"><i class="far fa-edit"></i> 返信を書く</a></div>
                    @endif
                </div>

                @elseif ($message->to_user_id == \Illuminate\Support\Facades\Auth::id())
                <hr>
                <div class="text-right mt-3">
                    <a href="{{ route('メッセージ入力', ['resId' => $message->id]) }}" class="and-more"><i class="far fa-edit"></i> 返信を書く</a>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

