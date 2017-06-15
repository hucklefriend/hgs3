<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FollowerController extends Controller
{
    public function index()
    {
        return view('alpha/top');
    }

    public function add()
    {
        return view('mypage.profile');
    }

    public function remove()
    {

    }
}
