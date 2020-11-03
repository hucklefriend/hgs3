@extends('layouts.app')

@section('title')足あとの設定@endsection
@section('global_back_link'){{ route('ユーザー設定') }}@endsection

@section('content')
    <div class="content__inner">
        <header class="content__title">
            <h1>足あとの設定</h1>
        </header>

        <form method="POST" action="{{ route('足あと設定保存') }}" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-group mb-3">
                <label for="flag" class="hgn-label"><i class="fas fa-check"></i> 足あとを残すか残さないか</label>
                <div class="demo-inline-wrapper">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="toggle-switch toggle-switch--blue">
                                <input type="checkbox" class="toggle-switch__checkbox" id="flag" name="flag" value="1"{{ checked($user->footprint, 1) }}>
                                <i class="toggle-switch__helper"></i>
                            </div>
                            <div id="text" class="ml-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-help">
                サイトに訪れた際に足あとが残ります。<br>
                サイト登録者のみが見られるアクセスログ機能で、あなたがいつサイトにアクセスしたかが見ることができます。<br>
                残さないにした場合は、誰かわからないけど誰かがアクセスしたという表示になります。
            </div>
            <div class="form-group text-center text-md-left">
                <button class="btn btn-info">保存</button>
            </div>
        </form>
    </div>
    <script>
        $(function (){
            $('#flag').on('change', function (){
                showText();
            });

            showText();
        });

        function showText() {
            if ($('#flag').prop('checked')) {
                $('#text').text('残す');
            } else {
                $('#text').text('残さない');
            }
        }

    </script>
@endsection
