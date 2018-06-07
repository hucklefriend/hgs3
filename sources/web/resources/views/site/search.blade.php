@extends('layouts.app')

@section('title')サイト検索@endsection
@section('global_back_link'){{ \Hgs3\Http\GlobalBack::siteSearch() }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト検索</h1>
        </header>

        @if ($pager->isEmpty())
            <div class="card card-hgn mt-5">
                <div class="card-body">
                    指定の条件でサイトが見つかりませんでした。<br>
                    条件を変えて、再検索してみてください。
                </div>
            </div>
        @else
            @foreach ($pager as $p)
                <?php $s = $sites[$p->site_id]; ?>
                <div style="margin-top: 10px;margin-bottom: 30px;">
                    @include('site.common.normal', ['s' => $s, 'u' => $users[$s->user_id]])
                </div>
            @endforeach
            @include('common.pager', ['pager' => $pager])
        @endif

        <div class="card card-hgn mt-5">
            <div class="card-body">
                <h4 class="card-title">検索条件</h4>
                <form method="GET" action="{{ route('サイト検索') }}">
                    <div class="form-group">
                        <div>
                            <label for="main_contents" class="hgn-label"><i class="fas fa-check"></i> メインコンテンツを絞る</label>
                        </div>
                        <div class="d-flex flex-wrap">
                            @foreach (\Hgs3\Constants\Site\MainContents::getData() as $mcId => $mcName)
                                <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                    <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                        <input type="checkbox" class="custom-control-input" id="mc_{{ $mcId }}" name="mc[]" value="{{ $mcId }}" autocomplete="off"{{ checked(in_array($mcId, $mc), true) }}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">{{ $mcName }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-help"></div>

                    <div class="form-group">
                        <div>
                            <label for="gender" class="hgn-label"><i class="fas fa-check"></i> 性別傾向を絞る</label>
                        </div>
                        <div class="d-flex">
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="gender_{{ \Hgs3\Constants\Site\Gender::NONE }}" name="g[]" value="{{ \Hgs3\Constants\Site\Gender::NONE }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\Site\Gender::NONE, $g), true) }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">傾向なし</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="gender_{{ \Hgs3\Constants\Site\Gender::MALE }}" name="g[]" value="{{ \Hgs3\Constants\Site\Gender::MALE }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\Site\Gender::MALE, $g), true) }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">男性向け</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="gender_{{ \Hgs3\Constants\Site\Gender::FEMALE }}" name="g[]" value="{{ \Hgs3\Constants\Site\Gender::FEMALE }}" autocomplete="off"{{ checked(in_array(\Hgs3\Constants\Site\Gender::FEMALE, $g), true) }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">女性向け</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-help"></div>

                    <div class="form-group">
                        <div>
                            <label for="rate" class="hgn-label"><i class="fas fa-check"></i> 対象年齢を絞る</label>
                        </div>
                        <div class="d-flex">
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="rate_0" name="r[]" value="0" autocomplete="off"{{ checked(in_array(0, $r), true) }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">制限なし</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="rate_15" name="r[]" value="15" autocomplete="off"{{ checked(in_array(15, $r), true) }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">R-15</span>
                                </label>
                            </div>
                            <div class="btn-group-toggle my-2 mr-2" data-toggle="buttons">
                                <label class="custom-control custom-checkbox text-left btn hgn-check-btn">
                                    <input type="checkbox" class="custom-control-input" id="rate_18" name="r[]" value="18" autocomplete="off"{{ checked(in_array(18, $r), true) }}>
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">R-18</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-help"></div>

                    <button class="btn btn-light">この条件で再検索</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-footer">
            <li class="breadcrumb-item"><a href="{{ route('トップ') }}">トップ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('サイトトップ') }}">サイト</a></li>
            <li class="breadcrumb-item active" aria-current="page">サイト検索</li>
        </ol>
    </nav>
@endsection