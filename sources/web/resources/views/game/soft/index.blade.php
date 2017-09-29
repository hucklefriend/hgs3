@extends('layouts.app')

@section('content')

    <nav class="nav nav-pills flex-column flex-sm-row" id="game_tab">
        <a class="flex-sm-fill text-sm-center nav-link active game_tab" href="#" data-target="agyo">あ行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="kagyo">か行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="sagyo">さ行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="tagyo">た行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="nagyo">な行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="hagyo">は行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="magyo">ま行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="yagyo">や行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="ragyo">ら行</a>
        <a class="flex-sm-fill text-sm-center nav-link game_tab" href="#" data-target="wagyo">わ行</a>
    </nav>

    <ul class="list-group" id="agyo">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('あ'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>

    <ul class="list-group" id="kagyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('か'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="sagyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('さ'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="tagyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('た'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="nagyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('な'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="hagyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('は'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="magyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ま'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="yagyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('や'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="ragyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ら'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>
    <ul class="list-group" id="wagyo" style="display:none;">
        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('わ'); @endphp
        @if (isset($list[$phoneticId]))
            @foreach ($list[$phoneticId] as $soft)
                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
            @endforeach
        @endif
    </ul>


    <div>
        <a href="{{ url('game/request') }}">追加リクエスト一覧</a>
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