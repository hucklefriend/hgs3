@extends('layouts.app')

@section('title')退会@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>退会</h1>
        </header>

        <div class="card">
            <div class="card-body">
                <p>退会処理を行っても下記のデータは削除されず、「匿名のユーザーが行ったもの」として残ります。</p>
                <ul>
                    <li>サイトの足跡</li>
                </ul>
                <p>
                    [退会する]ボタンを押すと、最終確認ダイアログが表示されます。<br>
                    そこで[OK]ボタンを押すと、退会処理が実行されます。
                </p>

                <form method="POST" action="{{ route('退会処理') }}" autocomplete="off" onsubmit="return confirm('退会します。これまでのご利用、ありがとうございました。');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger">退会する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

