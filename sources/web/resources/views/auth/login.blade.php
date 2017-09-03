@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-4"><a href="{{ url2('social/twitter') }}/{{ \Hgs3\Constants\Social\Mode::LOGIN }}">Twitter</a></div>
        <div class="col-md-4"><a href="{{ url2('social/facebook') }}/{{ \Hgs3\Constants\Social\Mode::LOGIN }}">facebook</a></div>
        <div class="col-md-4"><a href="{{ url2('social/github') }}/{{ \Hgs3\Constants\Social\Mode::LOGIN }}">GitHub</a></div>
    </div>
    <div class="row">
        <div class="col-md-4">Google+</div>
        <div class="col-md-4">Yahoo!</div>
        <div class="col-md-4">mixi</div>
    </div>

    <div class="panel panel-info">
        <div class="panel-heading">メールアドレスでログイン</div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST">
                {{ csrf_field() }}

                <label for="email" class="col-md-4 control-label">メールアドレス</label>
                <div class="form-group">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">パスワード</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">ログイン</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
