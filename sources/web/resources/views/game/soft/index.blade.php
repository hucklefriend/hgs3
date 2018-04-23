@extends('layouts.app')

@section('title')ゲーム@endsection
@section('global_back_link'){{ route('トップ') }}@endsection

@section('content')
    @php
        $phonetics = [
            ['a', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('あ'), 'あ'],
            ['ka', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('か'), 'か'],
            ['sa', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('さ'), 'さ'],
            ['ta', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('た'), 'た'],
            ['na', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('な'), 'な'],
            ['ha', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('は'), 'は'],
            ['ma', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ま'), 'ま'],
            ['ya', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('や'), 'や'],
            ['ra', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ら'), 'ら'],
            ['wa', \Hgs3\Constants\PhoneticType::getTypeByPhonetic('わ'), 'わ'],
        ];
    @endphp

    <header class="content__title">
        <h1>ゲーム一覧</h1>
    </header>

    <div class="d-flex flex-wrap" id="game_tab">
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[0][1]) active @endif " href="#" data-target="agyo" id="tab_agyo">あ</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[1][1]) active @endif " href="#" data-target="kagyo" id="tab_kagyo">か</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[2][1]) active @endif " href="#" data-target="sagyo" id="tab_sagyo">さ</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[3][1]) active @endif " href="#" data-target="tagyo" id="tab_tagyo">た</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[4][1]) active @endif " href="#" data-target="nagyo" id="tab_nagyo">な</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[5][1]) active @endif " href="#" data-target="hagyo" id="tab_hagyo">は</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[6][1]) active @endif " href="#" data-target="magyo" id="tab_magyo">ま</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[7][1]) active @endif " href="#" data-target="yagyo" id="tab_yagyo">や</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[8][1]) active @endif " href="#" data-target="ragyo" id="tab_ragyo">ら</a>
        <a class="btn btn-light game_tab @if($defaultPhoneticType == $phonetics[9][1]) active @endif " href="#" data-target="wagyo" id="tab_wagyo">わ</a>
    </div>

    <div>

    @foreach ($phonetics as $no => $p)
        <section id="{{ $p[0] }}gyo" @if ($defaultPhoneticType != $p[1]) style="display:none;" @endif>
            <div class="card">
                <div class="card-body">
                    <div class="package-list">
                    @if (isset($list[$p[1]]))
                        @foreach ($list[$p[1]] as $soft)
                            @include('game.common.packageCard', ['soft' => $soft, 'favorites' => $favoriteHash])
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <div>
                    @if ($no > 0)
                        <a href="javascript:void(0);" onclick="changeTab('{{ $phonetics[$no - 1][0] }}')" class="btn btn-light">
                            <i class="fas fa-angle-left"></i>&nbsp;{{ $phonetics[$no - 1][2] }}行
                        </a>
                    @endif
                </div>
                <div>
                    @if (!$loop->last)
                    <a href="javascript:void(0);" onclick="changeTab('{{ $phonetics[$no + 1][0] }}')" class="btn btn-light">
                        {{ $phonetics[$no + 1][2] }}行&nbsp;<i class="fas fa-angle-right"></i>
                    </a>
                    @endif
                </div>
            </div>
        </section>
    @endforeach
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

        function changeTab(phoneticType)
        {
            $('#tab_' + phoneticType + 'gyo').click();
            $("html,body").animate({scrollTop:0});
        }
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