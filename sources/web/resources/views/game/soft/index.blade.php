@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
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
                <a class="flex-sm-fill text-sm-center nav-link active game_tab" href="#" data-target="agyo">あ</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="kagyo">か</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="sagyo">さ</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="tagyo">た</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="nagyo">な</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="hagyo">は</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="magyo">ま</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="yagyo">や</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="ragyo">ら</a>
                <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="wagyo">わ</a>
            </nav>
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
                <section id="{{ $p[0] }}gyo">
                    @if (isset($list[$p[1]]))
                        @foreach ($list[$p[1]] as $soft)
                            <a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a>
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
        });
    </script>
@endsection