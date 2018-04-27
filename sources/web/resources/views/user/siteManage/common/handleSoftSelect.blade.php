<div class="modal fade modal-up" tabindex="-1" role="dialog" aria-labelledby="HandleGameSelect" aria-hidden="true" id="handle_soft_dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex flex-wrap" id="handle_soft_tab">
                    <a class="btn btn-light active soft_tab" href="#" data-target="agyo" id="handle_softs_tab_agyo">あ</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="kagyo" id="handle_softs_tab_kagyo">か</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="sagyo" id="handle_softs_tab_sagyo">さ</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="tagyo" id="handle_softs_tab_tagyo">た</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="nagyo" id="handle_softs_tab_nagyo">な</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="hagyo" id="handle_softs_tab_hagyo">は</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="magyo" id="handle_softs_tab_magyo">ま</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="yagyo" id="handle_softs_tab_yagyo">や</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="ragyo" id="handle_softs_tab_ragyo">ら</a>
                    <a class="btn btn-light soft_tab" href="#" data-target="wagyo" id="handle_softs_tab_wagyo">わ</a>
                </div>

                @php
                    $phonetics = ['', 'a', 'ka', 'sa', 'ta', 'na', 'ha', 'ma', 'ya', 'ra', 'wa'];
                @endphp

                <div class="py-3 handle-game-select-area">
                    @for ($phonicType = 1; $phonicType <= 10; $phonicType++)
                        <div id="handle_softs_{{ $phonetics[$phonicType] }}gyo" class="handle_soft_tab @if ($phonicType == 1) active @endif ">
                            <div class="contacts row">
                                @if (isset($softs[$phonicType]))
                                    @foreach ($softs[$phonicType] as $soft)
                                <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
                                    <div class="btn-group-toggle my-1" data-toggle="buttons">
                                        <label class="btn btn-light text-center w-100">
                                            <input type="checkbox" class="handle_soft_check hide-check" name="handle_soft[]" value="{{ $soft->id }}" id="handle_soft_check_{{ $soft->id }}" autocomplete="off">
                                            <span>{{ $soft->name }}</span>
                                        </label>
                                    </div>
                                </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
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

    #handle_soft_tab a{
        margin-right: 5px;
        margin-bottom: 3px;
    }
    #handle_soft_tab a:last-child {
        margin-right: 0;
    }
</style>

<script>
    $(function (){
        let scrollPos = 0;
        let handleSofts = $('#handle_soft').val();
        if (handleSofts.length > 0) {
            let softs = handleSofts.split(',');
            let html = '';
            softs.forEach(function (currentValue, index, array){
                let softName = $('#handle_soft_check_' + currentValue).next('span').text();
                if (softName.length > 0) {
                    html += '<span class="site-selected-game border rounded">' + softName + '</span>';
                }
            });

            $('#selected_soft').html(html);
        }

        $('#select_handle_soft').click(function (){
            // 現在の選択にチェック
            $('.handle_soft_check').prop('checked', false);
            $('.handle_soft_check_btn').removeClass('active');
            let handleSofts = $('#handle_soft').val();
            if (handleSofts.length > 0) {
                let softs = handleSofts.split(',');
                softs.forEach(function (currentValue, index, array){
                    let item = $('#handle_soft_check_' + currentValue);
                    item.prop('checked', true);
                    item.parent().addClass('active');
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

            let html = '';
            let val = '';
            $('.handle_soft_check:checked').each(function (){
                let softName = $(this).next('span').text();

                if (softName.length > 0) {
                    html += '<span class="site-selected-game border rounded">' + softName + '</span>';
                    val += $(this).val() + ',';
                }
            });
            if (val.length > 0) {
                val = val.slice(0, -1);
            }

            $('#selected_soft').html(html);
            $('#handle_soft').val(val);
        });


        $('.handle_soft_check').on('change', function (){
            let item = $(this);
            if (item.prop('checked')) {
                item.parent().removeClass('focus');
            }
        });
    });

</script>