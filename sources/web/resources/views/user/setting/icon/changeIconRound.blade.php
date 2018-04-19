@extends('layouts.app')

@section('title')アイコン丸み変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <h1>アイコン丸み変更</h1>

    <form method="POST" action="{{ route('アイコン丸み変更処理') }}" autocomplete="off">
        <div class="d-flex mb-3">
            <div class="align-self-center p-3">
                @include('user.common.icon', ['u' => $user, 'isLarge' => true])
            </div>
            <div class="align-self-center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="icon_round_type" id="icon_round_type0" value="{{ \Hgs3\Constants\IconRoundType::NONE }}"  {{ checked(old('icon_round_type', $user->icon_round_type), \Hgs3\Constants\IconRoundType::NONE) }}>
                    <label class="form-check-label" for="icon_round_type0">
                        丸みなし
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="icon_round_type" id="icon_round_type1" value="{{ \Hgs3\Constants\IconRoundType::ROUNDED }}" {{ checked(old('icon_round_type', $user->icon_round_type), \Hgs3\Constants\IconRoundType::ROUNDED) }}>
                    <label class="form-check-label" for="icon_round_type1">
                        丸みあり
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="icon_round_type" id="icon_round_type2" value="{{ \Hgs3\Constants\IconRoundType::CIRCLE }}" {{ checked(old('icon_round_type', $user->icon_round_type), \Hgs3\Constants\IconRoundType::CIRCLE) }}>
                    <label class="form-check-label" for="icon_round_type2">
                        円
                    </label>
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-outline-info">変更</button>
        </div>

        {{ method_field('PATCH') }}
        {{ csrf_field() }}
    </form>

    <script>
        let userIcon = null;

        $(function() {
            userIcon = $('.user-icon');

            $('input[name="icon_round_type"]').change(function (){
                resetClass();

                let val = $(this).val();
                if (val == {{ \Hgs3\Constants\IconRoundType::ROUNDED }}) {
                    userIcon.addClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::ROUNDED) }}');
                } else if (val == {{ \Hgs3\Constants\IconRoundType::CIRCLE }}) {
                    userIcon.addClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::CIRCLE) }}');
                }
            });
        });

        function resetClass()
        {
            userIcon.removeClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::ROUNDED) }}');
            userIcon.removeClass('{{ \Hgs3\Constants\IconRoundType::getClass(\Hgs3\Constants\IconRoundType::CIRCLE) }}');
        }
    </script>


@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('マイページ') }}">ユーザー</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ユーザー設定') }}">設定</a></li>
            <li class="breadcrumb-item active" aria-current="page">アイコン丸み変更</li>
        </ol>
    </nav>
@endsection