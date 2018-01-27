@extends('layouts.app')

@section('content')

    <h4>プロフィール編集</h4>

    <form method="POST" autocomplete="off">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <div class="form-group">
            <label for="name">名前</label>
            <input type="text" class="form-control{{ invalid($errors, 'name') }}" id="name" name="name" value="{{ old('name', $user->name) }}">
            @include('common.error', ['formName' => 'name'])
            <small class="form-text text-muted">最大文字数：50文字</small>
        </div>
        <div class="form-group">
            <label for="profile">自己紹介</label>
            <textarea class="form-control{{ invalid($errors, 'profile') }}" id="profile" name="profile" rows="5">{{ old('profile', $user->profile) }}</textarea>
            @include('common.error', ['formName' => 'profile'])
            <small class="form-text text-muted">最大文字数：500文字</small>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" class="form-check-input" value="1" name="adult"{{ checked(old('checkbox', $user->adult), 1) }}>
                18歳以上
            </label>
            <small class="form-text text-muted">18禁ゲームへのアクセスができるようになります。</small>
        </div>
        <div class="form-group">
            <button class="btn btn-default" type="button" onclick="location.href='{{ url2('mypage') }}';" style="margin-right:30px;">キャンセル</button>
            <button class="btn btn-info">プロフィール更新</button>
        </div>
    </form>

@endsection