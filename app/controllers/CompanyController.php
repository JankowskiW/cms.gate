<?php
/**
 * Created by PhpStorm.
 * User: waldemar
 * Date: 18.07.18
 * Time: 08:43
 */

namespace App\Controllers;

use App\Core\App;

class CompanyController
{
    public function show()
    {
        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0)
        {
            if($_SESSION['userType'] == 2)
            {
                $customerId = App::get('database')
                    ->table(['traders'])
                    ->select(['ID'])
                    ->where(["userID = '".$_SESSION['userId']."'"])
                    ->fetchColumn();
                $firmy = App::get('database')
                    ->table(['klienci'])
                    ->select(['id_firmy'])
                    ->whereIn("id_handlowca", $customerId)
                    ->fetchColumn();
            }
            $companies =  App::get('database')
                ->table(['firmy'])
                ->select([
                    'nazwa_firmy',
                    "DATE(data_utworzenia) as data_utworzenia",
                    'id as companyId']);
            if(isset($_SESSION['userType']) && $_SESSION['userType'] == 2)
            {
                $companies = $companies -> whereIn("id", $firmy);
            }
            $companies = $companies->fetch();
            return view('web/firmy', compact('companies'));
        }else{
            redirect ('accessdenied');
        }
    }

    public function settings()
    {

        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
//            die(var_dump($_POST));
            if (isset($_POST['save'])) {
                $_POST['dane_osobowe'] = isset($_POST['dane_osobowe']) ? 1 : 0;
                $_POST['materialy_reklamowe'] = isset($_POST['materialy_reklamowe']) ? 1 : 0;
                $companyId = $_POST['companyId'];
                unset($_POST['companyId']);
                unset($_POST['save']);
                $postTab = [];
                foreach ($_POST as $post) {
                    $postTab[] = $post;
                }
                App::get('database')
                    ->table(['firmy'])
                    ->update([
                        'nazwa_firmy',
                        'adres',
                        'ulica',
                        'miejscowosc',
                        'kraj',
                        'NIP',
                        'email',
                        'przetwarzanie_danych',
                        'otrzymywanie_materialow'
                    ], $postTab)
                    ->where(["id = " . $companyId])
                    ->execute();
                SessionController::setInfo("Zmieniono dane firmy.");
            } else {
                SessionController::setInfo("Anulowano edycje danych firmy " . $_POST['name'] . ".");
            }
            redirect('companies');
        }else{
            redirect ('accessdenied');
        }
    }

    public function add()
    {
        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            if (isset($_POST['add'])) {
                $_POST['dane_osobowe'] = isset($_POST['dane_osobowe']) ? 1 : 0;
                $_POST['materialy_reklamowe'] = isset($_POST['materialy_reklamowe']) ? 1 : 0;

                App::get('database')
                    ->table(['firmy'])
                    ->insert([
                        'nazwa_firmy' => $_POST['name'],
                        'NIP' => $_POST['nip'],
                        'email' => $_POST['email'],
                        'adres' => $_POST['address'],
                        'ulica' => $_POST['street'],
                        'miejscowosc' => $_POST['city'],
                        'kraj' => $_POST['country'],
                        'przetwarzanie_danych' => $_POST['dane_osobowe'],
                        'otrzymywanie_materialow' => $_POST['materialy_reklamowe']
                    ]);
                SessionController::setInfo("Dodano nowa firme.");
            } else {
                SessionController::setInfo("Anulowano dodawanie firmy.");
            }
            redirect('companies');
        }else{
            redirect('accessdenied');
        }
    }

    public function addCompany()
    {

        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            return view('web/firmy.dodaj');
        }else{
            redirect('accessdenied');
        }
    }

    public function companiesSettings()
    {

        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            if (isset($_GET['companyId'])) {
                $company = App::get('database')
                    ->table(['firmy'])
                    ->select([
                        'id',
                        'nazwa_firmy',
                        'adres',
                        'ulica',
                        'miejscowosc',
                        'kraj',
                        'NIP',
                        'email',
                        'przetwarzanie_danych',
                        'otrzymywanie_materialow',
                        'DATE(data_utworzenia) as data_utworzenia'
                    ])
                    ->where(["firmy.id = " . $_GET['companyId']])
                    ->fetch()[0];
                return view('web/firmy.ustawienia', compact('company'));
            } else {
                SessionController::setErrors("Nie wybrano firmy.");
                return view('web/firmy');
            }
        }else{
            redirect('accessdenied');
        }
    }

}