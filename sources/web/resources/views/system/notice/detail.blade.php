@extends('layouts.app')

@section('title')お知らせ@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('お知らせ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>お知らせ</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $notice->title }}</h4>
                <h6 class="card-subtitle">{{ format_date(strtotime($notice->open_at)) }}</h6>

                <p class="force-break">{!! nl2br($notice->message) !!}</p>
            </div>

            @if (is_admin())
                <div class="card-footer d-flex">
                    <a class="btn btn-sm btn-outline-secondary mr-5" href="{{ route('お知らせ編集', ['notice' => $notice->id]) }}" role="button">編集</a>

                    <form action="{{ route('お知らせ削除', ['notice' => $notice->id]) }}" onsubmit="return confirm('削除してよろしいですか？');" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-sm btn-outline-danger" type="submit">削除</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
