@extends('layouts.app')

@section('title')プロフィール公開範囲設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>プロフィール公開範囲設定</h1>
        </header>

        <form method="POST" action="{{ route('プロフィール公開範囲設定保存') }}" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-group">
                <div>
                    <label for="profile" class="hgn-label"><i class="fas fa-check"></i> 公開範囲設定</label>
                </div>
                <label class="custom-control custom-radio mb-2">
                    <input type="radio" class="custom-control-input" name="flag" id="flag0" value="0"{{ checked(old('flag', $user->open_profile_flag), 0) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">非公開</span>
                </label>
                <label class="custom-control custom-radio mb-2">
                    <input type="radio" class="custom-control-input" name="flag" id="flag1" value="1"{{ checked(old('flag', $user->open_profile_flag), 1) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">当サイトメンバーのみ</span>
                </label>
                <label class="custom-control custom-radio mb-2">
                    <input type="radio" class="custom-control-input" name="flag" id="flag2" value="2"{{ checked(old('flag', $user->open_profile_flag), 2) }}>
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">誰にでも</span>
                </label>
            </div>
            <div class="form-help" id="text_0" style="display:none">
                <p class="text-muted">
                    自己紹介やお気に入りゲーム等を誰にも公開しません。<br>
                    (※人数にはカウントされます)<br>
                    ただし、以下のものは誰にでも公開されます。
                </p>
                <ul>
                    <li>サイト</li>
                    <li>レビュー</li>
                </ul>
                <p>以下のものは公開されません。</p>
                <ul>
                    <li>年齢制限コンテンツの表示設定</li>
                    <li>公開しないに設定している外部サイト連携</li>
                </ul>
            </div>
            <div class="form-help" id="text_1" style="display:none">
                <p class="text-muted">
                    自己紹介やお気に入りゲーム等を当サイトのメンバーにのみ公開します。<br>
                    (※誰でも見られるページでの人数にはカウントされます)
                </p>
                <ul>
                    <li>自己紹介</li>
                    <li>あなたのタイムライン</li>
                    <li>お気に入りゲーム</li>
                    <li>お気に入りサイト</li>
                    <li>公開するに設定している外部サイト連携</li>
                </ul>
                <p class="text-muted">
                    ただし、以下のものは誰にでも公開されます。
                </p>
                <ul>
                    <li>サイト</li>
                    <li>レビュー</li>
                </ul>
                <p>以下のものは公開されません。</p>
                <ul>
                    <li>年齢制限コンテンツの表示設定</li>
                    <li>公開しないに設定している外部サイト連携</li>
                </ul>
            </div>
            <div class="form-help" id="text_2"  style="display:none">
                <p class="text-muted">
                    自己紹介やお気に入りゲーム等を誰にでも公開します。
                </p>
                <ul>
                    <li>自己紹介</li>
                    <li>あなたのタイムライン</li>
                    <li>お気に入りゲーム</li>
                    <li>お気に入りサイト</li>
                    <li>公開するに設定している外部サイト連携</li>
                    <li>サイト</li>
                    <li>レビュー</li>
                </ul>
                <p>以下のものは公開されません。</p>
                <ul>
                    <li>年齢制限コンテンツの表示設定</li>
                    <li>公開しないに設定している外部サイト連携</li>
                </ul>
            </div>
            <div class="form-group text-center text-md-left">
                <button class="btn btn-info">保存</button>
            </div>
        </form>
    </div>
    <script>
        $(function (){
            $('input[name=flag]').on('change', function (){
                let flag = $(this).val();
                $('.form-help').hide();
                $('#text_' + flag).show();
            });

            let flag = $('input[name=flag]').val();
            $('#text_' + flag).show();
        });


    </script>
@endsection
