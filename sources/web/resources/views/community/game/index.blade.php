@extends('layouts.app')

@section('content')
    <h4>ゲームコミュニティ一覧</h4>

    <div class="card">
        <div class="card-header">
            <div class="d-none d-sm-block">
                <ul class="nav nav-tabs card-header-tabs  text-center" id="game_tab">
                    <li class="nav-item">
                        <a class="nav-link active game_tab" href="#" data-target="agyo">あ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="kagyo">か</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="sagyo">さ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="tagyo">た</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="nagyo">な</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="hagyo">は</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="magyo">ま</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="yagyo">や</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="ragyo">ら</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link game_tab" href="#" data-target="wagyo">わ</a>
                    </li>
                </ul>

                <nav class="nav nav-pills flex-column flex-sm-row" id="game_tab_a" style="display:none">
                    <a class="flex-sm-fill text-sm-center nav-link active game_tab" href="#" data-target="agyo" id="tab_agyo">あ</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="kagyo" id="tab_kagyo">か</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="sagyo" id="tab_sagyo">さ</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="tagyo" id="tab_tagyo">た</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="nagyo" id="tab_nagyo">な</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="hagyo" id="tab_hagyo">は</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="magyo" id="tab_magyo">ま</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="yagyo" id="tab_yagyo">や</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="ragyo" id="tab_ragyo">ら</a>
                    <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="wagyo" id="tab_wagyo">わ</a>
                </nav>
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
        </div>
        <div class="card-body">
            @php
                $phonetics = [
                    ['a', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('あ')],
                    ['ka', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('か')],
                    ['sa', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('さ')],
                    ['ta', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('た')],
                    ['na', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('な')],
                    ['ha', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('は')],
                    ['ma', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ま')],
                    ['ya', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('や')],
                    ['ra', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ら')],
                    ['wa', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('わ')],
                ];
            @endphp

            @foreach ($phonetics as $p)
                <section id="{{ $p[0] }}gyo"@if (!$loop->first) style="display:none;"@endif>
                    @if (isset($list[$p[1]]))
                        @foreach ($list[$p[1]] as $soft)
                            <a href="{{ url('community/g') }}/{{ $soft->id }}">{{ $soft->name }} ({{ $memberNum[$soft->id] ?? 0 }}人)</a>
                            @if (!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    @endif
                </section>
            @endforeach
        </div>
    </div>
    <script>
        $(function (){
            $('.game_tab').click(function (){
                $('#' + $('#game_tab .active').data('target')).hide();
                $('#game_tab .active').removeClass('active');

                $('#' + $(this).data('target')).show();
                $(this).addClass('active');
            });

            $('#gyo_select').on('change', function (){
                let target = $(this).val();

                $('#' + $('#game_tab .active').data('target')).hide();
                $('#game_tab .active').removeClass('active');

                $('#' + target).show();
                $('#tab_' + target).addClass('active');
            });
        });
    </script>
@endsection