@extends('layouts.app')

@section('content')

    <style>
        .card {
            margin-bottom: 10px;
        }
    </style>


    <section>
        <h5>{{ $user->name }}さんのプロフィール</h5>
    </section>

    @if ($isMyself)
    <p><a href="{{ url('user/profile/edit') }}">プロフィール編集</a></p>
    @endif


    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    お気に入りゲーム
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    遊んだゲーム
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    サイト
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    お気に入りサイト
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    レビュー
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    いいねしたレビュー
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    攻略日記
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    参加コミュニティ
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    フォロー
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    フォロワー
                </div>
                <div class="card-block">
                    <p class="card-text">工事中</p>
                </div>
            </div>
        </div>
    </div>

@endsection