@extends('layouts.app')

@section('content')
    <div class="container">

        <form method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="name">名称</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="name">よみがな</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="name">よみがな種別</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="name">よみがなでの表示順</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="name">ジャンル</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="form-group">
                <label for="company">会社</label>
                <input type="email" class="form-control" id="company" name="company">
            </div>

            <div class="form-group">
                <label for="company">シリーズ</label>
                <input type="email" class="form-control" id="company" name="company">
            </div>

            <div class="form-group">
                <label for="company">シリーズ内での表示順</label>
                <input type="email" class="form-control" id="company" name="company">
            </div>

            <div class="form-group">
                <label for="company">ゲーム区分</label>
                <input type="email" class="form-control" id="company" name="company">
            </div>
        </form>
    </div>
@endsection