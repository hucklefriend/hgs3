<?php
/**
 * ORM: game_packages
 */

namespace Hgs3\Models\Orm;

use Hgs3\Constants\Game\Shop;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class GamePackage extends \Eloquent
{
    protected $guarded = ['id'];

    /**
     * ハードに関連しているメーカーを取得
     *
     * @return BelongsTo
     */
    public function maker(): BelongsTo
    {
        return $this->belongsTo(GameCompany::class, 'company_id');
    }

    /**
     * ソフトを取得
     *
     * @return Collection
     */
    public function getSofts(): Collection
    {
        $packageLinks = GamePackageLink::where('package_id', $this->id)->get();
        if ($packageLinks->isEmpty()) {
            return new Collection();
        }

        return GameSoft::whereIn('id', $packageLinks->pluck('soft_id'))->get();
    }

    /**
     * データのハッシュを取得
     *
     * @param array $packageIds
     * @return array
     */
    public static function getHash(array $packageIds): array
    {
        if (empty($packageIds)) {
            return [];
        }

        $data = self::whereIn('id', $packageIds)
            ->get();

        $hash = [];
        foreach ($data as $row) {
            $hash[$row->id] = $row;
        }

        unset($data);

        return $hash;
    }

    /**
     * Amazonから取得できた情報を元に、画像情報をセット
     *
     * @param array $item
     */
    public function setImageByAmazon(array $item)
    {
        if (isset($item['small_image'])) {
            $this->small_image_url     = $item['small_image']['url'] ?? null;
            $this->small_image_width   = $item['small_image']['width'] ?? null;
            $this->small_image_height  = $item['small_image']['height'] ?? null;
        }

        if (isset($item['medium_image'])) {
            $this->medium_image_url = $item['medium_image']['url'] ?? null;
            $this->medium_image_width = $item['medium_image']['width'] ?? null;
            $this->medium_image_height = $item['medium_image']['height'] ?? null;
        }

        if (isset($item['large_image'])) {
            $this->large_image_url = $item['large_image']['url'] ?? null;
            $this->large_image_width = $item['large_image']['width'] ?? null;
            $this->large_image_height = $item['large_image']['height'] ?? null;
        }
    }

    /**
     * ショップ情報をセット
     */
    public function setShop()
    {
        $shops = GamePackageShop::where('package_id', $this->id)
            ->get();

        foreach ($shops as $shop) {
            switch ($shop->shop_id) {
                case Shop::AMAZON:
                    $this->asin = $shop->param1;
                    break;
            }
        }
    }
}
