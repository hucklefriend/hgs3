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
 * HGS3用url
 *
 * @param $path
 * @param array $parameters
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 */
function url2($path, $parameters = [])
{
    // 準備できたら全部secureにしたいけど、
    // まだできるかわからないのでラッパーで対応

    return url($path, $parameters, false);
}

function un(array $hash, $userId)
{
    return $hash[$userId] ?? '---';
}