<?php
/**
 * よみがなの種別
 */

namespace Hgs3\Constants;


class PhoneticType
{
    /**
     * ID => char
     *
     * @var array
     */
    private static $id2Char = array(
        1  => 'あ',
        2  => 'か',
        3  => 'さ',
        4  => 'た',
        5  => 'な',
        6  => 'は',
        7  => 'ま',
        8  => 'や',
        9  => 'ら',
        10 => 'わ',
    );

    /**
     * char => ID
     *
     * @var array
     */
    private static $char2Id = [
        'あ' => 1,
        'か' => 2,
        'さ' => 3,
        'た' => 4,
        'な' => 5,
        'は' => 6,
        'ま' => 7,
        'や' => 8,
        'ら' => 9,
        'わ' => 10,
    ];

    /**
     * ID => alphabet
     *
     * @var array
     */
    private static $id2Alphabet = [
        1  => 'a',
        2  => 'ka',
        3  => 'sa',
        4  => 'ta',
        5  => 'na',
        6  => 'ha',
        7  => 'ma',
        8  => 'ya',
        9  => 'ra',
        10 => 'wa',
    ];

    /**
     * ID => charの配列を取得
     *
     * @return array
     */
    public static function getId2CharData()
    {
        return self::$id2Char;
    }

    /**
     * char => IDの配列を取得
     *
     * @return array
     */
    public static function getChar2IdData()
    {
        return self::$char2Id;
    }

    /**
     * タイプを取得
     *
     * @param $char
     * @return mixed
     */
    public static function getType($char)
    {
        return self::$char2Id[$char];
    }

    /**
     * タイプを取得
     *
     * @param $type
     * @return mixed
     */
    public static function getChar($type)
    {
        return self::$id2Char[$type];
    }

    /**
     * アルファベットを取得
     *
     * @param $type
     * @return mixed
     */
    public static function getAlphabet($type)
    {
        return self::$id2Alphabet[$type];
    }

    /**
     * よみがなからタイプを取得
     *
     * @param $phonetic
     * @return int|string
     */
    public static function getTypeByPhonetic($phonetic)
    {
        $txt = [
            1  => '[あ-お]',
            2  => '[か-こが-ご]',
            3  => '[さ-そざ-ぞ]',
            4  => '[た-とだ-ど]',
            5  => '[な-の]',
            6  => '[は-ほば-ぼぱ-ぽ]',
            7  => '[ま-も]',
            8  => '[や-よ]',
            9  => '[ら-ろ]',
            10 => '[わ-ん]'
        ];

        foreach ($txt as $phoneticType => $pattern) {
            if (preg_match('/^' . $pattern . '/u', $phonetic)) {
                return $phoneticType;
            }
        }

        return 0;
    }
}