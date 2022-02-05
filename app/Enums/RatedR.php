<?php
/**
 * R指定
 */

namespace Hgs3\Enums;

enum RatedR: int
{
    case None = 0;
    case R15  = 1;
    case R18  = 2;

    /**
     * テキストを取得
     *
     * @return string
     */
    public function text(): string
    {
        return match($this) {
            RatedR::None => '全年齢',
            RatedR::R15  => 'R-15',
            RatedR::R18  => 'R-18',
        };
    }

    /**
     * IDとテキストの配列を取得
     *
     * @return string[]
     */
    public static function toTextArray(): array
    {
        $result = [];

        foreach (self::cases() as $case) {
            $result[$case->value] = $case->text();
        }

        return $result;
    }
}