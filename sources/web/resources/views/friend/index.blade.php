@extends('layouts.app')

@section('title')フレンド@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::clearAndRoute('トップ') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>フレンド探し</h1>
        </header>

        <div class="card card-hgn">
            <div class="card-body">
                <h2 class="card-title mb-0">検索フォーム <button id="search_form_open" class="btn btn-sm btn-secondary">open</button></h2>
                <div id="search" style="display:none;">
                    <form class="mt-3">
                        <form method="GET" action="{{ route('フレンド') }}">
                            <div class="form-group">
                                <div>
                                    <label for="attribute" class="hgn-label"><i class="fas fa-check"></i> 属性</label>
                                </div>
                                <div class="d-flex flex-wrap">
                                    @foreach (\Hgs3\Constants\User\Attribute::$text as $attrId => $attrName)
                                        <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                            <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                                <input type="checkbox" class="custom-control-input" id="attr_{{ $attrId }}" name="attr[]" value="{{ $attrId }}" autocomplete="off"{{ checked(in_array($attrId, []), true) }}>
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">{{ $attrName }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-help"></div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            let searchArea = null;
            let searchFormOpenBtn = null;

            $(function (){
                searchArea = $('#search');
                searchFormOpenBtn = $('#search_form_open');
[]
                searchFormOpenBtn.click(function (){
                    if (searchArea.css('display') == 'none') {
                        searchFormOpenBtn.text('close');
                    } else {
                        searchFormOpenBtn.text('open');
                    }

                    searchArea.slideToggle(300);
                });
            });
        </script>



        @if ($users->isEmpty())
            <p>
                プロフィール公開しているユーザーがいません。<br>
                ログインしてください。
            </p>
            <div>
                <a href="{{ route('ログイン') }}" class="and-more">ログイン <i class="fas fa-angle-right"></i></a>
            </div>
        @else
        <div class="row">
            @foreach ($users as $user)
                @php $attributes = $user->getUserAttributes(); @endphp
                <div class="col-12 col-md-6 col-xl-5">
                    @include ('friend.common.parts', ['user' => $user, 'attributes' => $attributes, 'mutual' => []])
                </div>
            @endforeach
        </div>

        @include('common.pager', ['pager' => $users])
        @endif
    </div>
@endsection

