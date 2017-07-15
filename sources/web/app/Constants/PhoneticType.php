<?php

namespace Hgs3\Constants;


class PhoneticType
{
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

    public static function getId2CharData()
    {
        return self::$id2Char;
    }

    public static function getChar2IdData()
    {
        return self::$char2Id;
    }

    public static function getType($char)
    {
        return self::$char2Id[$char];
    }

    public static function getChar($type)
    {
        return self::$id2Char[$type];
    }

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

        $result = array();

        foreach ($txt as $phoneticType => $pattern) {
            if (preg_match('/^' . $pattern . '/u', $phonetic)) {
                return $phoneticType;
            }
        }

        return 0;
    }
}