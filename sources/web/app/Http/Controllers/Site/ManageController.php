<?php

namespace Hgs3\Http\Controllers\Site;

use Hgs3\Constants\UserRole;
use Hgs3\Http\Controllers\Controller;
use Hgs3\Models\Orm\Site;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    public function index()
    {
        return view('site.manage.list')->with([
            'sites' => Site::where('user_id', Auth::id())->orderBy('id')->get()
        ]);
    }

    public function add()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function remove()
    {

    }
}
