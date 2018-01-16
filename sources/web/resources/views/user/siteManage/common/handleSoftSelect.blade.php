<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="handle_soft_dialog">
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
                    <ul class="nav nav-tabs text-center" id="handle_soft_tab">
                        <li class="nav-item">
                            <a class="nav-link active soft_tab" href="#" id="handle_softs_tab_agyo" data-target="agyo">あ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_kagyo" data-target="kagyo">か</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_sagyo" data-target="sagyo">さ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_tagyo" data-target="tagyo">た</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_nagyo" data-target="nagyo">な</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_hagyo" data-target="hagyo">は</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_magyo" data-target="magyo">ま</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_yagyo" data-target="yagyo">や</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_ragyo" data-target="ragyo">ら</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link soft_tab" href="#" id="handle_softs_tab_wagyo" data-target="wagyo">わ</a>
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
                    <div id="handle_softs_{{ $phonetics[$phonicType] }}gyo" class="handle_soft_tab @if ($phonicType == 1) active @endif ">
                        <div class="container-fluid p-3" style="overflow-y: scroll; height: 300px;">
                            @if (isset($softs[$phonicType]))
                                @foreach ($softs[$phonicType] as $soft)
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <label>
                                                <input type="checkbox" class="handle_soft_check" name="handle_soft[]" value="{{ $soft->id }}" id="handle_soft_check_{{ $soft->id }}">
                                                <span>{{ $soft->name }}</span>
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
                <button type="button" class="btn btn-secondary" id="handle_soft_cancel" data-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-primary" id="handle_soft_ok">OK</button>
            </div>
        </div>
    </div>
</div>

<style>
    .handle_soft_tab {
        display:none;
    }

    .handle_soft_tab.active {
        display: block;
    }

    #handle_soft_tab .nav-link {
        padding: 12px !important;
    }
</style>

<script>
    $(function (){
        let handleSofts = $('#handle_soft').val();
        if (handleSofts.length > 0) {
            let softs = handleSofts.split(',');
            let txt = '';
            softs.forEach(function (currentValue, index, array){
                txt += $('#handle_soft_check_' + currentValue).next('span').text() + '、';
            });
            if (txt.length > 0) {
                txt = txt.slice(0, -1);
            }

            $('#selected_soft').text(txt);
        }

        $('#select_handle_soft').click(function (){
            // TODO 現在の選択にチェック
            $('.handle_soft_check').prop('checked', false);
            let handleSofts = $('#handle_soft').val();
            if (handleSofts.length > 0) {
                let softs = handleSofts.split(',');
                softs.forEach(function (currentValue, index, array){
                    $('#handle_soft_check_' + currentValue).prop('checked', true);
                });
            }

            $('#handle_soft_dialog').modal('show');
        });

        $('.soft_tab').click(function (e){
            e.preventDefault();
            let prevTarget = $('#handle_soft_tab .active').data('target');
            let target = $(this).data('target');

            $('#handle_softs_' + prevTarget).hide();
            $('#handle_soft_tab .active').removeClass('active');

            $('#handle_softs_' + target).show();
            $('#handle_softs_tab_' + target).addClass('active');

            $('#gyo_select').val(target);

            return false;
        });

        $('#gyo_select').on('change', function (){
            let prevTarget = $('#handle_soft_tab .active').data('target');
            let target = $(this).val();

            $('#handle_softs_' + prevTarget).hide();
            $('#handle_soft_tab .active').removeClass('active');

            $('#handle_softs_' + target).show();
            $('#handle_softs_tab_' + target).addClass('active');
        });

        $('#handle_soft_ok').click(function (){
            $('#handle_soft_dialog').modal('hide');

            let txt = '';
            let val = '';
            $('.handle_soft_check:checked').each(function (){
                txt += $(this).next('span').text()+'、';
                val += $(this).val() + ',';
            });
            if (txt.length > 0) {
                txt = txt.slice(0, -1);
                val = val.slice(0, -1);
            }

            $('#selected_soft').text(txt);
            $('#handle_soft').val(val);
        });
    });
</script>