@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card card-hgn">
                <div class="card-header">ようこそ</div>
                <div class="card-block">
                    <p class="card-text">
                        人というものは、はじめから悪の道を知っているわけではない。何かの拍子で、小さな悪事を起こしてしまい、それを世間の目にふれさせぬため、また、つぎの悪事をする。そして、これを隠そうとして、さらに大きな悪の道へ踏み込んで行くものなのだ
                    </p>
                    <div class="text-center" style="font-size: 150%;">
                        <a href="{{ url2('') }}">新規登録</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-hgn">
                <div class="card-header">ログイン</div>
                <div class="card-block">
                    <a href="{{ url2('social/twitter') }}/{{ \Hgs3\Constants\Social\Mode::LOGIN }}" style="color: #55acee;margin-right: 5px;text-decoration: none;">
                        <i class="fa fa-twitter" aria-hidden="true" style="font-size: 150%;"></i>
                    </a>
                    <a href="{{ url2('social/facebook') }}/{{ \Hgs3\Constants\Social\Mode::LOGIN }}" style="color: #315096;text-decoration: none;">
                        <i class="fa fa-facebook-official" aria-hidden="true" style="font-size: 150%;"></i>
                    </a>
                    <hr>
                    <form method="POST">
                        {{ csrf_field() }}

                        <div class="form-group form-group-sm">
                            <input id="email" type="email" class="form-control form-control-sm" name="email" value="{{ old('email') }}" required placeholder="メールアドレス">
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control form-control-sm" name="password" required placeholder="パスワード">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">ログイン</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-hgn">
        <div class="card-header">新着情報</div>
        <div class="card-block">
            <p class="card-text">
                人というものは、はじめから悪の道を知っているわけではない。何かの拍子で、小さな悪事を起こしてしまい、それを世間の目にふれさせぬため、また、つぎの悪事をする。そして、これを隠そうとして、さらに大きな悪の道へ踏み込んで行くものなのだ
            </p>
            <div class="text-center" style="font-size: 150%;">
                <a href="{{ url2('') }}">新規登録</a>
            </div>
        </div>
    </div>
@endsection