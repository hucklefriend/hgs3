<?php
namespace Hgs3\Http\Controllers;

use Hgs3\Http\Controllers\Controller;

class TopController extends Controller
{
    public function index()
    {
        return view('top');
    }
}
