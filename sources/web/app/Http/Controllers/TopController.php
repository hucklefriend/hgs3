<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TopController extends Controller
{
    /**
     * 指定ユーザのプロフィール表示
     *
     * @return Response
     */
    public function index()
    {
        return view('alpha/top');
    }
}
