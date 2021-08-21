@extends('layouts.management')

@section('title', 'お知らせ登録')

@section('content')
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('管理') }}">管理</a></li>
        <li class="breadcrumb-item"><a href="{{ route('管理-システム-お知らせ') }}">お知らせ</a></li>
        <li class="breadcrumb-item active">お知らせ登録</li>
    </ol>
    <h1 class="page-header">お知らせ登録</h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <h4 class="panel-title">新規お知らせ</h4>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('管理-システム-お知らせ登録処理') }}">
                @csrf

                <table class="table">
                    <tr>
                        <th>タイトル</th>
                        <td><input type="text" class="form-control{{ invalid($errors, 'title') }}" id="title" name="title" value="{{ old('title') }}" maxlength="100"></td>
                    </tr>
                    <tr>
                        <th>内容</th>
                        <td>
                            <textarea name="message" id="message" class="form-control textarea-autosize{{ invalid($errors, 'message') }}">{{ old('message') }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>オープン期間</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <input type="datetime-local" name="open_at" class="form-control w-auto" value="{{ old('open_at') }}" max="2100-12-31T23:59">
                                </div>
                                <div class="mx-2">～</div>
                                <div>
                                    <input type="datetime-local" name="close_at" class="form-control w-auto" value="{{ old('close_at') }}" max="2100-12-31T23:59">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>トップページ表示期間</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <input type="datetime-local" name="top_start_at" class="form-control w-auto" value="{{ old('open_at') }}" max="2100-12-31T23:59">
                                </div>
                                <div class="mx-2">～</div>
                                <div>
                                    <input type="datetime-local" name="top_end_at" class="form-control w-auto" value="{{ old('close_at') }}" max="2100-12-31T23:59">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><button type="submit" class="btn btn-default">登録</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection
