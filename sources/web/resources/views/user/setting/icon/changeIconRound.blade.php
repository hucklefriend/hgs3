@extends('layouts.app')

@section('title')アイコン丸み変更@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>アイコン丸み変更</h1>
        </header>
        <div>
            <form method="POST" action="{{ route('アイコン丸み変更処理') }}" autocomplete="off">
                <div class="d-flex mb-3">
                    <div class="align-self-center p-3">
                        @include('user.common.icon', ['u' => $user, 'isLarge' => true])
                    </div>
                    <div class="align-self-center">
                        <label class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="icon_round_type" id="icon_round_type0" value="{{ \Hgs3\Constants\IconRoundType::NONE }}"  {{ checked(old('icon_round_type'), \Hgs3\Constants\IconRoundType::NONE) }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">丸みなし</span>
                        </label>

                        <div class="clearfix mb-2"></div>

                        <label class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="icon_round_type" id="icon_round_type1" value="{{ \Hgs3\Constants\IconRoundType::ROUNDED }}"  {{ checked(old('icon_round_type'), \Hgs3\Constants\IconRoundType::ROUNDED) }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">丸みあり</span>
                        </label>

                        <div class="clearfix mb-2"></div>

                        <label class="custom-control custom-radio">
                            <input class="custom-control-input" type="radio" name="icon_round_type" id="icon_round_type1" value="{{ \Hgs3\Constants\IconRoundType::CIRCLE }}"  {{ checked(old('icon_round_type'), \Hgs3\Constants\IconRoundType::CIRCLE) }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">円</span>
                        </label>
                    </div>
                </div>

                <div>
                    <button class="btn btn-primary">変更</button>
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
        </div>
    </div>

@endsection
