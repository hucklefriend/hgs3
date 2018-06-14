<?php

/**
 * 会社選択SELECTを生成
 *
 * @param $companyId
 * @param $withEmpty
 * @param array $params
 * @return \Illuminate\Support\HtmlString
 */
function company_select($companyId, $withEmpty, $params = [])
{
    $companies = \Hgs3\Models\Orm\GameCompany::all(['id', 'name']);

    $data = [];
    if ($withEmpty) {
        $data[0] = '';
    }

    $data += array_pluck($companies, 'name', 'id');
    unset($companies);

    return Form::select(
        $params['name'] ?? 'company_id',
        $data,
        $companyId,
        [
            'class' => 'form-control',
            'id'    => $params['id'] ?? 'company_id'
        ]
    );
}

/**
 * シリーズ選択SELECTを生成
 *
 * @param $seriesId
 * @param $withEmpty
 * @param array $params
 * @return \Illuminate\Support\HtmlString
 */
function series_select($seriesId, $withEmpty, $params = [])
{
    $series = \Hgs3\Models\Orm\GameSeries::orderBy('phonetic')
        ->select(['id', 'name'])
        ->get()
        ->pluck('name', 'id')
        ->toArray();

    if ($withEmpty) {
        $series = [0 => ''] + $series;
    }

    return Form::select(
        $params['name'] ?? 'series_id',
        $series,
        $seriesId,
        [
            'class' => 'form-control',
            'id'    => $params['id'] ?? 'series_id'
        ]
    );
}

/**
 * ゲーム種別選択SELECTを生成
 *
 * @param $gameType
 * @param array $params
 * @return \Illuminate\Support\HtmlString
 */
function game_type_select($gameType, $params = [])
{
    return Form::select(
        $params['name'] ?? 'game_type',
        \Hgs3\Constants\GameType::getSelectOptions(),
        $gameType,
        [
            'class' => 'form-control',
            'id'    => $params['id'] ?? 'game_type'
        ]
    );
}

/**
 * プラットフォーム選択SELECTを生成
 *
 * @param $platformId
 * @param array $params
 * @return \Illuminate\Support\HtmlString
 */
function platform_select($platformId, $params = [])
{
    return Form::select(
        $params['name'] ?? 'platform_id',
        array_pluck(\Hgs3\Models\Orm\GamePlatform::all(['id', 'name']), 'name', 'id'),
        $platformId,
        [
            'class' => 'form-control',
            'id'    => $params['id'] ?? 'platform_id'
        ]
    );
}

/**
 * 年選択SELECTを生成
 *
 * @param int $year
 * @param array $params
 * @return \Illuminate\Support\HtmlString
 */
function year_select($year, $params = [], $startYear = null, $endYear = null)
{
    if ($startYear === null) {
        $startYear = 2018;
    }
    if ($endYear === null) {
        $endYear = date('Y');
    }

    $values = [];
    for ($y = $startYear; $y <= $endYear; $y++) {
        $values[$y] = $y;
    }

    return Form::select(
        $params['name'] ?? 'year',
        $values,
        $year,
        [
            'class' => 'form-control',
            'id'    => $params['id'] ?? 'year'
        ]
    );
}

/**
 * 月選択SELECTを生成
 *
 * @param int $month
 * @param array $params
 * @return \Illuminate\Support\HtmlString
 */
function month_select($month, $params = [])
{
    $values = [];
    for ($m = 1; $m <= 12; $m++) {
        $values[$m] = $m;
    }

    return Form::select(
        $params['name'] ?? 'year',
        $values,
        $month,
        [
            'class' => 'form-control',
            'id'    => $params['id'] ?? 'year'
        ]
    );
}

/**
 * HGS3用URL生成
 *
 * @param $path
 * @param array $parameters
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function url2($path)
{
    // urlと違って相対パスを生成する
    return env('URL_BASE', '/') . ltrim($path, '/');
    //return url($path, $parameters, false);
}
/**
 * ハッシュからキーの値を取得
 * hv は hash_valueの略
 *
 * @param array $hash
 * @param $userId
 * @return mixed|string
 */
function hv(array $hash, $key, $default = '---')
{
    return $hash[$key] ?? $default;
}


/**
 * checkboxとradioボタンのchecked判定
 *
 * @param $val1
 * @param $val2
 * @return string
 */
function checked($val1, $val2)
{
    if ($val1 == $val2) {
        return ' checked';
    }

    return '';
}

function invalid($errors, $formName)
{
    if ($errors->has($formName)) {
        return ' is-invalid';
    }

    return '';
}
function selected($val1, $val2)
{
    if ($val1 == $val2) {
        return ' selected';
    }

    return '';
}

/**
 * checkboxとradioボタンのchecked判定
 *
 * @param $val1
 * @param $val2
 * @return string
 */
function active($val1, $val2)
{
    if ($val1 == $val2) {
        return ' active';
    }

    return '';
}

/**
 * 必要以上に多い改行を取り除く
 *
 * @param $text
 * @return string
 */
function cut_new_line($text)
{
    return trim(preg_replace("/(\r\n){3,}|\r{3,}|\n{3,}/", "\n\n", $text));
}


function is_data_editor()
{
    return \Hgs3\Constants\UserRole::isDataEditor();
}

function is_admin()
{
    return \Hgs3\Constants\UserRole::isAdmin();
}

function array_to_hash(array $data, $key)
{
    $hash = [];

    foreach ($data as $row) {
        $hash[$row[$key]] = $row;
    }

    return $hash;
}

/**
 * 条件に一致しなければdisplay:noneを返す
 *
 * @param mixed $param
 * @param mixed $value
 * @return string
 */
function display_none($param, $value)
{
    if ($param != $value) {
        return 'display:none;';
    }

    return '';
}

/**
 * input[type=datetime_local]用の値生成
 *
 * @param $date
 * @return string
 */
function format_date_local($date)
{
    $timestamp = strtotime($date);

    return date('Y-m-d', $timestamp) . 'T' . date('H:i', $timestamp);
}


/**
 * ページャーからキーの配列を取得
 *
 * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator $pager
 * @param string $key
 * @return array
 */
function page_pluck(\Illuminate\Contracts\Pagination\LengthAwarePaginator $pager, $key)
{
    return $pager->pluck($key)->toArray();
}

/**
 * 日付変換
 *
 * @param $unix_timestamp
 * @return false|string
 */
function format_date($timestamp)
{
    if ($GLOBALS['today_start_timestamp'] <= $timestamp && $timestamp <= $GLOBALS['today_end_timestamp']) {
        return date('今日 H:i', $timestamp);
    } else if ($GLOBALS['yesterday_start_timestamp'] <= $timestamp && $timestamp <= $GLOBALS['yesterday_end_timestamp']) {
        return date('昨日 H:i', $timestamp);
    }

    return date('Y.n.j H:i', $timestamp);
}

function format_date2($timestamp)
{
    if ($GLOBALS['today_start_timestamp'] <= $timestamp && $timestamp <= $GLOBALS['today_end_timestamp']) {
        return date('今日', $timestamp);
    } else if ($GLOBALS['yesterday_start_timestamp'] <= $timestamp && $timestamp <= $GLOBALS['yesterday_end_timestamp']) {
        return date('昨日', $timestamp);
    }

    return date('Y.n.j', $timestamp);
}

/**
 * 相互フォローアイコン
 *
 * @param array $followStatus
 * @param $targetUserId
 * @return \Illuminate\Support\HtmlString
 */
function follow_status_icon(array $followStatus, $targetUserId)
{
    return new \Illuminate\Support\HtmlString(\Hgs3\Constants\FollowStatus::getIcon($followStatus[$targetUserId] ?? \Hgs3\Constants\FollowStatus::NONE));
}

function small_image($package)
{
    $url = small_image_url($package, true);

    return new \Illuminate\Support\HtmlString(sprintf('<img data-normal="%s">', e($url)));
}

/**
 * 小さいパッケージ画像を優先して取得
 *
 * @param $package
 * @param $withNoImage
 * @return string
 */
function small_image_url($package, $withNoImage = false)
{
    $noImageUrl = $withNoImage ? url('img/pkg_no_img_s.png') : '';

    if ($package == null) {
        return $noImageUrl;
    }

    if ($package->is_adult) {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return $noImageUrl;
        }
        if (!\Illuminate\Support\Facades\Auth::user()->isAdult()) {
            return $noImageUrl;
        }
    }

    $imageUrl = $noImageUrl;
    if (!empty($package->small_image_url)) {
        $imageUrl = $package->small_image_url;
    } else if (!empty($package->medium_image_url)) {
        $imageUrl = $package->medium_image_url;
    } else if (!empty($package->large_image_url)) {
        $imageUrl = $package->large_image_url;
    }

    return $imageUrl;
}

/**
 * 中→大→小パッケージを優先して取得
 *
 * @param $package
 * @return string
 */
function medium_image_url($package)
{
    $imageUrl = '';

    if ($package->is_adult) {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return '';
        }
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->adult != 1) {
            return '';
        }
    }

    if (!empty($package->medium_image_url)) {
        $imageUrl = $package->medium_image_url;
    } else if (!empty($package->large_image_url)) {
        $imageUrl = $package->large_image_url;
    } else if (!empty($package->small_image_url)) {
        $imageUrl = $package->small_image_url;
    }

    return $imageUrl;
}

/**
 * 大きいパッケージを優先して取得
 *
 * @param $package
 * @return string
 */
function large_image_url($package)
{
    $imageUrl = '';

    if ($package->is_adult) {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return '';
        }
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user->adult != 1) {
            return '';
        }
    }

    if (!empty($package->large_image_url)) {
        $imageUrl = $package->large_image_url;
    } else if (!empty($package->medium_image_url)) {
        $imageUrl = $package->medium_image_url;
    } else if (!empty($package->small_image_url)) {
        $imageUrl = $package->small_image_url;
    }

    return $imageUrl;
}

/**
 * 各SNSのアイコンを取得
 *
 * @param $socialSiteId
 * @return \Illuminate\Support\HtmlString
 */
function sns_icon($socialSiteId)
{
    return \Hgs3\Constants\SocialSite::getIcon($socialSiteId);
}

/**
 * グローバルバック用のroute
 *
 * @param $name
 * @param array $parameters
 * @param bool $absolute
 * @return string
 */
function gb_route($name, $parameters = [], $absolute = true)
{
    return \Hgs3\Http\GlobalBack::route($name, $parameters, $absolute);
}

/**
 * フッターの広告を消す
 */
function disable_footer_sponsored()
{
    \Illuminate\Support\Facades\View::share('disableFooterSponsored', true);
}

/**
 * サイトの一覧用バナー
 *
 * @param $site
 * @return string
 */
function list_banner($site)
{
    $url = '';

    if (!empty($site->list_banner_url)) {
        $url = $site->list_banner_url;
    }

    if (\Illuminate\Support\Facades\Auth::check()) {
        if (\Illuminate\Support\Facades\Auth::user()->isAdult() && !empty($site->list_banner_url_r18)) {
            $url = $site->list_banner_url_r18;
        }
    }

    return $url;
}


/**
 * サイトの詳細用バナー
 *
 * @param $site
 * @return string
 */
function detail_banner($site)
{
    $url = '';

    if (!empty($site->detail_banner_url)) {
        $url = $site->detail_banner_url;
    }

    if (\Illuminate\Support\Facades\Auth::check()) {
        if (\Illuminate\Support\Facades\Auth::user()->isAdult() && !empty($site->detail_banner_url_r18)) {
            $url = $site->detail_banner_url_r18;
        }
    }

    return $url;
}
