@extends('layouts.app')

@section('global_back_link')
    <a href="{{ route('トップ') }}"><i class="fas fa-angle-left"></i></a>
@endsection

@section('content')

    @if (is_data_editor())
    <div class="d-flex justify-content-between">
        <h1>ゲーム一覧</h1>
        <div>
            <a href="{{ route('ゲームソフト登録') }}" class="btn btn-sm btn-outline-dark">新規登録</a>
        </div>
    </div>
    @else
        <h1>ゲーム一覧</h1>
    @endif

    <div class="d-flex flex-wrap" id="game_tab">
        <a class="btn btn-outline-secondary active game_tab" href="#" data-target="agyo" id="tab_agyo">あ</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="kagyo" id="tab_kagyo">か</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="sagyo" id="tab_sagyo">さ</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="tagyo" id="tab_tagyo">た</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="nagyo" id="tab_nagyo">な</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="hagyo" id="tab_hagyo">は</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="magyo" id="tab_magyo">ま</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="yagyo" id="tab_yagyo">や</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="ragyo" id="tab_ragyo">ら</a>
        <a class="btn btn-outline-secondary game_tab" href="#" data-target="wagyo" id="tab_wagyo">わ</a>
    </div>

    <div>
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
        <section id="{{ $p[0] }}gyo" @if (!$loop->first) style="display:none;" @endif>
            <div class="package-list">
            @if (isset($list[$p[1]]))
                @foreach ($list[$p[1]] as $soft)
                    @include('game.common.packageCard', ['soft' => $soft, 'favorites' => $favoriteHash])
                @endforeach
            @endif
            </div>
        </section>
    @endforeach
    </div>
    <script>
        $(function (){
            $('.game_tab').click(function (){
                $('#' + $('#game_tab .active').data('target')).hide();
                $('#game_tab .active').removeClass('active');

                console.debug($(this).data('target'));
                $('#' + $(this).data('target')).show();
                $(this).addClass('active');
            });
        });

/*
        re = new RegExp(String.raw`\\\(\^${escapeRegExp(mouth)}\^\)/`);
        re.text('aaaa');
        function escapeRegExp(string) {
            return ("" + string).replace(/[.*+?^=!:${}()|[\]\/\\]/g, "\\$&");
        }
*/
    </script>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item active" aria-current="page">ゲーム一覧</li>
        </ol>
    </nav>
@endsection