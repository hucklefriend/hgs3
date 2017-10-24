@extends('layouts.app')

@section('content')
    <form method="POST">
        {{ csrf_field() }}

        @include('site.common.form')

        <div class="form-group">
            <button class="btn btn-primary">登録</button>
        </div>
    </form>


    @include('site.common.handleSoftSelect')

@endsection