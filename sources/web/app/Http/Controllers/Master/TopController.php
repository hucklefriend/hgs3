<?php
namespace Hgs3\Http\Controllers\Master;

use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;

class TopController extends Controller
{
    public function index()
    {
        return view('master.index');
    }
}
