@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('site/manager/register') }}">追加</a>
    </div>

    <form>
        <div class="form-group">
            <label for="title">サイト名</label>
            <input type="text" class="form-control" id="title" name="name">
        </div>
        <div class="form-group">
            <label for="title">URL</label>
            <input type="text" class="form-control" id="title" name="url">
        </div>
        <div class="form-group">
            <label for="title">取扱いゲーム</label>
            <button type="button" class="btn btn-default" id="select_handle_game">ゲームを選択する</button>
            <p id="selected_game"></p>
            <input type="hidden" name="handle_game" value="" id="handle_game">
        </div>
        <fieldset class="form-group">
            <legend>メインコンテンツ</legend>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="main_contents" id="main_contents1" value="1">
                    攻略
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="main_contents" id="main_contents1" value="2">
                    イラスト/漫画
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="main_contents" id="main_contents1" value="2">
                    小説/テキスト
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="main_contents" id="main_contents1" value="2">
                    その他創作
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="main_contents" id="main_contents1" value="2">
                    SNS/同盟/検索エンジン/ウェブ・リング
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="main_contents" id="main_contents1" value="2">
                    ニュース/情報
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="main_contents" id="main_contents1" value="2">
                    その他
                </label>
            </div>
        </fieldset>
        <div class="form-group">
            <label for="presentation">紹介文</label>
            <textarea class="form-control" id="presentation"></textarea>
        </div>
        <fieldset class="form-group">
            <legend>対象年齢</legend>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="rate" id="main_contents1" value="1">
                    全年齢
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="rate" id="main_contents1" value="2">
                    R-15
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="rate" id="main_contents1" value="2">
                    R-18
                </label>
            </div>
        </fieldset>
        <fieldset class="form-group">
            <legend>ターゲット</legend>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" id="main_contents1" value="1">
                    なし
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" id="main_contents1" value="2">
                    男性向け
                </label>
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="gender" id="main_contents1" value="2">
                    女性向け
                </label>
            </div>
        </fieldset>

        <div class="form-group">
            <button class="btn btn-primary">登録</button>
        </div>
    </form>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="handle_game_dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" data-phonetic_type="1">あ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="2">か</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="3">さ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="4">た</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="5">な</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="6">は</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="7">ま</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="8">や</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="9">ら</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-phonetic_type="10">わ</a>
                        </li>
                    </ul>
                    @for ($phonicType = 1; $phonicType <= 10; $phonicType++)
                    <div id="handle_games_{{ $phonicType }}" class="handle_game_tab @if ($phonicType == 1) active @endif ">
                        <div class="container-fluid">
                        @if (isset($games[$phonicType]))
                        @foreach ($games[$phonicType] as $game)
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <label>
                                        <input type="checkbox" class="handle_game_check" name="handle_game[]" value="{{ $game->id }}">
                                        <span>{{ $game->name }}</span>
                                    </label>
                                </li>
                            </ul>
                        @endforeach
                        @endif
                        </div>
                    </div>
                    @endfor
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="handle_game_cancel">キャンセル</button>
                    <button type="button" class="btn btn-primary" id="handle_game_ok">OK</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .handle_game_tab {
            display:none;
        }

        .handle_game_tab.active {
            display: block;
        }
    </style>

    <script>
        $(function (){
            $('#select_handle_game').click(function (){
                $('#handle_game_dialog').modal('show');
            });

            $('.nav-link').click(function (e){
                e.preventDefault();

                $('.nav-link.active').removeClass('active');
                $(this).addClass('active');

                $('.handle_game_tab.active').removeClass('active');
                $('#handle_games_' + $(this).data('phonetic_type')).addClass('active');

                return false;
            });

            $('#handle_game_ok').click(function (){
                $('#handle_game_dialog').modal('hide');

                let txt = '';
                let val = '';
                $('.handle_game_check:checked').each(function (){
                    txt += $(this).next('span').text()+'、';
                    val += $(this).val() + ',';
                });

                $('#selected_game').text(txt);
                $('#handle_game').val(val);
            });
        });
    </script>

@endsection