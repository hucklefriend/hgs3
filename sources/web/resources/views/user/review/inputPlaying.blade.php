@extends('layouts.app')

@section('title'){{ $soft->name }}のレビュー投稿@endsection
@section('global_back_link'){{ route('レビュー投稿確認', ['soft' => $soft->id]) }}@endsection

@section('content')

    <div class="content__inner">
        <header class="content__title">
            <h1>{{ $soft->name }}</h1>
            <p>レビュー投稿　プレイ状況編集</p>
        </header>

        <form method="POST" action="{{ route('レビュープレイ状況保存', ['soft' => $soft->id]) }}" autocomplete="off">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="pkg" class="hgn-label"><i class="fas fa-check"></i> プレイしたパッケージ</label>
                <span class="badge badge-secondary ml-2">必須</span>
                <p class="text-muted mb-2">
                    プレイしたパッケージを選択してください。<br>
                    分からなければ、近そうなものを選びましょう。
                </p>

                <div class="d-flex flex-wrap">
                    @foreach ($packages as $pkg)
                        <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                            <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                <input type="checkbox" class="custom-control-input" id="pkg_{{ $pkg->id }}" name="package_id[]" value="{{ $pkg->id }}" autocomplete="off">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">{{ $pkg->acronym }}</span>
                            </label>
                        </div>
                    @endforeach
                    <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                        <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                            <input type="checkbox" class="custom-control-input" id="pkg_0" name="package_id[]" value="0" autocomplete="off">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">動画等で他人のプレイを見た</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'package_id'])
            </div>

            <div class="form-group">
                <label for="progress" class="hgn-label"><i class="fas fa-edit"></i> 進捗状態</label>
                <p class="text-muted">
                    このゲームをどの程度遊んだか、簡単に書いてください。<br>
                    例：プレイ時間、何周クリアした、エンディング全種類見た、PS2版は全クリアしたけどPC版は半分まで、××さんの実況動画を見た、友達がやっているのを横で見ていた、etc...<br>
                    <span style="color: indianred;">※ネタバレとなるような内容をここに書かないでください。</span>
                </p>
                <textarea name="progress" id="progress" class="form-control textarea-autosize{{ invalid($errors, 'progress') }}">{{ old('progress', $draft->progress) }}</textarea>
                <i class="form-group__bar"></i>
            </div>
            <div class="form-help">
                @include('common.error', ['formName' => 'progress'])
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary">プレイ状況を保存</button>
            </div>
        </form>
    </div>


    <script>
        let packageId = {!! old('package_id', null) == null ? $draft->package_id : json_encode(old('package_id')) !!}

        $(function (){
            packageId.forEach(function (pkgId){
                toggleButton($('#pkg_' + pkgId), true);
            });
        });


    </script>
@endsection
