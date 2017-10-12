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
    $series = \Hgs3\Models\Orm\GameSeries::all(['id', 'name']);

    $data = [];
    if ($withEmpty) {
        $data[0] = '';
    }

    $data += array_pluck($series, 'name', 'id');
    unset($series);

    return Form::select(
        $params['name'] ?? 'series_id',
        $data,
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
 * ユーザー名を表示
 *
 * @param array $hash
 * @param $userId
 * @return mixed|string
 */
function un(array $hash, $userId)
{
    return $hash[$userId] ?? '---';
}

/**
 * ユーザー名を表示
 *
 * @param array $hash
 * @param $userId
 * @return mixed|string
 */
function get_hash(array $hash, $id, $default = '---')
{
    return $hash[$id] ?? $default;
}

/**
 * CSRF用のタグを生成
 *
 * @param $token
 * @return string
 */
function csrf_tag($token)
{
    return new \Illuminate\Support\HtmlString('<input type="hidden" name="_token" value="'.$token.'">');
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
