<?php
namespace Hgs3\Http\Controllers\User;

use Hgs3\Http\Controllers\Controller;

class MyPageController extends Controller
{
    public function list()
    {
        return view('mypage.index');
    }
}
