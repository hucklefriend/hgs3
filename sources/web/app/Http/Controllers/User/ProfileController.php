<?php
/**
 * プロフィールコントローラー
 */

namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;
use Hgs3\Http\Requests\User\Profile\UpdateRequest;
use Hgs3\Models\User\Profile;
use Hgs3\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * プロフィール
     *
     * @return $this
     */
    public function index(User $user)
    {
        $profile = new Profile();
        $data = $profile->get($user->id);
        $data['user'] = $user;
        $data['isMyself'] = Auth::id() == $user->id;

        return view('user.profile.index')->with($data);
    }

    /**
     * プロフィール
     *
     * @return $this
     */
    public function myself()
    {
        return $this->index(Auth::user());
    }

    /**
     * プロフィール編集
     *
     * @return $this
     */
    public function edit()
    {
        return view('user.profile.edit')->with([
            'isUpdated' => false,
            'user'      => Auth::user()
        ]);
    }

    /**
     * プロフィール編集
     *
     * @param UpdateRequest $request
     * @return $this
     */
    public function update(UpdateRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->get('name') ?? '';
        $user->adult = intval($request->get('adult') ?? 0);
        if ($user->adult != 1) {
            $user->adult = 0;
        }

        $user->save();

        return view('user.profile.edit')->with([
            'isUpdated' => true,
            'user'      => $user
        ]);
    }
}
