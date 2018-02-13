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
function format_date($unix_timestamp)
{
    return date('Y年n月j日 G時', $unix_timestamp) . intval(date('i', $unix_timestamp)) . '分';
}

function follow_status_icon(array $followStatus, $targetUserId)
{
    return new \Illuminate\Support\HtmlString(\Hgs3\Constants\FollowStatus::getIcon($followStatus[$targetUserId] ?? \Hgs3\Constants\FollowStatus::NONE));
}

