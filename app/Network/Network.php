<?php
/**
 * ネットワークレイアウト
 */

namespace Hgs3\Network;

use Hgs3\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class Network
{
    /**
     * @var array
     */
    private $items = [];

    /**
     * アイテムを追加
     *
     * @param Item $item
     */
    public function addItem(Item $item)
    {
        $this->items[] = $item;
    }

    /**
     * 指定IDのアイテムを取得
     *
     * @param $id
     * @return mixed|null
     */
    public function getItem($id)
    {
        foreach ($this->items as $item) {
            if ($item->id === $id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * JSON文字列化
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * 配列化
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];

        foreach ($this->items as $item) {
            $result[] = $item->toArray();
        }

        return $result;
    }

    /**
     * jsonファイルからネットワークをロード
     *
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function load($id)
    {
        // TODO 先にmemcachedとかから取ってきてなかったらファイルから

        $path = resource_path('network/' . $id . '.json');

        try {
            $json = File::get($path);

            $items = json_decode($json);

            foreach ($items as $item) {
                $i = new Item();
                $i->set($item);
                $this->addItem($i);
            }

            // TODO memcachedとかに書き込む?
        } catch (\Exception $e) {
            Log::exceptionError($e);
            return false;
        }

        return true;
    }
}