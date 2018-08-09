<?php

namespace App\Controllers;

use App\Core\App;

class LoginController
{
    protected function filter($filteredVar)
    {
        if (get_magic_quotes_gpc())
            $filteredVar = stripslashes($filteredVar);
        return (htmlspecialchars(trim($filteredVar)));
    }


    public function login()
    {

        if((!isset($_SESSION['userType'])) || $_SESSION['userType'] == 0) {
            return view('web/login');
        }else{
            redirect ('');
        }
    }

    public function loginValidation()
    {
        if (isset($_POST['login'])) {
            $email = $this->filter($_POST['email']);
            $userData = App::get('database')
                ->table(['users'])
                ->select(['ID', 'email', 'password', 'ID_user_type'])
                ->where(["email = '$email'"])
                ->fetch()[0];
            if ($userData->email == null) {
                $errMsg = "Taki email nie istnieje. <a href='register'>Zarejestruj się</a>";
                SessionController::setErrors($errMsg);
                redirect('login');
            } else {
                if (!password_verify($_POST['password'], $userData->password)) {
                    $errMsg = "Bledne haslo. <a href='passwordreset'>Zapomniałeś hasła?</a>";
                    SessionController::setErrors($errMsg);
                    redirect('login');
                } else {
                    if (SessionController::start(
                        $userData->ID,
                        $userData->email,
                        $userData->ID_user_type)) {
                        $infoMsg = "Witaj na naszej stronie.";
                        App::get('database')
                            ->table(['users'])
                            ->update(['online'], [1])
                            ->where(["id = $userData->ID"])
                            ->execute();

                    }else
                    {
                        $infoMsg = "Blad podczas logowania. Sprobuj ponownie.";
                    }
                    SessionController::setInfo($infoMsg);
                    redirect('');
                }
            }

        } else {
            redirect('login');
        }
    }

    public function logout()
    {
        if(isset($_SESSION['userType']) && $_SESSION['userType'] != 0) {
            if ($userId = SessionController::destroy()) {
                var_dump("LOGOUT");
                App::get('database')
                    ->table(['users'])
                    ->update(['online'], [0])
                    ->where(["id = $userId"])
                    ->execute();

            } else {
                $infoMsg = "Blad podczas wylogowywania. Upewnij sie, ze zostales wylogowany.";
            }
            $infoMsg = "Zostałeś wylogowany";
            SessionController::setInfo($infoMsg);
            redirect('');
        }
        redirect('');
    }


}