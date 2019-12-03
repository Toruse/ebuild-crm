<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.setting.index');
    }
}