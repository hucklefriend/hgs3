@extends('layouts.app')

@section('title')外部サイト連携@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>外部サイト連携の解除はできません</h1>
        </header>
        <p>
            このSNS連携を解除するとログインする手段がなくなってしまうため、解除できません。<br>
            連携を解除したい場合は、別の外部サイトでログイン連携するか、メール認証を登録してください。
        </p>
    </div>
@endsection
