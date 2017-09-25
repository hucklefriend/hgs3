@extends('layouts.app')

@section('content')

    <div>
        <a href="{{ url2('timeline') }}">戻る</a>
    </div>

    <hr>

    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::NEW_GAME_SOFT  }}">
        <h5>ゲームソフト追加</h5>
        <div class="form-group row">
            <div class="col-3">ゲームID</div>
            <div class="col-9"><input type="number" name="game_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::UPDATE_GAME_SOFT  }}">
        <h5>ゲームソフト更新</h5>
        <div class="form-group row">
            <div class="col-3">ゲームID</div>
            <div class="col-9"><input type="number" name="game_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::FAVORITE_GAME  }}">
        <h5>お気に入りゲーム登録</h5>
        <div class="form-group row">
            <div class="col-3">ゲームID</div>
            <div class="col-9"><input type="number" name="game_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::NEW_REVIEW  }}">
        <h5>レビュー投稿</h5>
        <div class="form-group row">
            <div class="col-3">レビューID</div>
            <div class="col-9"><input type="number" name="review_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ゲームID</div>
            <div class="col-9"><input type="number" name="game_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::REVIEW_GOOD }}">
        <h5>レビューにいいね</h5>
        <div class="form-group row">
            <div class="col-3">レビューID</div>
            <div class="col-9"><input type="number" name="review_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::NEW_USER_COMMUNITY_MEMBER  }}">
        <h5>ユーザーコミュニティに参加</h5>
        <div class="form-group row">
            <div class="col-3">コミュニティID</div>
            <div class="col-9"><input type="number" name="community_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::NEW_GAME_COMMUNITY_MEMBER  }}">
        <h5>ゲームコミュニティに参加</h5>
        <div class="form-group row">            <div class="col-3">コミュニティID</div>
            <div class="col-9"><input type="number" name="community_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::NEW_SITE }}">
        <h5>サイト登録</h5>
        <div class="form-group row">
            <div class="col-3">サイトID</div>
            <div class="col-9"><input type="number" name="site_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::UPDATE_SITE }}">
        <h5>サイト更新</h5>
        <div class="form-group row">
            <div class="col-3">サイトID</div>
            <div class="col-9"><input type="number" name="site_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
    <form method="POST" action="{{ url('timeline/add') }}">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ \Hgs3\Constants\TimelineType::NEW_FOLLOWER }}">
        <h5>新規フォロワー</h5>
        <div class="form-group row">
            <div class="col-3">フォロワーID</div>
            <div class="col-9"><input type="number" name="follower_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group row">
            <div class="col-3">ユーザーID</div>
            <div class="col-9"><input type="number" name="user_id" min="0" class="form-control"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-sm btn-default">登録</button>
        </div>
    </form>
@endsection