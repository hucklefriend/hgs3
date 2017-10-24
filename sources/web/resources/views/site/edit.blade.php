@extends('layouts.app')

@section('content')
    <form method="POST">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        @include('site.common.form')

        <div class="form-group">
            <button class="btn btn-primary">編集</button>
        </div>
    </form>

    @include('site.common.handleSoftSelect')

@endsection