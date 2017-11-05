@extends('layouts.app')

@section('content')

    <h5>コミュニティ</h5>

    <p>工事中</p>


    {{--
    <p>
        コミュニティは2種類あります。
    </p>


    <div class="row">
        <div class="col-sm-6">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">ユーザーコミュニティ</h5>
                    <p class="card-text">
                        ユーザーが自由に立ち上げることのできる予定のコミュニティです。<br>
                        α版では、管理人のみ立ち上げることができ、運営などに関する話題のもののみです。<br>
                        β版にて、ユーザーのみなさんで立ち上げられるように実装するかもしれません。<br>
                        必要かどうかも含めて、検討します。
                    </p>
                    <a href="{{ url2('community/u/') }}">ユーザーコミュニティ一覧へ</a>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">ゲームコミュニティ</h5>
                    <p class="card-text">
                        特定のゲームを好きなメンバーが集まるコミュニティです。<br>
                        攻略の質問や、イラストの投稿など、同じゲームが好きなもの同士で交流しましょう！
                    </p>
                    <a href="{{ url2('community/g/') }}">ゲームコミュニティ一覧へ</a>
                </div>
            </div>
        </div>
    </div>
 --}}
@endsection