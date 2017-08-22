@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url('game/request') }}">追加リクエスト一覧</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">あ行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('あ'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">か行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('か'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">さ行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('さ'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">た行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('た'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">な行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('な'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">は行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('は'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">ま行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ま'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">や行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('や'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">ら行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('ら'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">わ行</h4>
                    <ul class="list-group">
                        @php $phoneticId = \Hgs3\Constants\PhoneticType::getTypeByPhonetic('わ'); @endphp
                        @if (isset($list[$phoneticId]))
                            @foreach ($list[$phoneticId] as $soft)
                                <li class="list-group-item"><a href="{{ url('game/soft') }}/{{ $soft->id }}">{{ $soft->name }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <hr>
        </div>
    </div>
@endsection