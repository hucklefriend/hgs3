@extends('layouts.app')

@section('content')

    <section>
        <div class="d-flex align-items-stretch">
            <div class="p-2 align-self-center">
                <div class="review_point_outline">
                    <p class="review_point">{{ $review->point }}</p>
                </div>
            </div>
            <div class="p-12 align-self-center">
                @if($review->is_spoiler == 1) <span class="badge badge-pill badge-danger">ネタバレあり！</span> @endif
                <div class="break_word" style="width: 100%;"><h5>{{ $review->title }}</h5></div>
                <div>
                    <i class="fa fa-user" aria-hidden="true"></i>&nbsp;<a href="{{ url2('user/profile') }}/{{ $writer->id }}">{{ $writer->name }}</a>
                    {{ $review->post_date }}
                </div>
            </div>
        </div>
    </section>

    <p style="margin-top: 20px;">
        こちらのレビューに対して不正報告を行います。<br>
        どこにどのような問題があるか、記入の上、送信してください。<br>
    </p>

    <p>
        レビューは各個人の主観で書かれたものですので、ご自身の価値観と合わないからといって不正扱いする理由にはなりません。<br>
        考え方は人それぞれです、そういう考えの人もいるんだなーくらいの気持ちでいましょう。
    </p>


    <div class="card">
        <div class="card-body">
            <form method="POST" onsubmit="return confirm('不正レビューを報告します。よろしいですか？');">
                {{ csrf_field() }}

                <p>どれかあてはまるものがあればチェックを入れてください。</p>

                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="type[0]" id="type1" value="1">
                        ネタバレがあるのに、「ネタバレあり」の表示がない
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="type[1]" id="type1" value="1">
                        暴言や他のレビューへの批判など、不快になることが書かれている
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="type[2]" id="type1" value="1">
                        違うゲームの内容が書かれている
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="type[3]" id="type1" value="1">
                        一部または全てに嘘の内容が書かれている
                    </label>
                </div>

                <hr>

                <div class="form-group">
                    <label for="comment">
                        どのような問題があるか記入してください。大雑把に書いていただいても大丈夫です。
                    </label>
                    <textarea name="comment" class="form-control" id="comment"></textarea>
                    <p class="help-block"></p>
                </div>
                @auth
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" value="1" name="anonymous">
                            匿名で送信する
                        </label>
                        <p class="text-muted">
                            <small>
                                匿名かどうかに関わらず、投稿者には誰が不正報告を送ったかは見ることができません。<br>
                                非匿名でお送りいただいた場合、不正報告の修正や取り消しを行うことができます。<br>
                                また、管理人が不正報告で不明な点があった際に、確認させていただく場合があります。
                            </small>
                        </p>
                    </div>
                @endauth
                <div class="form-group">
                    <button class="btn btn-danger">送信</button>
                </div>
            </form>
        </div>
    </div>

@endsection