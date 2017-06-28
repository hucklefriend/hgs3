<?php
namespace Hgs3\Http\Controllers\User;

use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function index()
    {
        return view('alpha/top');
    }

    public function follower()
    {

    }

    public function add()
    {
        return view('mypage.profile');
    }

    public function remove()
    {

    }
}
