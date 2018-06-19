<?php
/**
 * アイコン設定コントローラー
 */

namespace Hgs3\Http\Controllers\User\Setting;

use Hgs3\Constants\IconRoundType;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Setting\ChangeIconImageRequest;
use Hgs3\Http\Requests\User\Setting\ChangeIconRoundRequest;
use Illuminate\Support\Facades\Auth;

class IconController extends Controller
{
    /**
     * アイコン変更
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeIcon()
    {
        $user = Auth::user();
        if ($user->icon_upload_flag == 1) {
            return view('user.setting.icon.changeIcon', [
                'user' => Auth::user()
            ]);
        } else {
            return view('user.setting.icon.changeIconImage', [
                'user' => Auth::user()
            ]);
        }
    }

    /**
     * アイコン丸み変更
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeIconRound()
    {
        // todo アップロードしてないとダメ

        return view('user.setting.icon.changeIconRound', [
            'user' => Auth::user()
        ]);
    }

    /**
     * アイコン丸み変更処理
     *
     * @param ChangeIconRoundRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateIconRound(ChangeIconRoundRequest $request)
    {
        $user = Auth::user();
        if ($user->icon_upload_flag == 1) {
            $user->icon_round_type = $request->icon_round_type;
            $user->save();
        }

        return redirect()->route('ユーザー設定');
    }

    /**
     * アイコン画像変更
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeIconImage()
    {
        return view('user.setting.icon.changeIconImage', [
            'user' => Auth::user()
        ]);
    }

    /**
     * アイコン画像変更
     *
     * @param ChangeIconImageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateIconImage(ChangeIconImageRequest $request)
    {
        $fileName = Auth::id() . '.' . $request->file('icon')->getClientOriginalExtension();

        $user = Auth::user();
        $user->deleteIconFile();

        $request->file('icon')->move(
            base_path() . '/public/img/user_icon/', $fileName
        );

        $user->icon_upload_flag = 1;
        $user->icon_file_name = $fileName;
        $user->icon_round_type = $request->icon_round_type;
        $user->save();

        return redirect()->route('ユーザー設定');
    }

    /**
     * アイコン削除
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteIcon()
    {
        $user = Auth::user();

        $user->icon_upload_flag = 0;
        $user->icon_file_name = null;
        $user->icon_round_type = IconRoundType::NONE;
        $user->save();

        $user->deleteIconFile();

        return redirect()->route('ユーザー設定');
    }
}
