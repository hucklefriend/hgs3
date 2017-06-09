<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FollowController extends Controller
{
    public function list()
    {
        return view('mypage.index');
    }
}
