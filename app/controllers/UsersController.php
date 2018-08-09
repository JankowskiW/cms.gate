<?php

namespace App\Controllers;

use App\Core\App;

class UsersController
{
    const randStrLen = 10;

    protected function randomString($len)
    {
        $chars = '0123456789abcdefghijklmnoperstuvwxyzABCDEFGHIJKLMNOPRSTUVWXYZ';
        $charslen = strlen($chars);
        $randomStr = '';
        for ($i = 0; $i < $len; $i++) {
            $randomStr .= $chars[rand(0, $charslen - 1)];
        }
        return $randomStr;
    }


    public function dashboard()
    {
        $daysCustomers = 30;
        $daysCompanies = 7;
        $numOfCustomers = DashboardController::countCustomers($daysCustomers);
        $numOfCompanies = DashboardController::countCompanies($daysCompanies);
//        $image = DashboardController::drawCompaniesGraph();
        return view('web/dashboard', compact('numOfCustomers','numOfCompanies', 'daysCustomers', 'daysCompanies'));
    }

    public function passwordResetGet()
    {
        return view('web/passwordReset');
    }

    public function passwordResetConfirm()
    {
        return view('web/passwordReset.confirm');
    }

    public function passwordReset()
    {

        if (isset($_POST['reset']) && isset($_POST['email'])) {

            $to = $_POST['email'];

            // Subject
            $subject = "Password reset. Gate-software CMS";

            $userData = App::get('database')
                ->table(['users'])
                ->select([
                    'ID',
                    'data_edycji'
                ])
                ->where(["email = '$to'"])
                ->fetch()[0];

            $userId = $userData->ID;
            $editTime = password_hash($userData->data_edycji, PASSWORD_DEFAULT);

            // Message
            $msg = '<html><body>';
            $msg .= '<h1>Wysłano prośbę o zresetowania hasła dla twojego adresu.</h1>';
            $msg .= '<p>Jeśli to nie ty prosiłeś o reset, zignoruj tą wiadomość.<br/>';
            $msg .= '<h3> Link do zresetowania hasła:</h3>';
            $msg .= "<a href='cms.gate/resetconfirmation?id=$userId&ctrl=$editTime'>Zresetuj hasło</a></p>";
            $msg .= '</body></html>';
            if (MailController::send($to, $subject, $msg)) {

//                App::get('database')
//                    ->table(['passwordreset'])
//                    ->insert([
//                        'userid' => $userId
//                    ]);
                $infoMsg = "Prośba o reset hasła została wysłana.";

            } else {
                $infoMsg = "E-mail z linkiem do resetowania hasła nie został wysłany, spróbuj ponownie.";
            }
            SessionController::setInfo($infoMsg);
            return view('web/login');
        }
    }

    public function pswdResetConfirmation()
    {
        $userId = $_GET['id'];
        $ctrl = $_GET['ctrl'];
        $userData = App::get('database')
            ->table(['users'])
            ->select([
                'email',
                'data_edycji'
            ])
            ->where(["id = $userId"])
            ->fetch()[0];
        $to = $userData->email;
        $editTime = $userData->data_edycji;

        if(password_verify($editTime, $ctrl))
        {
            $subject = "Password reset. Gate-software CMS";

            // Insert New Password to database
            $newPswd = $this->randomString(self::randStrLen);

            $msg = '<html><body>';
            $msg .= "<h1>Twoje nowe hasło to: $newPswd</h1>";
            $msg .= '<p>Zaloguj się używając nowego hasła a następnie zmień je w panelu użytkownia.<br/>';
            $msg .= "<a href='cms.gate/login'>Zaloguj się</a></p>";
            $msg .= '</body></html>';
            if (MailController::send($to, $subject, $msg)) {
                App::get('database')
                    ->table(['users'])
                    ->update(['password'], [password_hash($newPswd, PASSWORD_DEFAULT)])
                    ->where(["id = $userId"])
                    ->execute();

                $infoMsg = "Hasło zostało zresetowane, w ciagu kilku minut otrzymasz wiadomość z nowym hasłem.";
            } else {
                $infoMsg = "Wystąpił problem podczas próby resetowania hasła.";
            }
            SessionController::setInfo($infoMsg);
            redirect('login');
        }else
        {
            redirect ('404notfound');
        }
    }

    public function show()
    {
        $users = App::get('database')
            ->table(['traders'])
            ->select([
                'users.ID as ID',
                'users.email as email',
                'traders.imie_i_nazwisko as imie_i_nazwisko',
                'traders.numer_telefonu as numer_telefonu',
                'users.data_dodania as data_dodania',
                'user_type.type_name as grupa',
                'users.online as status'
            ])
            ->leftJoin('users','traders.userID','users.ID')
            ->leftJoin('user_type','users.ID_user_type','user_type.ID')
            ->fetch();
        return view('web/handlowcy', compact('users'));
    }


    public function tradersSettings()
    {
        if (isset($_GET['userId'])) {
            $types = App::get('database')
                ->table(['user_type'])
                ->select(['type_name', 'id'])
                ->fetch();
            $trader = App::get('database')
                ->table(['traders'])
                ->select([
                    'traders.id as id',
                    'traders.imie_i_nazwisko as imie_i_nazwisko',
                    'traders.stanowisko as stanowisko',
                    'traders.numer_telefonu as numer_telefonu',
                    'users.email as email',
                    'users.ID_user_type as ID_user_type',
                    'users.API_login as API_login'
                ])
                ->leftJoin('users', 'traders.userID', 'users.ID')
                ->where(['traders.id = ' . $_GET['userId']])
                ->fetch()[0];
            return view('web/handlowcy.ustawienia', compact('types', 'trader'));
        }else{
            SessionController::setErrors("Nie wybrano handlowca.");
            redirect('traders');
        }
    }

    public function settings()
    {
        if (isset($_POST['save'])) {
            $traderId = $_POST['traderId'];
            unset($_POST['traderId']);
            unset($_POST['save']);
            $usersTab = [];
            $usersTab[] = $_POST['user_type'];
            $usersTab[] = $_POST['email'];
            $usersTab[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $tradersTab = [];
            $tradersTab[] = $_POST['stanowisko'];
            $tradersTab[] = $_POST['kontakt'];
            $tradersTab[] = $_POST['imie_nazwisko'];
            if(strlen($_POST['api_login'])>0){
                $attNames = [
                    'ID_user_type',
                    'email',
                    'password',
                    'API_login'];
                $usersTab[] = $_POST['api_login'];
            }else
            {
                $attNames = [
                    'ID_user_type',
                    'email',
                    'password'];
            }
            App::get('database')
                ->table(['users'])
                ->update($attNames, $usersTab)
                ->where(["id = " . $traderId])
                ->execute();

            App::get('database')
                ->table(['traders'])
                ->update([
                    'stanowisko',
                    'numer_telefonu',
                    'imie_i_nazwisko',
                ], $tradersTab)
                ->where(["userID = " . $traderId])
                ->execute();

            SessionController::setInfo("Zmieniono dane klienta.");
        } else {
            SessionController::setInfo("Anulowano edycje danych klienta " . $_POST['imie_i_nazwisko'] . ".");
        }
        redirect('traders');
    }
}