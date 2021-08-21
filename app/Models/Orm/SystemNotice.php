<?php
/**
 * お知らせ
 */

namespace Hgs3\Models\Orm;

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
}
