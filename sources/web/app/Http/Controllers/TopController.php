<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TopController extends Controller
{
    public function index()
    {
        // ログイン中ならマイページ

        return view('top');
    }
}
