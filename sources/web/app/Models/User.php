<?php

namespace Hgs3\Models;

use Hgs3\Models\Account\SignUp;
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
            ->select(['id', 'name', 'icon_upload_flag'])
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
            $path = base_path() . '/public/img/user_icon/' . $this->icon_file_name;

            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    /**
     * 表示用IDの
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
}
