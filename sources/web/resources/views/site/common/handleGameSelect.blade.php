<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="handle_game_dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">取扱いゲーム選択</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-none d-sm-block">
                    <ul class="nav nav-tabs text-center" id="handle_game_tab">
                        <li class="nav-item">
                            <a class="nav-link active game_tab" href="#" id="handle_games_tab_agyo" data-target="agyo">あ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_kagyo" data-target="kagyo">か</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_sagyo" data-target="sagyo">さ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_tagyo" data-target="tagyo">た</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_nagyo" data-target="nagyo">な</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_hagyo" data-target="hagyo">は</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_magyo" data-target="magyo">ま</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_yagyo" data-target="yagyo">や</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_ragyo" data-target="ragyo">ら</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link game_tab" href="#" id="handle_games_tab_wagyo" data-target="wagyo">わ</a>
                        </li>
                    </ul>
                </div>

                <div class="d-sm-none">
                    <div class="form-inline">
                        <select class="form-control" id="gyo_select">
                            <option value="agyo">あ</option>
                            <option value="kagyo">か</option>
                            <option value="sagyo">さ</option>
                            <option value="tagyo">た</option>
                            <option value="nagyo">な</option>
                            <option value="hagyo">は</option>
                            <option value="magyo">ま</option>
                            <option value="yagyo">や</option>
                            <option value="ragyo">ら</option>
                            <option value="wagyo">わ</option>
                        </select>
                    </div>
                </div>

                @php
                    $phonetics = [ '', 'a', 'ka', 'sa', 'ta', 'na', 'ha', 'ma', 'ya', 'ra', 'wa'];
                @endphp

                @for ($phonicType = 1; $phonicType <= 10; $phonicType++)
                    <div id="handle_games_{{ $phonetics[$phonicType] }}gyo" class="handle_game_tab @if ($phonicType == 1) active @endif ">
                        <div class="container-fluid p-3" style="overflow-y: scroll; height: 300px;">
                            @if (isset($games[$phonicType]))
                                @foreach ($games[$phonicType] as $game)
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <label>
                                                <input type="checkbox" class="handle_game_check" name="handle_game[]" value="{{ $game->id }}" id="handle_game_check_{{ $game->id }}">
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
                <button type="button" class="btn btn-secondary" id="handle_game_cancel" data-dismiss="modal">キャンセル</button>
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

    #handle_game_tab .nav-link {
        padding: 12px !important;
    }
</style>

<script>
    $(function (){
        $('#select_handle_game').click(function (){
            // TODO 現在の選択にチェック
            $('.handle_game_check').prop('checked', false);
            let handleGames = $('#handle_game').val();
            if (handleGames.length > 0) {
                let games = handleGames.split(',');
                games.forEach(function (currentValue, index, array){
                    $('#handle_game_check_' + currentValue).prop('checked', true);
                });
            }


            $('#handle_game_dialog').modal('show');
        });

        $('.game_tab').click(function (e){
            e.preventDefault();
            let prevTarget = $('#handle_game_tab .active').data('target');
            let target = $(this).data('target');

            $('#handle_games_' + prevTarget).hide();
            $('#handle_game_tab .active').removeClass('active');

            $('#handle_games_' + target).show();
            $('#handle_games_tab_' + target).addClass('active');

            $('#gyo_select').val(target);

            return false;
        });

        $('#gyo_select').on('change', function (){
            let prevTarget = $('#handle_game_tab .active').data('target');
            let target = $(this).val();

            $('#handle_games_' + prevTarget).hide();
            $('#handle_game_tab .active').removeClass('active');

            $('#handle_games_' + target).show();
            $('#handle_games_tab_' + target).addClass('active');
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