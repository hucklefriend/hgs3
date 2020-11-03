<?php
/**
 * メッセージコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Requests\User\MessageRequest;
use Hgs3\Models\Orm;
use Hgs3\Models\User;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * メッセージの表示
     *
     * @param Orm\Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Orm\Message $message)
    {
        if ($message->is_read == 0) {
            $message->is_read = 1;
            $message->save();
        }

        return view('user.message.show', [
            'message'     => $message,
            'receiveUser' => User::find($message->to_user_id),
            'sendUser'    => User::find($message->from_user_id),
        ]);
    }

    /**
     * メッセージの入力
     *
     * @param $resId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function input($resId)
    {
        $res = null;
        $resId = intval($resId);
        if ($resId != 0) {
            $res = Orm\Message::find($resId);
            if ($res != null && $res->from_user_id != Auth::id()) {
                $res = null;
            }
        }

        return view('user.message.input', [
            'res'   => $res,
            'resId' => $resId
        ]);
    }

    /**
     * フォローする
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function write(MessageRequest $request)
    {
        $message = new Orm\Message();
        $message->to_user_id = 1;
        $message->from_user_id = Auth::id();
        $message->res_id = $request->get('res_id', 0);
        if (empty($message->res_id)) {
            $message->res_id = null;
        }
        $message->message = $request->get('message', '');
        $message->is_read = 0;
        $message->save();

        return redirect()->route('プロフィール2', ['showId' => Auth::user()->show_id, 'show' => 'message']);
    }

    /**
     * 管理人入力
     *
     * @param User $user
     * @param $resId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminInput(User $user, $resId)
    {
        $res = null;
        $resId = intval($resId);
        if ($resId != 0) {
            $res = Orm\Message::find($resId);
            if ($res != null && $res->from_user_id != Auth::id()) {
                $res = null;
            }
        }

        return view('user.message.inputAdmin', [
            'res'   => $res,
            'resId' => $resId,
            'user'  => $user
        ]);
    }

    /**
     * 管理人からメッセージ送信
     *
     * @param MessageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminWrite(MessageRequest $request, User $user)
    {
        $message = new Orm\Message();
        $message->to_user_id = $user->id;
        $message->from_user_id = 1;
        $message->res_id = $request->get('res_id', 0);
        if (empty($message->res_id)) {
            $message->res_id = null;
        }
        $message->message = $request->get('message', '');
        $message->is_read = 0;
        $message->save();

        return redirect()->back();
    }
}
