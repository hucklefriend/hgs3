<?php
/**
 * お知らせ
 */

namespace Hgs3\Models\Orm;

use Illuminate\Support\Facades\DB;

class SystemNotice extends AbstractOrm
{
    /**
     * open_atをDateTimeで取得
     *
     * @return ?\DateTime
     * @throws \Exception
     */
    public function getOpenAt() : ?\DateTime
    {
        return $this->open_at === null ? null : new \DateTime($this->open_at);
    }

    /**
     * open_atをDateTimeで取得
     *
     * @return ?\DateTime
     * @throws \Exception
     */
    public function getCloseAt() : ?\DateTime
    {
        return $this->close_at === null ? null : new \DateTime($this->close_at);
    }

    /**
     * top_start_atをDateTimeで取得
     *
     * @return ?\DateTime
     * @throws \Exception
     */
    public function getTopStartAt() : ?\DateTime
    {
        return $this->top_start_at === null ? null : new \DateTime($this->top_start_at);
    }

    /**
     * top_end_atをDateTimeで取得
     *
     * @return ?\DateTime
     * @throws \Exception
     */
    public function getTopEndAt() : ?\DateTime
    {
        return $this->top_end_at === null ? null : new \DateTime($this->top_end_at);
    }

    /**
     * 表示期間か？
     *
     * @param \DateTime $dateTime
     * @return bool
     * @throws \Exception
     */
    public function isOpen(\DateTime $dateTime) : bool
    {
        return $this->getOpenAt() <= $dateTime && $dateTime <= $this->getCloseAt();
    }

    /**
     * トップページ表示期間か？
     *
     * @param \DateTime $dateTime
     * @return bool
     * @throws \Exception
     */
    public function isTopStart(\DateTime $dateTime) : bool
    {
        return $this->getTopStartAt() <= $dateTime && $dateTime <= $this->getTopEndAt();
    }

    /**
     * 表示期間が始まる前のものか？
     *
     * @param \DateTime $dateTime
     * @return bool
     * @throws \Exception
     */
    public function isBeforeOpen(\DateTime $dateTime) : bool
    {
        return $dateTime < $this->getOpenAt();
    }

    /**
     * 表示期間が終了したものか？
     *
     * @param \DateTime $dateTime
     * @return bool
     * @throws \Exception
     */
    public function isClosed(\DateTime $dateTime) : bool
    {
        return $this->getCloseAt() < $dateTime;
    }

    /**
     * トップページ用のデータを取得
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getTopPageData() : \Illuminate\Support\Collection
    {
        return self::select(['id', 'title', DB::raw('UNIX_TIMESTAMP(open_at) AS open_at_ts')])
            ->whereRaw('top_start_at <= NOW()')
            ->whereRaw('top_end_at >= NOW()')
            ->orderBy('top_start_at', 'DESC')
            ->get();
    }

    /**
     * お知らせ一覧用の一覧データを取得
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getNoticeIndexPageData() : \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return self::whereRaw('open_at <= NOW()')
            ->whereRaw('close_at >= NOW()')
            ->orderBy('open_at', 'DESC')
            ->paginate(20);
    }
}
