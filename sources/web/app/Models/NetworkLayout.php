<?php
/**
 * ネットワークレイアウト
 */

namespace Hgs3\Models;

use Hgs3\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class NetworkLayout
{
    private static function getPath($id)
    {
        return resource_path('network/' . $id . '.json');
    }


    public static function load($id)
    {
        // TODO 先にmemcachedとかから取ってきてなかったらファイルから

        $path = self::getPath($id);

        try {
            $json = File::get($path);

            $data = self::generate(json_decode($json), true);

            // TODO memcachedとかに書き込む

            return $data;
        } catch (\Exception $e) {
            Log::exceptionError($e);
            return false;
        }

        return false;
    }


    private static function generate($json, $isLoadChild)
    {
        // 子の数を計算
        $json->main->childNum = isset($json->children) ? count($json->children) : 0;

        // DOMを取得
        $json->main->dom = self::renderItem($json->main->id);

        if (isset($json->children)) {
            // 子の処理
            foreach ($json->children as &$child) {
                $child->dom = self::renderItem($child->id);

                if ($isLoadChild) {
                    // 自分がメインになった時用のデータを取得
                    $path = self::getPath($child->id);
                    if (File::exists($path)) {
                        $json2 = File::get($path);
                        $json2 = json_decode($json2);
                        $child->mainMode = self::generate($json2, false);
                        $child->childNum = count($json2->children);
                        unset($json2);
                    }
                }
            }
        }

        return $json;
    }

    private static function renderItem($id)
    {
        return view('network-item/' . $id)->render();
    }
}