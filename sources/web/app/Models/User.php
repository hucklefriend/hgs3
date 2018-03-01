<?php

namespace Hgs3\Models;

use Hgs3\Constants\SocialSite;
use Hgs3\Constants\UserRole;
use Hgs3\Models\Account\SignUp;
use Hgs3\Models\Timeline\ToMe;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * ユーザー名ハッシュを取得
     *
     * @param array $ids
     * @return array
     */
    public static function getNameHash(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $tbl = DB::table('users');

        if (!empty($ids)) {
            $tbl->whereIn('id', $ids);
        }

        return $tbl->get()->pluck('name', 'id')->toArray();
    }

    /**
     * ハッシュでデータを取得
     *
     * @param array $userIds
     * @return array
     */
    public static function getHash(array $userIds)
    {
        if (empty($userIds)) {
            return [];
        }

        $data = DB::table('users')
            ->select(['id', 'name', 'icon_upload_flag', 'show_id', 'icon_round_type', 'icon_file_name'])
            ->whereIn('id', $userIds)
            ->get();

        $hash = [];
        foreach ($data as $user) {
            $hash[$user->id] = $user;
        }

        unset($data);

        return $hash;
    }

    /**
     * ページャーからユーザー名ハッシュを取得
     *
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $pager
     * @param string $key
     * @return array
     */
    public static function getNameHashByPager(\Illuminate\Contracts\Pagination\LengthAwarePaginator $pager, $key = 'user_id')
    {
        return self::getNameHash(array_pluck($pager->items(), $key));
    }

    /**
     * アイコンファイルを削除
     */
    public function deleteIconFile()
    {
        if (!empty($this->icon_file_name)) {
            $path = base_path() . '/public/img/user-icon/' . $this->icon_file_name;

            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * データ登録
     *
     * @param $data
     * @return User
     */
    public static function register($data)
    {
        $self = new self;
        $self->show_id = $data['show_id'] ?? self::generateShowId();
        $self->name = $data['name'];
        $self->email = $data['email'] ?? null;
        $self->password = isset($data['password']) ? bcrypt($data['password']) : null;
        $self->role = $data['role']  ?? UserRole::USER;
        $self->profile = $data['profile'] ?? '';
        $self->sign_up_at = date('Y-m-d H:i:s');

        $self->save();
        return $self;
    }

    /**
     * 表示用IDの生成
     *
     * @return int|mixed
     */
    public static function generateShowId()
    {
        $usedShowIds = new Orm\UsedShowIds();

        while(true) {
            try {
                $usedShowIds->show_id = rand(10000, 9999999);
                $usedShowIds->save();

                return $usedShowIds->show_id;
            } catch (\Exception $e) {}
        }
    }

    /**
     * HGS2のユーザーIDを取得
     *
     * @return mixed|null
     */
    public function getHgs2UserId()
    {
        if ($this->email !== null) {
            // メールアドレスからIDを抽出
            $id = DB::table('hgs2.hgs_u_user')
                ->where('mail', $this->email)
                ->value('id');

            if (!empty($id)) {
                return $id;
            }
        }

        $twitter_id = Orm\SocialAccount::where('user_id', $this->id)
            ->where('social_site_id', SocialSite::TWITTER)
            ->value('social_user_id');
        if ($twitter_id !== null) {
            $id = DB::table('hgs2.hgs_u_user')
                ->where('twitter_id', $twitter_id)
                ->value('id');

            if (!empty($id)) {
                return $id;
            }
        }

        return null;
    }

    /**
     * 管理者を取得
     *
     * @return mixed
     */
    public static function getAdmin()
    {
        $mail = env('ADMIN_MAIL');

        return self::where('email', $mail)
            ->first();
    }

    /**
     * 表示用IDからデータを取得
     *
     * @param $showId
     * @return mixed
     */
    public static function findByShowId($showId)
    {
        return self::where('show_id', $showId)
            ->first();
    }

    /**
     * メール認証登録済みか
     *
     * @return bool
     */
    public function isRegisteredMailAuth()
    {
        return $this->email != null && $this->password != null;
    }

    /**
     * 退会
     *
     * @throws \Exception
     */
    public function leave()
    {
        if ($this->id == 1) {
            return;
        }

        $userId = $this->id;

        DB::beginTransaction();
        try {
            // サイト
            $sites = Orm\Site::where('user_id', $this->id);
            foreach ($sites as $site) {
                Site::delete($site);
            }

            // フォロー
            Orm\UserFollow::where('user_id', $this->id)
                ->delete();

            // フォロワー
            Orm\UserFollow::where('follow_user_id', $this->id)
                ->delete();

            // 新着情報
            Orm\NewInformation::where('user_id', $this->id)
                ->delete();

            // パスワードリセット
            Orm\PasswordReset::where('user_id', $this->id)
                ->delete();

            // レビュー
            Orm\SocialAccount::where('user_id', $this->id)
                ->delete();

            // 表示用ID
            DB::table('used_show_ids')
                ->where('show_id', $this->show_id)
                ->delete();

            // メアド変更
            Orm\UserChangeEmail::where('user_id', $this->id)
                ->delete();

            // お気に入りサイト
            Orm\UserFavoriteSite::where('user_id', $this->id)
                ->delete();

            // お気に入りソフト
            Orm\UserFavoriteSoft::where('user_id', $this->id)
                ->delete();

            // 遊んだゲーム
            Orm\UserPlayedSoft::where('user_id', $this->id)
                ->delete();

            // ユーザー
            $this->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Hgs3\Log::exceptionError($e);
        }

        // タイムライン
        ToMe::delete($userId);

        return;
    }
}
