@extends('layouts.management')

@section('title', 'パッケージの販売ショップ登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item">マスター</li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ') }}">パッケージ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-マスター-パッケージ詳細', $package) }}">詳細</a></li>
        <li class="breadcrumb-item active">販売ショップ登録</li>
    </ol>
    <h1 class="page-header">販売ショップ登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規登録</h4>
        </div>
        <form method="POST" action="{{ route('管理-マスター-パッケージショップ追加処理', $package) }}">
            {{ csrf_field() }}

            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>ショップ</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'shop_id', 'list' => $shops, 'value' => \Hgs3\Enums\Game\Shop::Amazon->value, 'options' => ['required']])
                        </td>
                    </tr>
                    <tr id="asin">
                        <th>ASIN</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'asin', 'options' => ['required']])
                        </td>
                    </tr>
                    <tr>
                        <th>ショップURL</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'shop_url', 'options' => ['required']])
                        </td>
                    </tr>
                    <tr>
                        <th>画像(小)</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'shop_url', 'options' => ['required']])
                        </td>
                    </tr>
                    <tr>
                        <th>画像(小)</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'shop_url', 'options' => ['required']])
                        </td>
                    </tr>
                    <tr>
                        <th>画像(小)</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'shop_url', 'options' => ['required']])
                        </td>
                    </tr>
                    <tr>
                        <th>リリース日(数値)</th>
                        <td>
                            @include ('management.common.form.input', ['name' => 'release_int', 'type' => 'number', 'options' => ['required', 'max' => 99999999, 'min' => 0]])
                        </td>
                    </tr>
                    <tr>
                        <th>R-18</th>
                        <td>
                            @include ('management.common.form.select', ['name' => 'is_adult', 'list' => $ratedR])
                        </td>
                    </tr>
                </table>
            </div>
            <div class="panel-footer text-end">
                <button type="submit" class="btn btn-default">登録</button>
            </div>
        </form>
    </div>
@endsection

@section('js')
    <script>
        const AMAZON = {{ \Hgs3\Enums\Game\Shop::Amazon->value }};


        $(()=>{
            $("#shop_id").select2();

            changeShop();

            $("#shop_id").change(()=>{
                changeShop();
            });
        });


        function changeShop()
        {
            let shopId = $('#shop_id').val();

            if (shopId == AMAZON) {
                $('#asin').show();
            } else {
                $('#asin').hide();
            }
        }
    </script>
@endsection
