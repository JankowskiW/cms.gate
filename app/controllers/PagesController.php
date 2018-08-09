<?php

namespace App\Controllers;

use App\Core\App;

class PagesController
{

    public function home()
    {
        return view('index');
    }

    public function pagenotfound()
    {
        return view('404notfound');
    }

    public function accessDenied()
    {
        return view('accessdenied');
    }

}
