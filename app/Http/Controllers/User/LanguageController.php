<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($lang)
    {
        $available = ['id', 'en', 'ja', 'ko', 'zh-CN', 'ar', 'fr', 'de', 'es'];

        if (in_array($lang, $available)) {
            Session::put('locale', $lang);
            app()->setLocale($lang);
        }

        return redirect()->back();
    }
}
