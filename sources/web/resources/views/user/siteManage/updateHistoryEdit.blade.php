@extends('layouts.app')

@section('title')サイト更新履歴@endsection
@section('global_back_link'){{ route('サイト詳細', ['site' => $site->id]) }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>サイト更新履歴</h1>
        </header>

        <p>
            ご自身のサイトを更新した際、どのような更新を行ったかを登録できます。<br>
            紹介文を更新せずとも、更新履歴として登録されていきます。<br>
            ※更新履歴は1日1件までで、同じ日のデータを登録すると上書きします。
        </p>

        <div class="card">
            <div class="card-body">
                <form method="POST" autocomplete="off" action="{{ route('サイト更新履歴編集処理', ['siteUpdateHistory' => $updateHistory->id]) }}">
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}

                    <div class="form-group">
                        <label for="site_updated_at" class="hgn-label"><i class="far fa-calendar-alt"></i> 更新日</label>
                        <input type="date" class="form-control{{ invalid($errors, 'site_updated_at') }}" id="site_updated_at" name="site_updated_at" value="{{ old('site_updated_at', $updateHistory->site_updated_at) }}" max="{{ date('Y-m-d') }}" disabled>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        <p class="help-block"><small>更新日は変更できません</small></p>
                    </div>

                    <div class="form-group">
                        <label for="detail" class="hgn-label"><i class="fas fa-edit"></i> 更新内容</label>
                        <textarea class="form-control textarea-autosize{{ invalid($errors, 'detail') }}" id="detail" name="detail">{{ old('detail', $updateHistory->detail) }}</textarea>
                        <i class="form-group__bar"></i>
                    </div>
                    <div class="form-help">
                        @include('common.error', ['formName' => 'detail'])
                        <p class="help-block"><small>最大200文字まで</small></p>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
