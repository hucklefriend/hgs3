<?php
namespace Hgs3\Http\Controllers\Master;

use Hgs3\Mail\ProvisionalRegistration;
use Illuminate\Http\Request;
use Hgs3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TopController extends Controller
{
    public function index()
    {
        return view('master.index');
    }
}
