<?php
/**
 * Created by PhpStorm.
 * User: waldemar
 * Date: 18.07.18
 * Time: 11:33
 */

namespace App\Controllers;

use App\Core\App;

class CustomersController
{
    public function show()
    {
        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            if (isset($_GET['companyId'])) {
                $conditions[] = 'firmy.id = ' . $_GET['companyId'];
            }
            if ($_SESSION['userType'] == 2) {
                $traderId = App::get('database')
                    ->table(['traders'])
                    ->select(['ID'])
                    ->where(["userID = " . $_SESSION['userId']])
                    ->fetchColumn();
                if(count(array_filter($traderId)))
                {
                    $traderId = $traderId[0];
                    $conditions[] = 'klienci.id_handlowca = ' . $traderId;
                }else
                {
                    $conditions[] = 'klienci.id_handlowca = 0';
                }
            }

            $customers = App::get('database')
                ->table(['klienci'])
                ->select([
                    'klienci.id as ID',
                    'firmy.nazwa_firmy as nazwa_firmy', 'klienci.imie_i_nazwisko as klient',
                    'klienci.numer_telefonu as numer_telefonu',
                    'klienci.data_rejestracji as data_rejestracji',
                    'traders.imie_i_nazwisko as handlowiec',
                    'klienci.sciezka_skan as skan'
                ])
                ->leftJoin('firmy', 'klienci.id_firmy', 'firmy.id')
                ->leftJoin('traders', 'klienci.id_handlowca', 'traders.ID');
            if (isset($conditions)) {
                $customers = $customers->where($conditions);
            }
            $customers = $customers->fetch();
            return view('/web/kontakty', compact('customers', 'companyName'));
        }else{
            redirect ('accessdenied');
        }
    }

    public function settings()
    {

        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            if (isset($_POST['save'])) {
                $_POST['dane_osobowe'] = isset($_POST['dane_osobowe']) ? 1 : 0;
                $_POST['materialy_reklamowe'] = isset($_POST['materialy_reklamowe']) ? 1 : 0;
                $customerId = $_POST['customerId'];
                unset($_POST['customerId']);
                unset($_POST['save']);
                $postTab = [];
                foreach ($_POST as $post) {
                    $postTab[] = $post;
                }
                App::get('database')
                    ->table(['klienci'])
                    ->update([
                        'imie_i_nazwisko',
                        'stanowisko',
                        'numer_telefonu',
                        'email',
                        'przetwarzanie_danych',
                        'otrzymywanie_materialow',
                        'id_handlowca'
                    ], $postTab)
                    ->where(["id = " . $customerId])
                    ->execute();
                SessionController::setInfo("Zmieniono dane klienta.");
            } else {
                SessionController::setInfo("Anulowano edycje danych klienta " . $_POST['imie_i_nazwisko'] . ".");
            }
            redirect('kontakty');
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
                    ->table(['klienci'])
                    ->insert([
                        'imie_i_nazwisko' => $_POST['imie_i_nazwisko'],
                        'stanowisko' => $_POST['stanowisko'],
                        'numer_telefonu' => $_POST['telefon'],
                        'email' => $_POST['email'],
                        'przetwarzanie_danych' => $_POST['dane_osobowe'],
                        'otrzymywanie_materialow' => $_POST['materialy_reklamowe'],
                        'id_handlowca' => $_POST['handlowiec'],
                        'id_firmy' => $_POST['company']
                    ]);
                $id_klienta = App::get('database')
                    ->table(['klienci'])
                    ->select(['id'])
                    ->where(["email = '".$_POST['email']."'"])
                    ->fetchColumn()[0];
                    foreach($_POST['answers'] as $key => $answers)
                    {
                        if(is_array($answers))
                        {
                            foreach($answers as $answer)
                            {
                                App::get('database')
                                    ->table(['odpowiedzi_klientow'])
                                    ->insert([
                                        "id_klienta" => $id_klienta,
                                        "id_pytania" => $key,
                                        "id_odpowiedzi" => $answer
                                    ]);
                            }

                        }else
                        {
                            App::get('database')
                                ->table(['odpowiedzi_klientow'])
                                ->insert([
                                    "id_klienta" => $id_klienta,
                                    "id_pytania" => $key,
                                    "id_odpowiedzi" => $answers,
                                ]);
                        }
                    }
                    foreach($_POST['answersTxt'] as $key => $answers)
                    {
                        if(is_array($answers))
                        {
                            foreach($answers as $answer)
                            {
                                App::get('database')
                                    ->table(['odpowiedzi_klientow_txt'])
                                    ->insert([
                                        "id_klienta" => $id_klienta,
                                        "id_pytania" => $key,
                                        "tresc" => $answer
                                    ]);
                            }

                        }else
                        {
                            App::get('database')
                                ->table(['odpowiedzi_klientow_txt'])
                                ->insert([
                                    "id_klienta" => $id_klienta,
                                    "idpytania" => $key,
                                    "tresc" => $answers
                                ]);
                        }
                    }
                SessionController::setInfo("Dodano nowego klienta.");
            } else {
                SessionController::setInfo("Anulowano dodawanie nowego klienta.");
            }
            redirect('kontakty');
        }else
        {
            redirect('accessdenied');
        }
    }
    public function customersSettings()
    {

        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            $traders = App::get('database')
                ->table(['traders'])
                ->select(['ID', 'imie_i_nazwisko as name'])
                ->fetch();

            $customer = App::get('database')
                ->table(['klienci'])
                ->select([
                    'id',
                    'imie_i_nazwisko',
                    'stanowisko',
                    'numer_telefonu',
                    'email',
                    'przetwarzanie_danych',
                    'otrzymywanie_materialow',
                    'id_handlowca'
                ])
                ->where(['klienci.id = ' . $_GET['customerId']])
                ->fetch()[0];
            $companyName = App::get('database')
                ->table(['firmy'])
                ->select(['firmy.nazwa_firmy as nazwa'])
                ->leftJoin('klienci', 'firmy.id', 'klienci.id_firmy')
                ->where(['klienci.id = ' . $_GET['customerId']])
                ->fetch()[0]->nazwa;
            return view('web/kontakty.ustawienia', compact('traders', 'companyName', 'customer'));
        }else{
            redirect('accessdenied');
        }
    }

    public function addCustomer()
    {
        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            $traders = App::get('database')
                ->table(['traders'])
                ->select(['ID', 'imie_i_nazwisko as name'])
                ->fetch();
            $companies = App::get('database')
                ->table(['firmy'])
                ->select(['id', 'nazwa_firmy as name'])
                ->fetch();

            $questions = App::get('database')
                ->table(['pytania'])
                ->select([
                    "id",
                    "tresc",
                    "typ_odpowiedzi"
                ])
                ->fetch();
            $answers = App::get('database')
                ->table(['odpowiedzi'])
                ->select([
                    "ID as id",
                    "ID_pytania as id_pytania",
                    "tresc"
                ])
                ->fetch();
            return view('web/kontakty.add', compact('traders', 'companies', 'questions','answers'));
        }else{
            redirect('accessdenied');
        }
    }

}

