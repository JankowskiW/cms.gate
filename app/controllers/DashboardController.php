<?php
/**
 * Created by PhpStorm.
 * User: waldemar
 * Date: 23.07.18
 * Time: 08:19
 */

namespace App\Controllers;

use App\Core\App;

class DashboardController
{

    public function countCustomers($days)
    {
        $customers = App::get('database')
            ->table(['klienci'])
            ->select(['count(*) as ilosc'])
            ->where(['data_rejestracji >= adddate(curdate(), interval -' . $days . ' day)'])
            ->fetch()[0]->ilosc;
        return $customers;
    }

    public function countCompanies($days)
    {
        $companies = App::get('database')
            ->table(['firmy'])
            ->select(['count(*) as ilosc'])
            ->where(['data_utworzenia >= adddate(curdate(), interval -' . $days . ' day)'])
            ->fetch()[0]->ilosc;
        return $companies;
    }

    public function drawCompaniesGraph()
    {
        $canvas = imagecreate(750,300);
        $white = imagecolorallocate($canvas, 255,255,255);
        imageline($canvas, 1,4,500,340, $white);
        return $canvas;

    }
}