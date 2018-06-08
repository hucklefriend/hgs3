<?php
/**
 * サイトバナー
 */

namespace Hgs3\Models\Site;

use Hgs3\Models\Orm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class Banner
{
    /**
     * 一覧用バナーファイルのアップロード
     *
     * @param Orm\Site $site
     * @param UploadedFile $file
     */
    public static function uploadListBannerFile(Orm\Site $site, UploadedFile $file)
    {
        // 今上がっているものがあれば削除
        self::deleteListBanner($site);

        $bannerDirectoryPath = base_path() . '/public/img/site_banner/';
        $fileNameBase = 'list_' . $site->id . '.';

        // アップロード
        $fileName = $fileNameBase . $file->getClientOriginalExtension();
        // 念のためファイルの有無チェック
        if (File::exists($bannerDirectoryPath . '/' . $fileName)) {
            File::delete($bannerDirectoryPath . '/' . $fileName);
        }

        $file->move($bannerDirectoryPath, $fileName);
        $site->list_banner_url = url('img/site_banner/' . $fileName);
    }

    /**
     * 今上がっている一覧用バナーファイルを削除
     *
     * @param Orm\Site $site
     */
    public static function deleteListBanner(Orm\Site $site)
    {
        $bannerDirectoryPath = base_path() . '/public/img/site_banner/';
        $fileNameBase = 'list_' . $site->id . '.';

        if ($site->list_banner_upload_flag == 2) {
            $fileName = $fileNameBase . substr($site->list_banner_url, strrpos($site->list_banner_url, '.'));
            if (File::exists($bannerDirectoryPath . '/' . $fileName)) {
                File::delete($bannerDirectoryPath . '/' . $fileName);
            }
        }
    }

    /**
     * 詳細用バナーファイルのアップロード
     *
     * @param Orm\Site $site
     * @param UploadedFile $file
     */
    public static function uploadDetailBannerFile(Orm\Site $site, UploadedFile $file)
    {
        // 今上がっているものがあれば削除
        self::deleteDetailBanner($site);

        $bannerDirectoryPath = base_path() . '/public/img/site_banner/';
        $fileNameBase = 'detail_' . $site->id . '.';

        // アップロード
        $fileName = $fileNameBase . $file->getClientOriginalExtension();
        // 念のためファイルの有無チェック
        if (File::exists($bannerDirectoryPath . '/' . $fileName)) {
            File::delete($bannerDirectoryPath . '/' . $fileName);
        }

        $file->move($bannerDirectoryPath, $fileName);
        $site->detail_banner_url = url('img/site_banner/' . $fileName);
    }

    /**
     * 今上がっている詳細用バナーファイルを削除
     *
     * @param Orm\Site $site
     */
    public static function deleteDetailBanner(Orm\Site $site)
    {
        $bannerDirectoryPath = base_path() . '/public/img/site_banner/';
        $fileNameBase = 'detail_' . $site->id . '.';

        if ($site->detail_banner_upload_flag == 2) {
            $fileName = $fileNameBase . substr($site->detail_banner_url, strrpos($site->detail_banner_url, '.'));
            if (File::exists($bannerDirectoryPath . '/' . $fileName)) {
                File::delete($bannerDirectoryPath . '/' . $fileName);
            }
        }
    }
}